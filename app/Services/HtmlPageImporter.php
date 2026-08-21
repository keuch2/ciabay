<?php

namespace App\Services;

use App\Exceptions\HtmlImportException;
use App\Models\Page;
use App\Models\PageImport;
use App\Services\HtmlImport\CssScoper;
use App\Services\HtmlImport\DataUriExtractor;
use App\Services\HtmlImport\HtmlBalancer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

/**
 * Convierte una maqueta HTML standalone (single-file, con <style>, <script>
 * y media embebida como data URIs) en una página del CMS con template
 * 'html-import'. Automatiza el pipeline que se aplicó a mano a las
 * plantillas hard-coded (nidera, vence-tudo, etc.):
 *
 *   1. separa <style>, body y <script> inline
 *   2. extrae la media base64 a storage (dedup por contenido)
 *   3. scopea el CSS bajo .html-import (CssScoper)
 *   4. envuelve el JS en una IIFE
 *   5. persiste: CSS + media en storage/imported-pages/{page_id}/,
 *      body y JS procesados en la tabla page_imports
 *
 * Todo el parseo ocurre en memoria; si algo falla, no queda nada a medias.
 * La extracción es por substring/regex a propósito: preserva el markup byte
 * a byte (DOMDocument re-serializa y altera HTML5).
 */
class HtmlPageImporter
{
    public const WRAPPER_CLASS = 'html-import';

    /**
     * @throws HtmlImportException
     */
    public function import(Page $page, string $htmlContent, string $originalFilename): PageImport
    {
        $originalSize = strlen($htmlContent);
        $checksum = sha1($htmlContent);

        $htmlContent = $this->ensureUtf8($htmlContent);

        if (! preg_match('/<body[^>]*>/i', $htmlContent)) {
            throw new HtmlImportException('El archivo no contiene una etiqueta <body>; debe ser una maqueta HTML completa.');
        }

        // --- separación --------------------------------------------------
        $detectedTitle = $this->firstMatch('#<title[^>]*>(.*?)</title>#is', $htmlContent);
        $detectedMeta = $this->firstMatch('#<meta\s+name=["\']description["\']\s+content=["\'](.*?)["\']\s*/?>#is', $htmlContent);
        $googleFonts = $this->extractGoogleFonts($htmlContent);

        // <style>: contenidos concatenados (escáner manual — los bloques de
        // una maqueta pueden ser enormes y el regex lazy agota el backtrack
        // limit de PCRE)
        [, $styleBlocks] = $this->extractTagBlocks($htmlContent, 'style', removeFromHtml: false);
        $css = implode("\n", array_column($styleBlocks, 'content'));

        if (! preg_match('#<body([^>]*)>#i', $htmlContent, $m, PREG_OFFSET_CAPTURE)) {
            throw new HtmlImportException('No se pudo aislar el contenido del <body> de la maqueta.');
        }
        $bodyAttrs = $m[1][0];
        $bodyStart = $m[0][1] + strlen($m[0][0]);
        $bodyEnd = strripos($htmlContent, '</body>');
        $body = substr($htmlContent, $bodyStart, ($bodyEnd === false ? strlen($htmlContent) : $bodyEnd) - $bodyStart);
        unset($htmlContent, $m);

        $bodyClass = $this->firstMatch('/class=["\']([^"\']*)["\']/i', $bodyAttrs);

        // los <style> del body ya fueron recolectados arriba (van scopeados a
        // page.css); acá se quitan del markup para que no queden duplicados
        // y sin scope
        [$body] = $this->extractTagBlocks($body, 'style', removeFromHtml: true);

        // scripts inline del body (los <script src> externos quedan en el markup)
        [$body, $scriptBlocks] = $this->extractTagBlocks($body, 'script', removeFromHtml: true, skipWithSrc: true);
        $scripts = array_map('trim', array_column($scriptBlocks, 'content'));

        // --- media embebida ----------------------------------------------
        $extractor = new DataUriExtractor();
        $body = $extractor->extract($body, PageImport::ASSET_PLACEHOLDER);

        // reparar tags desbalanceados: un </div> de más cerraría el wrapper
        // .html-import a mitad de página (y el CSS scopeado dejaría de aplicar
        // de ahí en adelante); una apertura sin cerrar se tragaría el cierre
        // del wrapper
        $balancer = new HtmlBalancer();
        $body = $balancer->balance($body);
        // en el CSS la referencia es relativa al propio page.css (media/ es
        // hermana del archivo), así el CSS queda estático y cacheable
        $css = $extractor->extract($css, 'media/');
        $js = implode("\n", array_filter($scripts));
        unset($scripts);
        if ($js !== '') {
            $js = $extractor->extract($js, PageImport::ASSET_PLACEHOLDER);
        }

        // --- transformaciones --------------------------------------------
        $scopedCss = (new CssScoper('.' . self::WRAPPER_CLASS))->scope($css);
        unset($css);

        $wrappedJs = null;
        if ($js !== '') {
            $wrappedJs = "/* Importado por HtmlPageImporter — IIFE para no contaminar el scope global. */\n"
                . "(function () {\n" . str_replace('</script', '<\/script', $js) . "\n})();\n";
        }
        unset($js);

        // --- persistencia -------------------------------------------------
        $disk = Storage::disk('public');
        $dir = 'imported-pages/' . $page->id;
        $disk->deleteDirectory($dir);

        try {
            $disk->put($dir . '/page.css', $scopedCss);
            foreach ($extractor->files() as $file => $content) {
                $disk->put($dir . '/media/' . $file, $content);
            }

            return DB::transaction(function () use ($page, $dir, $extractor, $balancer, $originalFilename, $originalSize, $checksum, $body, $wrappedJs, $detectedTitle, $detectedMeta, $googleFonts, $bodyClass) {
                $import = PageImport::updateOrCreate(['page_id' => $page->id], [
                    'original_filename' => $originalFilename,
                    'original_size' => $originalSize,
                    'checksum' => $checksum,
                    'body_html' => trim($body),
                    'js_code' => $wrappedJs,
                    'detected_title' => $detectedTitle,
                    'detected_meta_description' => $detectedMeta,
                    'google_fonts' => $googleFonts,
                    'manifest' => [
                        'css_path' => $dir . '/page.css',
                        'body_class' => $bodyClass ?: null,
                        'media' => $extractor->manifest(),
                        'stats' => [
                            'media_count' => count($extractor->manifest()),
                            'dropped_close_tags' => $balancer->droppedCloses(),
                            'appended_close_tags' => $balancer->appendedCloses(),
                        ],
                    ],
                ]);

                $page->template = 'html-import';
                if (! $page->meta_title && $import->detected_title) {
                    $page->meta_title = mb_substr($import->detected_title, 0, 255);
                }
                if (! $page->meta_description && $import->detected_meta_description) {
                    $page->meta_description = $import->detected_meta_description;
                }
                $page->save();

                return $import;
            });
        } catch (Throwable $e) {
            $disk->deleteDirectory($dir);

            if ($e instanceof HtmlImportException) {
                throw $e;
            }
            throw new HtmlImportException('La importación falló al guardar: ' . $e->getMessage(), previous: $e);
        }
    }

    /**
     * Elimina el import de la página: archivos, fila y template.
     */
    public function remove(Page $page): void
    {
        Storage::disk('public')->deleteDirectory('imported-pages/' . $page->id);
        $page->htmlImport()->delete();

        if ($page->template === 'html-import') {
            $page->update(['template' => null]);
        }
    }

    private function ensureUtf8(string $html): string
    {
        if (mb_check_encoding($html, 'UTF-8')) {
            return $html;
        }

        $charset = $this->firstMatch('/<meta\s+charset=["\']?([a-z0-9-]+)/i', $html) ?? 'ISO-8859-1';
        $converted = @mb_convert_encoding($html, 'UTF-8', $charset);

        if ($converted === false || ! mb_check_encoding($converted, 'UTF-8')) {
            throw new HtmlImportException('El archivo no está en UTF-8 y no se pudo convertir.');
        }

        return $converted;
    }

    /**
     * Extrae los bloques <tag ...>contenido</tag> con un escáner por
     * strpos (lineal, apto para bloques de varios MB donde un regex lazy
     * agota pcre.backtrack_limit). Con $skipWithSrc, los tags con atributo
     * src se dejan intactos en el HTML.
     *
     * @return array{0: string, 1: list<array{attrs: string, content: string}>}
     */
    private function extractTagBlocks(string $html, string $tag, bool $removeFromHtml, bool $skipWithSrc = false): array
    {
        $open = '<' . $tag;
        $close = '</' . $tag . '>';
        $blocks = [];
        $kept = '';
        $cursor = 0;
        $offset = 0;

        while (($start = stripos($html, $open, $offset)) !== false) {
            $tagEnd = strpos($html, '>', $start);
            if ($tagEnd === false) {
                break;
            }
            // debe ser exactamente el tag (siguiente char: espacio o '>')
            $after = $html[$start + strlen($open)] ?? '';
            if ($after !== '>' && ! ctype_space($after)) {
                $offset = $start + 1;
                continue;
            }

            $attrs = substr($html, $start + strlen($open), $tagEnd - $start - strlen($open));
            $contentStart = $tagEnd + 1;
            $end = stripos($html, $close, $contentStart);
            if ($end === false) {
                break;
            }

            if ($skipWithSrc && preg_match('/\bsrc\s*=/i', $attrs)) {
                $offset = $end + strlen($close);
                continue;
            }

            $blocks[] = ['attrs' => $attrs, 'content' => substr($html, $contentStart, $end - $contentStart)];

            if ($removeFromHtml) {
                $kept .= substr($html, $cursor, $start - $cursor) . "\n";
                $cursor = $end + strlen($close);
            }

            $offset = $end + strlen($close);
        }

        $result = $removeFromHtml ? $kept . substr($html, $cursor) : $html;

        return [$result, $blocks];
    }

    private function firstMatch(string $pattern, string $subject): ?string
    {
        if (preg_match($pattern, $subject, $m)) {
            $value = trim(html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8'));

            return $value === '' ? null : $value;
        }

        return null;
    }

    /** @return list<string> */
    private function extractGoogleFonts(string $html): array
    {
        $fonts = [];
        if (preg_match_all('#<link[^>]+href=["\'](https://fonts\.googleapis\.com/css2?[^"\']+)["\'][^>]*>#i', $html, $m)) {
            $fonts = array_values(array_unique(array_map(
                fn (string $href) => html_entity_decode($href, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                $m[1],
            )));
        }

        return $fonts;
    }
}
