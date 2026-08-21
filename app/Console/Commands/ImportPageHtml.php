<?php

namespace App\Console\Commands;

use App\Exceptions\HtmlImportException;
use App\Models\Page;
use App\Services\HtmlPageImporter;
use Illuminate\Console\Command;

/**
 * Vía alternativa al upload del admin: importa una maqueta HTML desde un
 * archivo local. Útil para testing (sin límites de upload HTTP) y como
 * fallback por SSH en producción.
 */
class ImportPageHtml extends Command
{
    protected $signature = 'page:import-html {page : ID o slug de la página} {path : Ruta al archivo HTML}';

    protected $description = 'Importa una maqueta HTML como contenido de una página (template html-import)';

    public function handle(HtmlPageImporter $importer): int
    {
        $pageArg = $this->argument('page');
        $page = Page::where('slug', $pageArg)
            ->orWhere('id', is_numeric($pageArg) ? (int) $pageArg : 0)
            ->first();

        if (! $page) {
            $this->error("No existe una página con id o slug '{$pageArg}'.");

            return self::FAILURE;
        }

        $path = $this->argument('path');
        if (! is_readable($path)) {
            $this->error("No se puede leer el archivo: {$path}");

            return self::FAILURE;
        }

        try {
            $import = $importer->import($page, file_get_contents($path), basename($path));
        } catch (HtmlImportException $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        $manifest = $import->manifest;
        $this->info("Importado '{$import->original_filename}' en la página '{$page->slug}' (id {$page->id}).");
        $this->line('  Media: ' . count($manifest['media'] ?? []) . ' archivos');
        $this->line('  CSS: storage/app/public/' . ($manifest['css_path'] ?? '-'));
        $this->line('  Body: ' . number_format(strlen($import->body_html)) . ' bytes · JS: ' . number_format(strlen((string) $import->js_code)) . ' bytes');
        $this->line('  Título detectado: ' . ($import->detected_title ?? '-'));

        return self::SUCCESS;
    }
}
