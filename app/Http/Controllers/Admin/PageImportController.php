<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\HtmlImportException;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\HtmlPageImporter;
use Illuminate\Http\Request;

/**
 * Subida / eliminación de la maqueta HTML de una página (template
 * 'html-import'). Endpoints JSON consumidos por la card "Maqueta HTML"
 * del editor de páginas.
 */
class PageImportController extends Controller
{
    public function store(Request $request, Page $page, HtmlPageImporter $importer)
    {
        $request->validate([
            'html_file' => 'required|file|extensions:html,htm|max:25600',
        ], [
            'html_file.required' => 'Seleccioná un archivo HTML.',
            'html_file.extensions' => 'El archivo debe ser un .html.',
            'html_file.max' => 'El archivo supera el máximo de 25 MB.',
        ]);

        try {
            $import = $importer->import(
                $page,
                file_get_contents($request->file('html_file')->getRealPath()),
                $request->file('html_file')->getClientOriginalName(),
            );
        } catch (HtmlImportException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }

        return response()->json([
            'success' => true,
            'import' => [
                'filename' => $import->original_filename,
                'imported_at' => $import->updated_at->format('d/m/Y H:i'),
                'media_count' => count($import->manifest['media'] ?? []),
            ],
        ]);
    }

    public function destroy(Page $page, HtmlPageImporter $importer)
    {
        $importer->remove($page);

        return response()->json(['success' => true]);
    }
}
