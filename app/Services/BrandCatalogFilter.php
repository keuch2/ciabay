<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Brand;
use App\Models\CatalogCategory;
use Illuminate\Support\Collection;

/**
 * Shared filtering logic for a brand catalog. The public show view and
 * the AJAX endpoint both go through here so multi-category semantics
 * stay consistent.
 */
class BrandCatalogFilter
{
    /**
     * @return array<int,string>
     */
    public static function slugsFromRequest(): array
    {
        $raw = request()->query('categorias', request()->query('categoria', ''));
        if (is_array($raw)) $raw = implode(',', $raw);
        $slugs = array_filter(array_map('trim', explode(',', (string) $raw)));
        return array_values(array_unique($slugs));
    }

    /**
     * Resolve slugs within a brand's catalog. Slugs that don't belong to
     * this brand's catalog are dropped (can't cross brands).
     *
     * @param  array<int,string>  $slugs
     * @return Collection<int,CatalogCategory>
     */
    public static function resolve(Brand $brand, array $slugs): Collection
    {
        if (! $slugs) return collect();

        return $brand->catalogCategories()
            ->whereIn('slug', $slugs)
            ->get();
    }

    /**
     * Accepts any Builder/Relation — returns it so callers can chain.
     */
    public static function applyFilter($query, Brand $brand, array $slugs)
    {
        $resolved = self::resolve($brand, $slugs);
        if ($resolved->isNotEmpty()) {
            $ids = $resolved->pluck('id')->all();
            $query->whereHas('categories', fn ($q) => $q->whereIn('catalog_categories.id', $ids));
        }
        return $query;
    }
}
