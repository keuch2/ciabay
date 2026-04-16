<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount(['catalogCategories', 'catalogProducts'])
            ->orderBy('sort_order')
            ->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create', ['brand' => new Brand()]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateBrand($request);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['logo'] = $this->resolveLogo($request, null, $validated['logo'] ?? null);
        $validated['catalog_hero_image'] = $this->resolveCatalogHero($request, null, $validated['catalog_hero_image'] ?? null);

        // These helper keys are not DB columns
        unset($validated['library_logo'], $validated['library_catalog_hero_image'], $validated['remove_logo'], $validated['remove_catalog_hero_image']);

        Brand::create($validated);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Marca creada correctamente.');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $this->validateBrand($request, $brand);

        $validated['logo'] = $this->resolveLogo($request, $brand, $validated['logo'] ?? null);
        $validated['catalog_hero_image'] = $this->resolveCatalogHero($request, $brand, $validated['catalog_hero_image'] ?? null);

        unset($validated['library_logo'], $validated['library_catalog_hero_image'], $validated['remove_logo'], $validated['remove_catalog_hero_image']);

        $brand->update($validated);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Marca actualizada correctamente.');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('admin.brands.index')
            ->with('success', 'Marca eliminada correctamente.');
    }

    private function validateBrand(Request $request, ?Brand $brand = null): array
    {
        $slugRule = $brand
            ? 'required|string|max:255|unique:brands,slug,' . $brand->id
            : 'nullable|string|max:255|unique:brands,slug';

        return $request->validate([
            'name' => 'required|string|max:255',
            'slug' => $slugRule,
            'description' => 'nullable|string|max:1000',
            'website_url' => 'nullable|url|max:500',
            'logo' => 'nullable|image|max:2048',
            'library_logo' => 'nullable|string|max:500',
            'remove_logo' => 'nullable|boolean',
            'is_represented' => 'boolean',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
            // Catalog fields
            'catalog_enabled' => 'boolean',
            'catalog_hero_image' => 'nullable|image|max:4096',
            'library_catalog_hero_image' => 'nullable|string|max:500',
            'remove_catalog_hero_image' => 'nullable|boolean',
            'catalog_intro' => 'nullable|string|max:2000',
            'catalog_contact_whatsapp' => 'nullable|string|max:50',
            'catalog_contact_message' => 'nullable|string|max:500',
        ]);
    }

    private function resolveLogo(Request $request, ?Brand $brand, $current)
    {
        if ($request->hasFile('logo')) {
            if ($brand && $brand->logo && !str_starts_with($brand->logo, 'assets/')) {
                Storage::disk('public')->delete($brand->logo);
            }
            return $request->file('logo')->store('brands', 'public');
        }
        if ($request->filled('library_logo')) {
            return ltrim($request->input('library_logo'), '/');
        }
        if ($request->boolean('remove_logo')) {
            if ($brand && $brand->logo && !str_starts_with($brand->logo, 'assets/')) {
                Storage::disk('public')->delete($brand->logo);
            }
            return null;
        }
        return $brand?->logo;
    }

    private function resolveCatalogHero(Request $request, ?Brand $brand, $current)
    {
        if ($request->hasFile('catalog_hero_image')) {
            if ($brand && $brand->catalog_hero_image && !str_starts_with($brand->catalog_hero_image, 'assets/')) {
                Storage::disk('public')->delete($brand->catalog_hero_image);
            }
            return $request->file('catalog_hero_image')->store('brands/catalog', 'public');
        }
        if ($request->filled('library_catalog_hero_image')) {
            return ltrim($request->input('library_catalog_hero_image'), '/');
        }
        if ($request->boolean('remove_catalog_hero_image')) {
            if ($brand && $brand->catalog_hero_image && !str_starts_with($brand->catalog_hero_image, 'assets/')) {
                Storage::disk('public')->delete($brand->catalog_hero_image);
            }
            return null;
        }
        return $brand?->catalog_hero_image;
    }
}
