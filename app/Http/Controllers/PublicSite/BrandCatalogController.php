<?php

declare(strict_types=1);

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CatalogProduct;
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
            ->withCount(['products' => fn ($q) => $isStaff ? $q : $q->where('is_active', true)])
            ->get();

        $selectedCategorySlug = $request->query('categoria');
        $selectedCategory = $selectedCategorySlug
            ? $categories->firstWhere('slug', $selectedCategorySlug)
            : null;

        $productQuery = $brand->catalogProducts()->with('category');
        if (! $isStaff) $productQuery->active();
        if ($selectedCategory) $productQuery->where('catalog_category_id', $selectedCategory->id);
        $products = $productQuery->orderBy('sort_order')->orderBy('name')->get();

        $isDraft = ! $brand->catalog_enabled;

        return view('public.catalog.show', compact('brand', 'categories', 'products', 'selectedCategory', 'isDraft'));
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

        $relatedQuery = CatalogProduct::where('brand_id', $brand->id)
            ->where('id', '!=', $product->id)
            ->when($product->catalog_category_id, fn ($q) => $q->where('catalog_category_id', $product->catalog_category_id))
            ->orderBy('sort_order');
        if (! $isStaff) $relatedQuery->active();
        $related = $relatedQuery->limit(4)->get();

        $isDraft = ! $brand->catalog_enabled || ! $product->is_active;

        return view('public.catalog.product', compact('brand', 'product', 'related', 'isDraft'));
    }
}
