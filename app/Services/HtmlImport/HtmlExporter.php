<?php

namespace App\Services\HtmlImport;

use App\Exceptions\HtmlImportException;
use App\Models\PageImport;
use Illuminate\Support\Facades\Storage;

/**
 * Reconstruye un HTML standalone desde un import procesado: body + JS con
 * la media re-embebida como data URIs, y el CSS scopeado inline (el body
 * va envuelto en el mismo wrapper .html-import, así el archivo renderiza
 * solo en el navegador tal como se ve la página).
 *
 * No es el archivo original byte a byte (los <style>/<script> fueron
 * extraídos y el CSS scopeado): es el export para páginas importadas
 * antes de que existiera el historial, o cuando se perdió el original.
 * El archivo reconstruido se puede editar y volver a subir al importador.
 */
class HtmlExporter
{
    public function export(PageImport $import): string
    {
        $disk = Storage::disk('public');
        $manifest = $import->manifest ?? [];

        $cssPath = $manifest['css_path'] ?? null;
        $css = $cssPath ? $disk->get($cssPath) : null;
        if ($css === null) {
            throw new HtmlImportException('No se encontró el CSS generado de esta página; no se puede reconstruir el HTML.');
        }

        // media -> data URIs
        $dataUris = [];
        foreach ($manifest['media'] ?? [] as $m) {
            $content = $disk->get($import->storageDir() . '/media/' . $m['file']);
            if ($content === null) {
                throw new HtmlImportException("Falta el archivo de media {$m['file']}; no se puede reconstruir el HTML.");
            }
            $dataUris[$m['file']] = 'data:' . $m['mime'] . ';base64,' . base64_encode($content);
        }

        $body = $import->body_html ?? '';
        $js = $import->js_code;
        foreach ($dataUris as $file => $uri) {
            $body = str_replace(PageImport::ASSET_PLACEHOLDER . $file, $uri, $body);
            if ($js !== null) {
                $js = str_replace(PageImport::ASSET_PLACEHOLDER . $file, $uri, $js);
            }
            // en el CSS las referencias son relativas al page.css
            $css = str_replace('media/' . $file, $uri, $css);
        }

        $fonts = '';
        if ($import->google_fonts) {
            $fonts = "<link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">\n"
                . "<link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>\n";
            foreach ($import->google_fonts as $href) {
                $fonts .= '<link href="' . htmlspecialchars($href, ENT_QUOTES) . "\" rel=\"stylesheet\">\n";
            }
        }

        $title = htmlspecialchars($import->detected_title ?? $import->page?->title ?? 'Página', ENT_QUOTES);
        $meta = $import->detected_meta_description
            ? '<meta name="description" content="' . htmlspecialchars($import->detected_meta_description, ENT_QUOTES) . ">\n"
            : '';
        $bodyClass = trim((string) ($manifest['body_class'] ?? ''));
        $bodyClassAttr = $bodyClass !== '' ? ' class="' . htmlspecialchars($bodyClass, ENT_QUOTES) . '"' : '';

        return "<!DOCTYPE html>\n<html lang=\"es\">\n<head>\n"
            . "<meta charset=\"utf-8\">\n"
            . "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n"
            . "<title>{$title}</title>\n"
            . $meta
            . $fonts
            . "<!-- Reconstruido por el CMS desde la página importada (no es el archivo original):\n"
            . "     CSS scopeado bajo .html-import y scripts unificados en una IIFE.\n"
            . "     Se puede editar y volver a subir al importador. -->\n"
            . "<style>\n"
            // en html{} a propósito: standalone la var se hereda a todo, y si
            // este archivo se vuelve a subir, el importador descarta las
            // reglas html{} y la var vuelve a manejarla el runtime del sitio
            . "html{--site-header-h:0px}\nhtml,body{margin:0;padding:0}\n" . $css . "\n</style>\n"
            . "</head>\n<body{$bodyClassAttr}>\n"
            . "<div class=\"html-import\">\n" . $body . "\n</div>\n"
            . ($js !== null ? "<script>\n" . $js . "\n</script>\n" : '')
            . "</body>\n</html>\n";
    }
}
