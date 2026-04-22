<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Shared filtering logic for the Tienda storefront. Used both by the
 * redcase-products block (initial SSR) and the AJAX endpoint so the
 * multi-category semantics stay in one place.
 */
class StoreFilter
{
    /**
     * Parse ?q=search from the current request.
     */
    public static function searchFromRequest(): string
    {
        return trim((string) request()->query('q', ''));
    }

    /**
     * Parse ?categorias=a,b (new, multi) or ?categoria=a (legacy, single).
     *
     * @return array<int,string>  clean list of category slugs
     */
    public static function slugsFromRequest(): array
    {
        $raw = request()->query('categorias', request()->query('categoria', ''));
        if (is_array($raw)) $raw = implode(',', $raw);
        $slugs = array_filter(array_map('trim', explode(',', (string) $raw)));
        return array_values(array_unique($slugs));
    }

    /**
     * Resolve a set of root-category slugs into the union of their IDs
     * plus the IDs of all their children. Any slug that doesn't match a
     * root category is silently dropped (so invalid URLs don't 404).
     *
     * @param  array<int,string>  $slugs
     * @return array{categories: Collection<int,ProductCategory>, ids: array<int,int>}
     */
    public static function resolve(array $slugs): array
    {
        if (! $slugs) {
            return ['categories' => collect(), 'ids' => []];
        }

        $categories = ProductCategory::whereIn('slug', $slugs)
            ->whereNull('parent_id')
            ->with('children:id,parent_id')
            ->get();

        $ids = [];
        foreach ($categories as $cat) {
            $ids[] = $cat->id;
            foreach ($cat->children as $child) $ids[] = $child->id;
        }

        return ['categories' => $categories, 'ids' => array_values(array_unique($ids))];
    }

    /**
     * Build the product query honouring:
     *   - block `source`/`category_id`/`product_ids`
     *   - multi-category URL filter
     *   - staff preview (include inactive products)
     *
     * @param  array<string,mixed>  $blockData
     * @param  array<int,string>    $filterSlugs
     */
    public static function productsQuery(array $blockData, array $filterSlugs)
    {
        $source = $blockData['source'] ?? 'all';
        $isStaff = auth()->check() && auth()->user()->isStaff();

        $query = Product::with('category')->orderBy('sort_order');
        if (! $isStaff) $query->active();

        if ($source === 'category' && !empty($blockData['category_id'])) {
            $query->whereHas('categories', fn ($q) => $q->where('product_categories.id', $blockData['category_id']));
        } elseif ($source === 'manual' && !empty($blockData['product_ids']) && is_array($blockData['product_ids'])) {
            $query->whereIn('id', $blockData['product_ids']);
        }

        if ($filterSlugs) {
            $ids = self::resolve($filterSlugs)['ids'];
            if ($ids) {
                $query->whereHas('categories', fn ($q) => $q->whereIn('product_categories.id', $ids));
            }
        }

        $search = self::searchFromRequest();
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        return $query;
    }

    /**
     * Per-category product counts (includes root + children) for the pill bar.
     * Uses the pivot so products appearing in multiple categories are counted
     * under each.
     *
     * @return Collection<int,ProductCategory>  each with ->filter_count
     */
    public static function pillCategories(): Collection
    {
        $isStaff = auth()->check() && auth()->user()->isStaff();

        return ProductCategory::whereNull('parent_id')
            ->orderBy('sort_order')
            ->with('children:id,parent_id')
            ->get()
            ->map(function (ProductCategory $cat) use ($isStaff) {
                $ids = collect([$cat->id])->merge($cat->children->pluck('id'))->all();
                $q = Product::whereHas('categories', fn ($q) => $q->whereIn('product_categories.id', $ids));
                if (! $isStaff) $q->where('is_active', true);
                $cat->filter_count = $q->count();
                return $cat;
            });
    }
}
