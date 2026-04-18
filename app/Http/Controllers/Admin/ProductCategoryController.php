<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::with(['children' => function ($q) {
                $q->withCount('products')->orderBy('sort_order');
            }])
            ->withCount('products')
            ->roots()
            ->orderBy('sort_order')
            ->get();
        return view('admin.product-categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = ProductCategory::roots()->orderBy('sort_order')->get();
        return view('admin.product-categories.create', ['category' => new ProductCategory(), 'parents' => $parents]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateCategory($request);
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        ProductCategory::create($validated);

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    public function edit(ProductCategory $productCategory)
    {
        $parents = ProductCategory::roots()->where('id', '!=', $productCategory->id)->orderBy('sort_order')->get();
        return view('admin.product-categories.edit', ['category' => $productCategory, 'parents' => $parents]);
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $validated = $this->validateCategory($request, $productCategory);
        $productCategory->update($validated);

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(ProductCategory $productCategory)
    {
        if ($productCategory->products()->count() > 0) {
            return redirect()->route('admin.product-categories.index')
                ->with('error', 'No se puede eliminar: hay productos en esta categoría.');
        }
        $productCategory->delete();

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }

    private function validateCategory(Request $request, ?ProductCategory $category = null): array
    {
        $slugRule = $category
            ? 'required|string|max:255|unique:product_categories,slug,' . $category->id
            : 'nullable|string|max:255|unique:product_categories,slug';

        return $request->validate([
            'name' => 'required|string|max:255',
            'slug' => $slugRule,
            'sort_order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:product_categories,id',
        ]);
    }
}
