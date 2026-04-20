@php
    $showCategoryFilter = (bool) ($data['show_category_filter'] ?? false);
    $showPrice = (bool) ($data['show_price'] ?? true);

    $filterSlugs = $showCategoryFilter ? \App\Services\StoreFilter::slugsFromRequest() : [];

    $query = \App\Services\StoreFilter::productsQuery($data, $filterSlugs);

    $filterCategories = $showCategoryFilter ? \App\Services\StoreFilter::pillCategories() : collect();

    $storeColumns = (int) \App\Models\Setting::get('store_columns', 4);
    $storePerPage = !empty($data['per_page']) ? (int) $data['per_page'] : (int) \App\Models\Setting::get('store_per_page', 12);
    if ($storeColumns < 1) $storeColumns = 4;
    if ($storePerPage < 1) $storePerPage = 12;

    $source = $data['source'] ?? 'all';
    if ($source === 'manual') {
        $products = $query->get();
        $paginated = null;
    } else {
        $paginated = $query->paginate($storePerPage)->withQueryString();
        $products = $paginated;
    }

    $resolveImg = function ($img) {
        if (!$img) return null;
        if (preg_match('#^(https?:)?//#', $img)) return $img;
        if (str_starts_with($img, 'assets/') || str_starts_with($img, 'storage/')) return asset($img);
        return asset('storage/' . $img);
    };

    $blockId = $block->id ?? 0;
    $endpoint = route('store.filter') . '?block=' . $blockId;
@endphp
<section class="redcase-products" style="background:#1a1a1a;"
         x-data="productFilter({ endpoint: @js($endpoint), slugs: @js($filterSlugs), baseUrl: @js(url('tienda-online')) })">
    <style>
        .redcase-products-grid { display: grid; grid-template-columns: repeat({{ $storeColumns }}, minmax(0, 1fr)); gap: 1.5rem; }
        @media (max-width: 900px) { .redcase-products-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (max-width: 560px) { .redcase-products-grid { grid-template-columns: 1fr; } }
        .redcase-pagination { margin-top: 2.5rem; display: flex; justify-content: center; }
        .redcase-pagination nav { color: rgba(255,255,255,0.9); }
        .redcase-pagination nav a, .redcase-pagination nav span { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: rgba(255,255,255,0.85); }
        .redcase-pagination nav a:hover { background: rgba(255,255,255,0.12); }
        .redcase-category-filter { display: flex; flex-wrap: wrap; gap: .5rem; margin-bottom: 2rem; }
        .redcase-filter-pill { display: inline-flex; align-items: center; gap: .4rem; padding: .45rem 1rem; border-radius: 9999px; font-size: .875rem; font-weight: 500; border: 2px solid rgba(255,255,255,0.2); color: rgba(255,255,255,0.75); background: transparent; cursor: pointer; transition: all .15s; font-family: inherit; }
        .redcase-filter-pill:hover { border-color: rgba(255,255,255,0.5); color: #fff; }
        .redcase-filter-pill.is-active { background: #d32f2f; border-color: #d32f2f; color: #fff; }
        .redcase-filter-count { background: rgba(255,255,255,0.2); border-radius: 9999px; padding: .1rem .45rem; font-size: .75rem; }
        .redcase-filter-pill.is-active .redcase-filter-count { background: rgba(255,255,255,0.3); }
        .redcase-products.is-loading .redcase-results { opacity: .45; transition: opacity .15s; }
        .redcase-products .redcase-product-info { padding: 1rem 1rem 1.1rem; }
        .redcase-products .redcase-product-category { margin-bottom: .35rem; font-size: .72rem; }
        .redcase-products .redcase-product-name { margin: 0 0 .35rem; }
        .redcase-products .redcase-product-price { color: #6da339; font-size: 1rem; font-weight: 700; margin: 0 0 .5rem; }
        .redcase-products .redcase-product-btn { padding: .4rem 1.1rem; font-size: .78rem; font-weight: 500; }
    </style>
    <div class="container" :class="loading ? 'is-loading' : ''">
        @if(!empty($data['title']))
            <h2 class="redcase-section-title">{{ $data['title'] }}</h2>
        @endif
        @if(!empty($data['subtitle']))
            <p class="redcase-section-subtitle">{{ $data['subtitle'] }}</p>
        @endif

        @if($showCategoryFilter && $filterCategories->count())
            <nav class="redcase-category-filter" aria-label="Filtro de categorías">
                <button type="button"
                        @click="clear()"
                        class="redcase-filter-pill"
                        :class="selected.length === 0 ? 'is-active' : ''">
                    Todas
                    <span class="redcase-filter-count">{{ $filterCategories->sum('filter_count') }}</span>
                </button>
                @foreach($filterCategories as $cat)
                    @if($cat->filter_count > 0)
                        <button type="button"
                                @click="toggle(@js($cat->slug))"
                                class="redcase-filter-pill"
                                :class="selected.includes(@js($cat->slug)) ? 'is-active' : ''">
                            {{ $cat->name }}
                            <span class="redcase-filter-count">{{ $cat->filter_count }}</span>
                        </button>
                    @endif
                @endforeach
            </nav>
        @endif

        <div class="redcase-results" x-ref="results" @click="onResultsClick($event)">
            @include('blocks.partials.redcase-products-results', [
                'products' => $products,
                'paginated' => $paginated,
                'showPrice' => $showPrice,
                'resolveImg' => $resolveImg,
            ])
        </div>
    </div>
</section>

@include('partials.product-filter-script')
