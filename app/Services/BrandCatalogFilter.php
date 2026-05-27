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
     * Parse ?q=search from the current request.
     */
    public static function searchFromRequest(): string
    {
        return trim((string) request()->query('q', ''));
    }

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

        $search = self::searchFromRequest();
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('short_description', 'like', '%' . $search . '%');
            });
        }

        return $query;
    }

    /**
     * Build a CatalogProduct query scoped by a brand-catalog block's data.
     *
     * Block data shape:
     *   source        => 'all' | 'category' | 'manual'
     *   category_ids  => int[]  (used when source = 'category')
     *   product_ids   => int[]  (used when source = 'manual', preserves order)
     *
     * URL slug filters and ?q= search apply on top of 'all' and 'category'
     * modes; manual mode shows exactly the picked products in the picked order.
     *
     * @param  array<string,mixed>  $data
     * @param  array<int,string>  $filterSlugs
     */
    public static function applyBlockFilter(Brand $brand, array $data, bool $isStaff, array $filterSlugs = [])
    {
        $source = $data['source'] ?? 'all';
        $query = $brand->catalogProducts()->with('category');

        if (! $isStaff) $query->active();

        if ($source === 'manual') {
            $ids = array_values(array_filter(array_map('intval', (array) ($data['product_ids'] ?? []))));
            if (! $ids) {
                $query->whereRaw('1 = 0');
                return $query;
            }
            $query->whereIn('id', $ids);
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $query->orderByRaw("FIELD(id, $placeholders)", $ids);
            return $query;
        }

        if ($source === 'category') {
            $catIds = array_values(array_filter(array_map('intval', (array) ($data['category_ids'] ?? []))));
            if ($catIds) {
                $query->whereHas('categories', fn ($q) => $q->whereIn('catalog_categories.id', $catIds));
            }
        }

        // URL-driven slug + search filters layer on top.
        self::applyFilter($query, $brand, $filterSlugs);

        $query->orderBy('sort_order')->orderBy('name');
        return $query;
    }
}
