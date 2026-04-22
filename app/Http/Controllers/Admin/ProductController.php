<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('sort_order')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::with('children')->roots()->orderBy('sort_order')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->filled('library_image')) {
            $validated['image'] = ltrim($request->input('library_image'), '/');
        }

        $validated['images'] = $this->uploadGallery($request);

        $product = Product::create($validated);
        $product->categories()->sync($this->collectCategoryIds($request, $validated['product_category_id'] ?? null));

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::with('children')->roots()->orderBy('sort_order')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $this->validateProduct($request, $product);

        // Main image
        if ($request->hasFile('image')) {
            if ($product->image && !str_starts_with($product->image, 'assets/')) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->filled('library_image')) {
            $validated['image'] = ltrim($request->input('library_image'), '/');
        } elseif ($request->boolean('remove_image')) {
            if ($product->image && !str_starts_with($product->image, 'assets/')) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = null;
        }

        // Gallery: start from existing, remove flagged, append uploads
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
        $uploaded = $this->uploadGallery($request);
        $validated['images'] = array_values(array_merge($existing, $uploaded));

        $product->update($validated);
        $product->categories()->sync($this->collectCategoryIds($request, $validated['product_category_id'] ?? $product->product_category_id));

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'Producto eliminado correctamente.');
    }

    private function validateProduct(Request $request, ?Product $product = null): array
    {
        $slugRule = 'nullable|string|max:255|unique:products,slug' . ($product ? ',' . $product->id : '');
        if ($product) $slugRule = 'required|string|max:255|unique:products,slug,' . $product->id;

        return $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
            'slug' => $slugRule,
            'description' => 'nullable|string|max:5000',
            'product_category_id' => 'nullable|exists:product_categories,id',
            'price' => 'nullable|numeric|min:0',
            'whatsapp_message' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:4096',
            'library_image' => 'nullable|string|max:500',
            'gallery_images.*' => 'nullable|image|max:4096',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'integer|exists:product_categories,id',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);
    }

    private function collectCategoryIds(Request $request, $primary): array
    {
        $ids = array_map('intval', (array) $request->input('category_ids', []));
        if ($primary) {
            $ids[] = (int) $primary;
        }
        $ids = array_values(array_unique(array_filter($ids)));
        if ($ids) {
            $ids = \App\Models\ProductCategory::whereIn('id', $ids)->pluck('id')->all();
        }
        return $ids;
    }

    private function uploadGallery(Request $request): array
    {
        $paths = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                if ($file && $file->isValid()) {
                    $paths[] = $file->store('products', 'public');
                }
            }
        }
        return $paths;
    }
}
