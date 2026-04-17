<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('sort_order')->orderBy('title')->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'template' => 'nullable|string|max:255',
            'is_homepage' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'custom_css' => 'nullable|string|max:50000',
            'custom_js' => 'nullable|string|max:50000',
            'status' => 'required|in:draft,published',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if (! empty($validated['is_homepage']) && $validated['is_homepage']) {
            Page::where('is_homepage', true)->update(['is_homepage' => false]);
        }

        $page = Page::create($validated);

        return redirect()->route('admin.pages.edit', $page)
            ->with('success', 'Página creada correctamente.');
    }

    public function edit(Page $page)
    {
        $page->load('blocks');
        $blockTypes = $this->getBlockTypes();
        return view('admin.pages.edit', compact('page', 'blockTypes'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'template' => 'nullable|string|max:255',
            'is_homepage' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'custom_css' => 'nullable|string|max:50000',
            'custom_js' => 'nullable|string|max:50000',
            'status' => 'required|in:draft,published',
        ]);

        if (! empty($validated['is_homepage']) && $validated['is_homepage'] && ! $page->is_homepage) {
            Page::where('is_homepage', true)->where('id', '!=', $page->id)->update(['is_homepage' => false]);
        }

        $page->update($validated);

        return redirect()->route('admin.pages.edit', $page)
            ->with('success', 'Página actualizada correctamente.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')
            ->with('success', 'Página eliminada correctamente.');
    }

    public function storeBlock(Request $request, Page $page)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:100',
            'data' => 'nullable|array',
        ]);

        $maxOrder = $page->blocks()->max('sort_order') ?? 0;

        $block = $page->blocks()->create([
            'type' => $validated['type'],
            'data' => $validated['data'] ?? [],
            'sort_order' => $maxOrder + 1,
        ]);

        return response()->json(['success' => true, 'block' => $block]);
    }

    public function updateBlock(Request $request, Page $page, Block $block)
    {
        $validated = $request->validate([
            'data' => 'nullable|array',
        ]);

        $block->update(['data' => $validated['data'] ?? []]);

        return response()->json(['success' => true, 'block' => $block]);
    }

    public function destroyBlock(Page $page, Block $block)
    {
        $block->delete();
        return response()->json(['success' => true]);
    }

    public function reorderBlocks(Request $request, Page $page)
    {
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:blocks,id',
        ]);

        foreach ($validated['order'] as $index => $blockId) {
            Block::where('id', $blockId)->where('page_id', $page->id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    private function getBlockTypes(): array
    {
        return [
            // Hero blocks
            'hero-carousel' => 'Hero Carousel',
            'hero-overlay' => 'Hero con Overlay',
            'page-hero' => 'Page Hero (variantes por página)',
            // Content / intro
            'text-intro' => 'Texto Introducción',
            'intro-banner' => 'Intro Banner (variantes)',
            'rich-text' => 'Texto Enriquecido',
            'narrative-paragraphs' => 'Narrativa (párrafos largos)',
            'image-text' => 'Imagen + Texto',
            // Grids
            'stats-grid' => 'Estadísticas Grid',
            'unidades-negocio' => 'Unidades de Negocio',
            'features-grid' => 'Features Grid',
            'brands-grid' => 'Marcas Grid',
            'brand-showcase' => 'Marcas Destacadas (cards detalladas)',
            'logo-grid' => 'Grid de Logos (specialized/marcas)',
            'category-grid' => 'Categorías (icono + lista + CTA)',
            'category-feature' => 'Categoría con Imagen (insumos)',
            'value-grid' => 'Valores / Valor Grid',
            'pillars' => 'Pilares (Misión/Visión/Valores)',
            // Callouts / CTA
            'cta-section' => 'Sección CTA',
            'callout-card' => 'Callout Card (objetivo/destacado)',
            'cross-sell' => 'Cross-sell / Upsell Banner',
            'quote' => 'Cita / Quote',
            // Other
            'timeline' => 'Línea de Tiempo',
            'testimonials' => 'Testimonios',
            'branches-cards' => 'Sucursales (cards)',
            'branches-map' => 'Sucursales + Mapa',
            'map-embed' => 'Mapa (iframe embed)',
            'contact-info' => 'Contacto (info + formulario)',
            'contact-form' => 'Formulario Contacto (solo form)',
            'gallery' => 'Galería de Imágenes',
            'agriculture-title' => 'Agricultura — Título',
            'agriculture-image' => 'Agricultura — Imagen',
            // Tienda Online (Red Case IH)
            'redcase-hero' => 'Red Case IH — Hero',
            'redcase-products' => 'Red Case IH — Productos',
            'redcase-cta' => 'Red Case IH — CTA WhatsApp',
        ];
    }
}
