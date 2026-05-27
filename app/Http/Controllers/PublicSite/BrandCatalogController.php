<?php

declare(strict_types=1);

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Brand;
use App\Models\CatalogProduct;
use App\Models\Setting;
use App\Services\BrandCatalogFilter;
use Illuminate\Http\Request;

class BrandCatalogController extends Controller
{
    public function show(string $brandSlug, Request $request)
    {
        $isStaff = auth()->check() && auth()->user()->isStaff();

        $brand = Brand::where('slug', $brandSlug)->firstOrFail();

        // Public visitors cannot see a brand's catalog unless it is enabled.
        if (! $brand->catalog_enabled && ! $isStaff) {
            abort(404);
        }

        $categories = $brand->catalogCategories()
            ->when(! $isStaff, fn ($q) => $q->active())
            ->orderBy('sort_order')
            ->orderBy('name')
            ->withCount(['productsAny as products_count' => fn ($q) => $isStaff ? $q : $q->where('is_active', true)])
            ->get();

        $selectedSlugs = BrandCatalogFilter::slugsFromRequest();
        $selectedCategories = $selectedSlugs
            ? $categories->whereIn('slug', $selectedSlugs)->values()
            : collect();

        $columns = $brand->catalog_columns ?: (int) Setting::get('catalog_columns_default', 4);
        $perPage = $brand->catalog_per_page ?: (int) Setting::get('catalog_per_page_default', 12);

        $productQuery = $brand->catalogProducts()->with('category');
        if (! $isStaff) $productQuery->active();
        BrandCatalogFilter::applyFilter($productQuery, $brand, $selectedSlugs);
        $products = $productQuery->orderBy('sort_order')->orderBy('name')->paginate($perPage)->withQueryString();

        $isDraft = ! $brand->catalog_enabled;

        $customCss = $this->composeCatalogCss($brand);
        $customJs = $this->composeCatalogJs($brand);

        return view('public.catalog.show', compact(
            'brand', 'categories', 'products', 'selectedCategories', 'selectedSlugs',
            'isDraft', 'customCss', 'customJs', 'columns'
        ));
    }

    /**
     * AJAX endpoint: returns the rendered products grid + pagination for
     * the current multi-category filter on a brand catalog.
     */
    public function productsAjax(string $brandSlug, Request $request)
    {
        $isStaff = auth()->check() && auth()->user()->isStaff();
        $brand = Brand::where('slug', $brandSlug)->firstOrFail();
        if (! $brand->catalog_enabled && ! $isStaff) abort(404);

        $selectedSlugs = BrandCatalogFilter::slugsFromRequest();
        $columns = $brand->catalog_columns ?: (int) Setting::get('catalog_columns_default', 4);
        $perPage = $brand->catalog_per_page ?: (int) Setting::get('catalog_per_page_default', 12);

        $productQuery = $brand->catalogProducts()->with('category');
        if (! $isStaff) $productQuery->active();
        BrandCatalogFilter::applyFilter($productQuery, $brand, $selectedSlugs);
        $products = $productQuery->orderBy('sort_order')->orderBy('name')->paginate($perPage)->withQueryString();

        $resolveImg = function ($img) {
            if (! $img) return null;
            if (preg_match('#^(https?:)?//#', $img)) return $img;
            if (str_starts_with($img, 'assets/') || str_starts_with($img, 'storage/')) return asset($img);
            return asset('storage/' . $img);
        };

        $html = view('public.catalog.partials.products-results', compact(
            'brand', 'products', 'columns', 'resolveImg'
        ))->render();

        return response()->json([
            'html' => $html,
            'total' => $products->total(),
        ]);
    }

    /**
     * AJAX endpoint for the brand-catalog page block. Same shape as productsAjax
     * but the product set is shaped by the block's stored data (source/category/manual).
     */
    public function blockProductsAjax(string $brandSlug, Request $request)
    {
        $isStaff = auth()->check() && auth()->user()->isStaff();
        $brand = Brand::where('slug', $brandSlug)->firstOrFail();
        if (! $brand->catalog_enabled && ! $isStaff) abort(404);

        $blockId = (int) $request->query('block', 0);
        if ($blockId < 1) abort(400, 'missing block id');

        $block = Block::where('type', 'brand-catalog')->findOrFail($blockId);
        $data = $block->data ?? [];
        if ((int) ($data['brand_id'] ?? 0) !== $brand->id) {
            abort(404);
        }

        $perPage = !empty($data['per_page']) ? (int) $data['per_page'] : (int) Setting::get('catalog_per_page_default', 12);
        $columns = !empty($data['columns']) ? (int) $data['columns'] : (int) Setting::get('catalog_columns_default', 4);
        if ($perPage < 1) $perPage = 12;
        if ($columns < 1 || $columns > 6) $columns = 4;

        $source = $data['source'] ?? 'all';
        $showCategoryFilter = (bool) ($data['show_category_filter'] ?? true);
        $filterSlugs = ($source !== 'manual' && $showCategoryFilter) ? BrandCatalogFilter::slugsFromRequest() : [];

        $query = BrandCatalogFilter::applyBlockFilter($brand, $data, $isStaff, $filterSlugs);

        if ($source === 'manual') {
            // Manual mode does not paginate; AJAX is rarely useful but we still
            // return the rendered grid so the partial signature stays consistent.
            $products = $query->get();
        } else {
            $products = $query->paginate($perPage)->withQueryString();
        }

        $resolveImg = function ($img) {
            if (! $img) return null;
            if (preg_match('#^(https?:)?//#', $img)) return $img;
            if (str_starts_with($img, 'assets/') || str_starts_with($img, 'storage/')) return asset($img);
            return asset('storage/' . $img);
        };

        $html = view('public.catalog.partials.products-results', compact(
            'brand', 'products', 'columns', 'resolveImg'
        ))->render();

        $total = $source === 'manual' ? $products->count() : $products->total();

        return response()->json([
            'html' => $html,
            'total' => $total,
        ]);
    }

    public function product(string $brandSlug, string $productSlug)
    {
        $isStaff = auth()->check() && auth()->user()->isStaff();

        $brand = Brand::where('slug', $brandSlug)->firstOrFail();
        if (! $brand->catalog_enabled && ! $isStaff) {
            abort(404);
        }

        $productQuery = $brand->catalogProducts()->with('category')->where('slug', $productSlug);
        if (! $isStaff) $productQuery->active();
        $product = $productQuery->firstOrFail();

        $relatedCategoryIds = $product->categories()->pluck('catalog_categories.id');
        $relatedQuery = CatalogProduct::where('brand_id', $brand->id)
            ->where('id', '!=', $product->id)
            ->when(
                $relatedCategoryIds->isNotEmpty(),
                fn ($q) => $q->whereHas('categories', fn ($q2) => $q2->whereIn('catalog_categories.id', $relatedCategoryIds))
            )
            ->orderBy('sort_order');
        if (! $isStaff) $relatedQuery->active();
        $related = $relatedQuery->limit(4)->get();

        $isDraft = ! $brand->catalog_enabled || ! $product->is_active;

        $customCss = trim($this->composeCatalogCss($brand) . "\n" . ($product->custom_css ?? ''));
        $customJs = trim($this->composeCatalogJs($brand) . "\n" . ($product->custom_js ?? ''));

        return view('public.catalog.product', compact(
            'brand', 'product', 'related', 'isDraft', 'customCss', 'customJs'
        ));
    }

    private function composeCatalogCss(Brand $brand): string
    {
        return trim(
            (Setting::get('catalog_custom_css_default') ?? '') . "\n" .
            ($brand->catalog_custom_css ?? '')
        );
    }

    private function composeCatalogJs(Brand $brand): string
    {
        return trim(
            (Setting::get('catalog_custom_js_default') ?? '') . "\n" .
            ($brand->catalog_custom_js ?? '')
        );
    }
}
