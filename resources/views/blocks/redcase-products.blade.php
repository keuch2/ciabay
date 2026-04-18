@php
    $source = $data['source'] ?? 'all';
    $showCategoryFilter = (bool) ($data['show_category_filter'] ?? false);
    $showPrice = (bool) ($data['show_price'] ?? false);
    $isStaff = auth()->check() && auth()->user()->isStaff();

    $query = \App\Models\Product::with('category')->orderBy('sort_order');
    if (! $isStaff) $query->active();

    if ($source === 'category' && !empty($data['category_id'])) {
        $query->where('product_category_id', $data['category_id']);
    } elseif ($source === 'manual' && !empty($data['product_ids']) && is_array($data['product_ids'])) {
        $query->whereIn('id', $data['product_ids']);
    }

    // Category filter pills (front-end URL filter)
    $activeCategory = null;
    $filterCategories = collect();
    if ($showCategoryFilter) {
        $filterCategories = \App\Models\ProductCategory::roots()
            ->orderBy('sort_order')
            ->get()
            ->map(function ($cat) use ($isStaff) {
                $q = $cat->products();
                if (!$isStaff) $q->where('is_active', true);
                $childIds = $cat->children()->pluck('id');
                $catQuery = \App\Models\Product::where(function($q2) use ($cat, $childIds) {
                    $q2->where('product_category_id', $cat->id)
                       ->orWhereIn('product_category_id', $childIds);
                });
                if (!$isStaff) $catQuery->where('is_active', true);
                $cat->filter_count = $catQuery->count();
                return $cat;
            });

        $activeCategorySlug = request()->get('categoria');
        if ($activeCategorySlug) {
            $activeCategory = \App\Models\ProductCategory::roots()->where('slug', $activeCategorySlug)->first();
            if ($activeCategory) {
                $childIds = $activeCategory->children()->pluck('id');
                $query->where(function ($q) use ($activeCategory, $childIds) {
                    $q->where('product_category_id', $activeCategory->id)
                      ->orWhereIn('product_category_id', $childIds);
                });
            }
        }
    }

    $storeColumns = (int) \App\Models\Setting::get('store_columns', 4);
    $storePerPage = !empty($data['per_page']) ? (int) $data['per_page'] : (int) \App\Models\Setting::get('store_per_page', 12);
    if ($storeColumns < 1) $storeColumns = 4;
    if ($storePerPage < 1) $storePerPage = 12;

    // Manual selection uses fixed list (no pagination); other sources paginate.
    if ($source === 'manual') {
        $products = $query->get();
        $paginated = null;
    } else {
        $paginated = $query->paginate($storePerPage)->withQueryString();
        $products = $paginated;
    }

    $resolveImg = function($img) {
        if (!$img) return null;
        if (preg_match('#^(https?:)?//#', $img)) return $img;
        if (str_starts_with($img, 'assets/') || str_starts_with($img, 'storage/')) return asset($img);
        return asset('storage/' . $img);
    };
@endphp
<section class="redcase-products" style="background:#1a1a1a;">
    <style>
        .redcase-products-grid { display: grid; grid-template-columns: repeat({{ $storeColumns }}, minmax(0, 1fr)); gap: 1.5rem; }
        @media (max-width: 900px) { .redcase-products-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (max-width: 560px) { .redcase-products-grid { grid-template-columns: 1fr; } }
        .redcase-pagination { margin-top: 2.5rem; display: flex; justify-content: center; }
        .redcase-pagination nav { color: rgba(255,255,255,0.9); }
        .redcase-pagination nav a, .redcase-pagination nav span { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: rgba(255,255,255,0.85); }
        .redcase-pagination nav a:hover { background: rgba(255,255,255,0.12); }
        .redcase-category-filter { display: flex; flex-wrap: wrap; gap: .5rem; margin-bottom: 2rem; }
        .redcase-filter-pill { display: inline-flex; align-items: center; gap: .4rem; padding: .45rem 1rem; border-radius: 9999px; font-size: .875rem; font-weight: 500; border: 2px solid rgba(255,255,255,0.2); color: rgba(255,255,255,0.75); text-decoration: none; transition: all .15s; }
        .redcase-filter-pill:hover { border-color: rgba(255,255,255,0.5); color: #fff; }
        .redcase-filter-pill.is-active { background: #d32f2f; border-color: #d32f2f; color: #fff; }
        .redcase-filter-count { background: rgba(255,255,255,0.2); border-radius: 9999px; padding: .1rem .45rem; font-size: .75rem; }
        .redcase-filter-pill.is-active .redcase-filter-count { background: rgba(255,255,255,0.3); }
        .redcase-product-price { color: #6da339; font-size: .95rem; font-weight: 700; margin-top: .25rem; }
    </style>
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="redcase-section-title">{{ $data['title'] }}</h2>
        @endif
        @if(!empty($data['subtitle']))
            <p class="redcase-section-subtitle">{{ $data['subtitle'] }}</p>
        @endif

        @if($showCategoryFilter && $filterCategories->count())
            <nav class="redcase-category-filter">
                <a href="{{ url('tienda-online') }}"
                   class="redcase-filter-pill {{ !$activeCategory ? 'is-active' : '' }}">
                    Todas
                    <span class="redcase-filter-count">{{ $filterCategories->sum('filter_count') }}</span>
                </a>
                @foreach($filterCategories as $cat)
                    @if($cat->filter_count > 0)
                        <a href="{{ url('tienda-online') }}?categoria={{ $cat->slug }}"
                           class="redcase-filter-pill {{ $activeCategory?->id === $cat->id ? 'is-active' : '' }}">
                            {{ $cat->name }}
                            <span class="redcase-filter-count">{{ $cat->filter_count }}</span>
                        </a>
                    @endif
                @endforeach
            </nav>
        @endif

        <div class="redcase-products-grid">
            @forelse($products as $product)
                <a href="{{ url('tienda-online/' . $product->slug) }}" class="redcase-product-card" style="text-decoration:none;color:inherit;display:flex;flex-direction:column;">
                    <div class="redcase-product-image">
                        @php $src = $resolveImg($product->image); @endphp
                        @if($src)
                            <img src="{{ $src }}" alt="{{ $product->name }}">
                        @else
                            <div style="width:100%;height:100%;background:#f3f4f6;display:flex;align-items:center;justify-content:center;color:#9ca3af;font-size:0.85rem;">Sin imagen</div>
                        @endif
                    </div>
                    <div class="redcase-product-info">
                        <h3 class="redcase-product-name">{{ $product->name }}</h3>
                        @if($product->category)
                            <span class="redcase-product-category">{{ $product->category->name }}</span>
                        @endif
                        @if($showPrice && $product->price)
                            <div class="redcase-product-price">Gs. {{ number_format((int) $product->price, 0, ',', '.') }}</div>
                        @endif
                        <span class="redcase-product-btn">Ver Detalles</span>
                    </div>
                </a>
            @empty
                <p style="grid-column: 1 / -1; text-align:center; color:#666; padding:3rem 0;">No hay productos disponibles.</p>
            @endforelse
        </div>

        @if($paginated && $paginated->hasPages())
            <div class="redcase-pagination">
                {{ $paginated->links() }}
            </div>
        @endif
    </div>
</section>
