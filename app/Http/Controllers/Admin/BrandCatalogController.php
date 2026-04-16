<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;

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
}
