<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CatalogCategory;
use App\Models\CatalogProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CatalogProductController extends Controller
{
    public function create(Brand $brand)
    {
        return view('admin.brands.catalog.products.create', [
            'brand' => $brand,
            'product' => new CatalogProduct(['brand_id' => $brand->id, 'contact_enabled' => true, 'is_active' => true]),
            'categories' => $brand->catalogCategories()->orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request, Brand $brand)
    {
        $validated = $this->validateProduct($request, $brand);
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['image'] = $this->resolveMainImage($request, null);
        $validated['images'] = $this->uploadGallery($request);
        $validated['brand_id'] = $brand->id;

        if ($validated['catalog_category_id'] ?? null) {
            abort_unless(
                $brand->catalogCategories()->whereKey($validated['catalog_category_id'])->exists(),
                422
            );
        }

        unset(
            $validated['library_image'], $validated['remove_image'],
            $validated['gallery_images'], $validated['remove_images'],
            $validated['catalog_category_ids']
        );

        $product = CatalogProduct::create($validated);
        $product->categories()->sync($this->collectCategoryIds($request, $brand, $validated['catalog_category_id'] ?? null));

        return redirect()->route('admin.brands.catalog.show', $brand)
            ->with('success', 'Producto creado correctamente.');
    }

    public function edit(Brand $brand, CatalogProduct $product)
    {
        $this->ensureOwned($brand, $product);
        return view('admin.brands.catalog.products.edit', [
            'brand' => $brand,
            'product' => $product,
            'categories' => $brand->catalogCategories()->orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Brand $brand, CatalogProduct $product)
    {
        $this->ensureOwned($brand, $product);
        $validated = $this->validateProduct($request, $brand, $product);

        $validated['image'] = $this->resolveMainImage($request, $product);

        // Gallery: preserve existing minus removed, plus newly uploaded
        $existing = $product->images ?? [];
        $toRemove = $request->input('remove_images', []);
        if (is_array($toRemove) && count($toRemove)) {
            foreach ($toRemove as $path) {
                if ($path && !str_starts_with($path, 'assets/')) {
                    Storage::disk('public')->delete($path);
                }
            }
            $existing = array_values(array_diff($existing, $toRemove));
        }
        $validated['images'] = array_values(array_merge($existing, $this->uploadGallery($request)));

        if ($validated['catalog_category_id'] ?? null) {
            abort_unless(
                $brand->catalogCategories()->whereKey($validated['catalog_category_id'])->exists(),
                422
            );
        }

        unset(
            $validated['library_image'], $validated['remove_image'],
            $validated['gallery_images'], $validated['remove_images'],
            $validated['catalog_category_ids']
        );

        $product->update($validated);
        $product->categories()->sync($this->collectCategoryIds($request, $brand, $validated['catalog_category_id'] ?? $product->catalog_category_id));

        return redirect()->route('admin.brands.catalog.show', $brand)
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Brand $brand, CatalogProduct $product)
    {
        $this->ensureOwned($brand, $product);
        // Clean up uploaded files
        if ($product->image && !str_starts_with($product->image, 'assets/')) {
            Storage::disk('public')->delete($product->image);
        }
        foreach ($product->images ?? [] as $img) {
            if ($img && !str_starts_with($img, 'assets/')) {
                Storage::disk('public')->delete($img);
            }
        }
        $product->delete();

        return redirect()->route('admin.brands.catalog.show', $brand)
            ->with('success', 'Producto eliminado correctamente.');
    }

    private function ensureOwned(Brand $brand, CatalogProduct $product): void
    {
        abort_unless($product->brand_id === $brand->id, 404);
    }

    private function validateProduct(Request $request, Brand $brand, ?CatalogProduct $product = null): array
    {
        $slugRule = $product
            ? ['required', 'string', 'max:255', "unique:catalog_products,slug,{$product->id},id,brand_id,{$brand->id}"]
            : ['nullable', 'string', 'max:255', "unique:catalog_products,slug,NULL,id,brand_id,{$brand->id}"];

        return $request->validate([
            'name' => 'required|string|max:255',
            'slug' => $slugRule,
            'catalog_category_id' => 'nullable|integer|exists:catalog_categories,id',
            'catalog_category_ids' => 'nullable|array',
            'catalog_category_ids.*' => 'integer|exists:catalog_categories,id',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:10000',
            'image' => 'nullable|image|max:4096',
            'library_image' => 'nullable|string|max:500',
            'remove_image' => 'nullable|boolean',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|max:4096',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'string|max:500',
            'custom_css' => 'nullable|string|max:50000',
            'custom_js' => 'nullable|string|max:50000',
            'contact_enabled' => 'boolean',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);
    }

    /**
     * Collect category IDs scoped to this brand — drops any that don't belong
     * to the given brand so we can't leak categories across brands.
     */
    private function collectCategoryIds(Request $request, Brand $brand, $primary): array
    {
        $ids = array_map('intval', (array) $request->input('catalog_category_ids', []));
        if ($primary) {
            $ids[] = (int) $primary;
        }
        $ids = array_values(array_unique(array_filter($ids)));
        if (! $ids) return [];

        return CatalogCategory::where('brand_id', $brand->id)
            ->whereIn('id', $ids)
            ->pluck('id')
            ->all();
    }

    private function resolveMainImage(Request $request, ?CatalogProduct $product)
    {
        if ($request->hasFile('image')) {
            if ($product && $product->image && !str_starts_with($product->image, 'assets/')) {
                Storage::disk('public')->delete($product->image);
            }
            return $request->file('image')->store('catalog/products', 'public');
        }
        if ($request->filled('library_image')) {
            return ltrim($request->input('library_image'), '/');
        }
        if ($request->boolean('remove_image')) {
            if ($product && $product->image && !str_starts_with($product->image, 'assets/')) {
                Storage::disk('public')->delete($product->image);
            }
            return null;
        }
        return $product?->image;
    }

    private function uploadGallery(Request $request): array
    {
        $paths = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                if ($file && $file->isValid()) {
                    $paths[] = $file->store('catalog/products', 'public');
                }
            }
        }
        return $paths;
    }
}
