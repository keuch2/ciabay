<?php

namespace Tests\Feature;

use App\Exceptions\HtmlImportException;
use App\Models\Page;
use App\Models\PageImport;
use App\Services\HtmlPageImporter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HtmlPageImportTest extends TestCase
{
    use RefreshDatabase;

    /** PNG transparente de 1x1 */
    private const PNG_B64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';

    private function fixture(): string
    {
        $png = 'data:image/png;base64,' . self::PNG_B64;

        return <<<HTML
<!DOCTYPE html>
<html><head>
<title>Página de Prueba</title>
<meta name="description" content="Descripción de prueba">
<link href="https://fonts.googleapis.com/css2?family=Archivo&display=swap" rel="stylesheet">
<style>:root{--c:#123}body{color:var(--c)}.hero{background:url("{$png}")}.lb{position:fixed;z-index:200}</style>
</head><body class="modo-x">
<h1>Hola</h1>
<img src="{$png}" alt="pixel">
<img src="{$png}" alt="pixel duplicado">
<script>console.log('uno');</script>
<script src="https://example.com/ext.js"></script>
<script>console.log('dos');</script>
</body></html>
HTML;
    }

    public function test_import_creates_files_row_and_sets_template(): void
    {
        Storage::fake('public');
        $page = Page::create(['title' => 'Prueba', 'slug' => 'prueba', 'status' => 'draft']);

        $import = app(HtmlPageImporter::class)->import($page, $this->fixture(), 'maqueta.html');

        $page->refresh();
        $this->assertSame('html-import', $page->template);
        $this->assertSame('Página de Prueba', $page->meta_title);
        $this->assertSame('Descripción de prueba', $page->meta_description);

        // media: dos data URIs idénticos (html) + uno igual en CSS => 1 archivo
        $this->assertCount(1, $import->manifest['media']);
        $file = $import->manifest['media'][0]['file'];
        Storage::disk('public')->assertExists("imported-pages/{$page->id}/media/{$file}");
        Storage::disk('public')->assertExists("imported-pages/{$page->id}/page.css");

        // body: placeholders en lugar de data URIs, scripts inline removidos, externo conservado
        $this->assertStringContainsString(PageImport::ASSET_PLACEHOLDER . $file, $import->body_html);
        $this->assertStringNotContainsString('base64', $import->body_html);
        $this->assertStringNotContainsString("console.log", $import->body_html);
        $this->assertStringContainsString('https://example.com/ext.js', $import->body_html);

        // JS: los dos scripts inline en una IIFE
        $this->assertStringContainsString("console.log('uno');", $import->js_code);
        $this->assertStringContainsString("console.log('dos');", $import->js_code);
        $this->assertStringContainsString('(function () {', $import->js_code);

        // CSS scopeado con referencia relativa al media
        $css = Storage::disk('public')->get("imported-pages/{$page->id}/page.css");
        $this->assertStringContainsString('.html-import{--c:#123}', $css);
        $this->assertStringContainsString('url("media/' . $file . '")', $css);
        $this->assertStringContainsString('z-index:1200', $css); // bump fixed +1000

        // metadata
        $this->assertSame(['https://fonts.googleapis.com/css2?family=Archivo&display=swap'], $import->google_fonts);
        $this->assertSame('modo-x', $import->manifest['body_class']);
    }

    public function test_reimport_replaces_previous_files(): void
    {
        Storage::fake('public');
        $page = Page::create(['title' => 'Prueba', 'slug' => 'prueba', 'status' => 'draft']);
        $importer = app(HtmlPageImporter::class);

        $first = $importer->import($page, $this->fixture(), 'v1.html');
        $oldMedia = $first->manifest['media'][0]['file'];

        $importer->import($page, '<html><body><p>Nuevo</p></body></html>', 'v2.html');

        $this->assertSame(1, PageImport::count());
        $this->assertSame('v2.html', $page->htmlImport()->first()->original_filename);
        Storage::disk('public')->assertMissing("imported-pages/{$page->id}/media/{$oldMedia}");
    }

    public function test_html_without_body_is_rejected_without_side_effects(): void
    {
        Storage::fake('public');
        $page = Page::create(['title' => 'Prueba', 'slug' => 'prueba', 'status' => 'draft']);

        $this->expectException(HtmlImportException::class);

        try {
            app(HtmlPageImporter::class)->import($page, '<div>no soy una maqueta</div>', 'malo.html');
        } finally {
            $this->assertSame(0, PageImport::count());
            $this->assertNull($page->fresh()->template);
            $this->assertEmpty(Storage::disk('public')->allFiles('imported-pages'));
        }
    }

    public function test_remove_cleans_everything(): void
    {
        Storage::fake('public');
        $page = Page::create(['title' => 'Prueba', 'slug' => 'prueba', 'status' => 'draft']);
        $importer = app(HtmlPageImporter::class);
        $importer->import($page, $this->fixture(), 'maqueta.html');

        $importer->remove($page);

        $this->assertSame(0, PageImport::count());
        $this->assertNull($page->fresh()->template);
        $this->assertEmpty(Storage::disk('public')->allFiles("imported-pages/{$page->id}"));
    }

    public function test_deleting_page_removes_storage_directory(): void
    {
        Storage::fake('public');
        $page = Page::create(['title' => 'Prueba', 'slug' => 'prueba', 'status' => 'draft']);
        app(HtmlPageImporter::class)->import($page, $this->fixture(), 'maqueta.html');
        $id = $page->id;

        $page->delete();

        $this->assertEmpty(Storage::disk('public')->allFiles("imported-pages/{$id}"));
        $this->assertSame(0, PageImport::count());
    }
}
