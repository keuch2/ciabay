<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandCatalogController extends Controller
{
    public function show(Brand $brand)
    {
        $categories = $brand->catalogCategories()
            ->withCount('products')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $products = $brand->catalogProducts()
            ->with('category')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.brands.catalog.dashboard', compact('brand', 'categories', 'products'));
    }

    public function updateConfig(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'catalog_columns' => 'nullable|integer|min:1|max:6',
            'catalog_per_page' => 'nullable|integer|min:1|max:100',
            'catalog_custom_css' => 'nullable|string|max:50000',
            'catalog_custom_js' => 'nullable|string|max:50000',
        ]);

        $brand->update($validated);

        return redirect()->route('admin.brands.catalog.show', $brand)
            ->with('success', 'Configuración del catálogo de la marca actualizada.');
    }
}
