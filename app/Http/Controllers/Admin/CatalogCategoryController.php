<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CatalogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CatalogCategoryController extends Controller
{
    public function create(Brand $brand)
    {
        return view('admin.brands.catalog.categories.create', [
            'brand' => $brand,
            'category' => new CatalogCategory(['brand_id' => $brand->id]),
        ]);
    }

    public function store(Request $request, Brand $brand)
    {
        $validated = $this->validateCategory($request, $brand);
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        $validated['image'] = $this->resolveImage($request, null);
        unset($validated['library_image'], $validated['remove_image']);
        $validated['brand_id'] = $brand->id;

        CatalogCategory::create($validated);

        return redirect()->route('admin.brands.catalog.show', $brand)
            ->with('success', 'Categoría creada correctamente.');
    }

    public function edit(Brand $brand, CatalogCategory $category)
    {
        $this->ensureOwned($brand, $category);
        return view('admin.brands.catalog.categories.edit', compact('brand', 'category'));
    }

    public function update(Request $request, Brand $brand, CatalogCategory $category)
    {
        $this->ensureOwned($brand, $category);
        $validated = $this->validateCategory($request, $brand, $category);
        $validated['image'] = $this->resolveImage($request, $category);
        unset($validated['library_image'], $validated['remove_image']);

        $category->update($validated);

        return redirect()->route('admin.brands.catalog.show', $brand)
            ->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Brand $brand, CatalogCategory $category)
    {
        $this->ensureOwned($brand, $category);
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.brands.catalog.show', $brand)
                ->with('error', 'No se puede eliminar: la categoría tiene productos asignados.');
        }
        if ($category->image && !str_starts_with($category->image, 'assets/')) {
            Storage::disk('public')->delete($category->image);
        }
        $category->delete();

        return redirect()->route('admin.brands.catalog.show', $brand)
            ->with('success', 'Categoría eliminada correctamente.');
    }

    private function ensureOwned(Brand $brand, CatalogCategory $category): void
    {
        abort_unless($category->brand_id === $brand->id, 404);
    }

    private function validateCategory(Request $request, Brand $brand, ?CatalogCategory $category = null): array
    {
        $slugRule = $category
            ? ['required', 'string', 'max:255', "unique:catalog_categories,slug,{$category->id},id,brand_id,{$brand->id}"]
            : ['nullable', 'string', 'max:255', "unique:catalog_categories,slug,NULL,id,brand_id,{$brand->id}"];

        return $request->validate([
            'name' => 'required|string|max:255',
            'slug' => $slugRule,
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|image|max:4096',
            'library_image' => 'nullable|string|max:500',
            'remove_image' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);
    }

    private function resolveImage(Request $request, ?CatalogCategory $category)
    {
        if ($request->hasFile('image')) {
            if ($category && $category->image && !str_starts_with($category->image, 'assets/')) {
                Storage::disk('public')->delete($category->image);
            }
            return $request->file('image')->store('catalog/categories', 'public');
        }
        if ($request->filled('library_image')) {
            return ltrim($request->input('library_image'), '/');
        }
        if ($request->boolean('remove_image')) {
            if ($category && $category->image && !str_starts_with($category->image, 'assets/')) {
                Storage::disk('public')->delete($category->image);
            }
            return null;
        }
        return $category?->image;
    }
}
