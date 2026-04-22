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
    $initialSearch = \App\Services\StoreFilter::searchFromRequest();

    $hasIcons = $showCategoryFilter && $filterCategories->whereNotNull('image')->where('image', '!=', '')->count() > 0;
@endphp
<section class="redcase-products" style="background:#1a1a1a;"
         x-data="productFilter({ endpoint: @js($endpoint), slugs: @js($filterSlugs), baseUrl: @js(url('tienda-online')) })">
    <style>
        .redcase-products-grid { display: grid; grid-template-columns: repeat({{ $storeColumns }}, minmax(0, 1fr)); gap: 1.5rem; }
        @media (max-width: 900px) { .redcase-products-grid { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; } }
        .redcase-pagination { margin-top: 2.5rem; display: flex; justify-content: center; }
        .redcase-pagination nav { color: rgba(255,255,255,0.9); }
        .redcase-pagination nav a, .redcase-pagination nav span { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: rgba(255,255,255,0.85); }
        .redcase-pagination nav a:hover { background: rgba(255,255,255,0.12); }
        /* Category scroll row */
        .redcase-cat-scroll { display: flex; align-items: center; gap: .5rem; margin-bottom: 2rem; }
        .redcase-cat-track { display: flex; gap: .6rem; overflow-x: auto; scroll-behavior: smooth; -webkit-overflow-scrolling: touch; scrollbar-width: none; flex: 1; padding-bottom: 2px; }
        .redcase-cat-track::-webkit-scrollbar { display: none; }
        .redcase-cat-arrow { flex-shrink: 0; display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 50%; background: rgba(255,255,255,0.08); border: 1.5px solid rgba(255,255,255,0.18); color: rgba(255,255,255,0.8); cursor: pointer; font-size: 1.1rem; font-family: inherit; transition: background .15s, color .15s; }
        .redcase-cat-arrow:hover { background: rgba(255,255,255,0.18); color: #fff; }
        /* Pill style (no images) */
        .redcase-filter-pill { flex-shrink: 0; display: inline-flex; align-items: center; gap: .4rem; padding: .45rem 1rem; border-radius: 9999px; font-size: .875rem; font-weight: 500; border: 2px solid rgba(255,255,255,0.2); color: rgba(255,255,255,0.75); background: transparent; cursor: pointer; transition: all .15s; font-family: inherit; white-space: nowrap; }
        .redcase-filter-pill:hover { border-color: rgba(255,255,255,0.5); color: #fff; }
        .redcase-filter-pill.is-active { background: #d32f2f; border-color: #d32f2f; color: #fff; }
        .redcase-filter-count { background: rgba(255,255,255,0.2); border-radius: 9999px; padding: .1rem .45rem; font-size: .75rem; }
        .redcase-filter-pill.is-active .redcase-filter-count { background: rgba(255,255,255,0.3); }
        /* Icon style (with images) */
        .redcase-filter-icon { flex-shrink: 0; display: flex; flex-direction: column; align-items: center; gap: .4rem; background: rgba(255,255,255,0.06); border: 2px solid rgba(255,255,255,0.08); border-radius: .6rem; padding: .6rem .5rem; width: 72px; cursor: pointer; transition: all .15s; font-family: inherit; color: rgba(255,255,255,0.75); }
        .redcase-filter-icon:hover { background: rgba(255,255,255,0.12); border-color: rgba(255,255,255,0.25); color: #fff; }
        .redcase-filter-icon.is-active { background: rgba(211,47,47,0.2); border-color: #d32f2f; color: #fff; }
        .redcase-filter-icon-img { width: 38px; height: 38px; border-radius: .35rem; overflow: hidden; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.08); }
        .redcase-filter-icon-img img { width: 100%; height: 100%; object-fit: cover; }
        .redcase-filter-icon-label { font-size: .62rem; font-weight: 600; text-align: center; line-height: 1.2; text-transform: uppercase; letter-spacing: .04em; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 68px; }
        /* Product card */
        .redcase-products.is-loading .redcase-results { opacity: .45; transition: opacity .15s; }
        .redcase-products .redcase-product-info { padding: 1rem 1rem 1.1rem; display: flex; flex-direction: column; flex: 1; text-align: left; }
        .redcase-products .redcase-product-category { margin-bottom: .35rem; font-size: .72rem; }
        .redcase-products .redcase-product-name { margin: 0 0 .5rem; flex: 1; }
        .redcase-products .redcase-product-price { color: #6da339; font-size: 1rem; font-weight: 700; }
        .redcase-product-footer { display: flex; align-items: center; justify-content: space-between; margin-top: .5rem; gap: .5rem; }
        .redcase-icon-btn { display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; border-radius: 50%; background: #d32f2f; color: #fff; flex-shrink: 0; transition: background .15s, transform .15s; }
        .redcase-product-card:hover .redcase-icon-btn { background: #b71c1c; transform: scale(1.08); }
        .redcase-icon-btn svg { width: 16px; height: 16px; }
        /* Search */
        .redcase-search-wrap { margin-bottom: 1.5rem; }
        .redcase-search-field { display: flex; align-items: center; background: rgba(255,255,255,0.07); border: 1.5px solid rgba(255,255,255,0.15); border-radius: .6rem; padding: .5rem .9rem; gap: .5rem; max-width: 420px; }
        .redcase-search-field:focus-within { border-color: rgba(255,255,255,0.35); background: rgba(255,255,255,0.1); }
        .redcase-search-field svg { flex-shrink: 0; color: rgba(255,255,255,0.45); width: 16px; height: 16px; }
        .redcase-search-field input { background: transparent; border: none; outline: none; color: #fff; font-size: .9rem; font-family: inherit; flex: 1; }
        .redcase-search-field input::placeholder { color: rgba(255,255,255,0.4); }
        .redcase-search-clear { background: none; border: none; color: rgba(255,255,255,0.45); cursor: pointer; padding: 0; line-height: 1; font-size: 1rem; }
        .redcase-search-clear:hover { color: #fff; }
    </style>
    <div class="container" :class="loading ? 'is-loading' : ''">
        @if(!empty($data['title']))
            <h2 class="redcase-section-title">{{ $data['title'] }}</h2>
        @endif
        @if(!empty($data['subtitle']))
            <p class="redcase-section-subtitle">{{ $data['subtitle'] }}</p>
        @endif

        {{-- Search --}}
        <div class="redcase-search-wrap">
            <div class="redcase-search-field">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="search" placeholder="Buscar por nombre, código o descripción…"
                       x-model="search"
                       @input="onSearchInput()"
                       @keydown.escape="onSearchClear()"
                       value="{{ $initialSearch }}">
                <button type="button" class="redcase-search-clear" x-show="search" @click="onSearchClear()" aria-label="Limpiar búsqueda">✕</button>
            </div>
        </div>

        @if($showCategoryFilter && $filterCategories->count())
            <div class="redcase-cat-scroll" x-data="catScroll()" aria-label="Filtro de categorías">
                <button type="button" class="redcase-cat-arrow" x-show="showPrev" @click="prev()" aria-label="Anterior">&#8249;</button>
                <div class="redcase-cat-track" x-ref="track">
                    @if($hasIcons)
                        <button type="button" @click="clear()" class="redcase-filter-icon" :class="selected.length === 0 ? 'is-active' : ''">
                            <span class="redcase-filter-icon-img">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" width="20" height="20"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                            </span>
                            <span class="redcase-filter-icon-label">Todas</span>
                        </button>
                        @foreach($filterCategories as $cat)
                            @if($cat->filter_count > 0)
                                @php $catImgSrc = $cat->image ? (preg_match('#^(https?:)?//#', $cat->image) ? $cat->image : (str_starts_with($cat->image, 'assets/') || str_starts_with($cat->image, 'storage/') ? asset($cat->image) : asset('storage/' . $cat->image))) : null; @endphp
                                <button type="button" @click="toggle(@js($cat->slug))" class="redcase-filter-icon" :class="selected.includes(@js($cat->slug)) ? 'is-active' : ''">
                                    <span class="redcase-filter-icon-img">
                                        @if($catImgSrc)
                                            <img src="{{ $catImgSrc }}" alt="{{ $cat->name }}">
                                        @else
                                            <span style="font-size:1rem;font-weight:700;color:rgba(255,255,255,0.6);">{{ mb_substr($cat->name, 0, 1) }}</span>
                                        @endif
                                    </span>
                                    <span class="redcase-filter-icon-label">{{ $cat->name }}</span>
                                </button>
                            @endif
                        @endforeach
                    @else
                        <button type="button" @click="clear()" class="redcase-filter-pill" :class="selected.length === 0 ? 'is-active' : ''">
                            Todas
                            <span class="redcase-filter-count">{{ $filterCategories->sum('filter_count') }}</span>
                        </button>
                        @foreach($filterCategories as $cat)
                            @if($cat->filter_count > 0)
                                <button type="button" @click="toggle(@js($cat->slug))" class="redcase-filter-pill" :class="selected.includes(@js($cat->slug)) ? 'is-active' : ''">
                                    {{ $cat->name }}
                                    <span class="redcase-filter-count">{{ $cat->filter_count }}</span>
                                </button>
                            @endif
                        @endforeach
                    @endif
                </div>
                <button type="button" class="redcase-cat-arrow" x-show="showNext" @click="next()" aria-label="Siguiente">&#8250;</button>
            </div>
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
