@php
    /** @var \App\Models\Block $block */
    $data = $data ?? ($block->data ?? []);
    $brandId = isset($data['brand_id']) ? (int) $data['brand_id'] : 0;
    $brand = $brandId ? \App\Models\Brand::find($brandId) : null;

    $isStaff = auth()->check() && auth()->user()->isStaff();

    // Bail silently if brand missing or catalog disabled for non-staff.
    $shouldRender = $brand && ($brand->catalog_enabled || $isStaff);
@endphp

@if($shouldRender)
    @php
        $source = $data['source'] ?? 'all';
        $showSearch = (bool) ($data['show_search'] ?? true);
        $showCategoryFilter = (bool) ($data['show_category_filter'] ?? true);
        $perPage = !empty($data['per_page']) ? (int) $data['per_page'] : (int) (\App\Models\Setting::get('catalog_per_page_default', 12));
        $columns = !empty($data['columns']) ? (int) $data['columns'] : (int) (\App\Models\Setting::get('catalog_columns_default', 4));
        if ($perPage < 1) $perPage = 12;
        if ($columns < 1 || $columns > 6) $columns = 4;

        // URL-driven filters (only meaningful for 'all' and 'category' modes).
        $filterSlugs = ($source !== 'manual' && $showCategoryFilter) ? \App\Services\BrandCatalogFilter::slugsFromRequest() : [];
        $initialSearch = ($source !== 'manual' && $showSearch) ? \App\Services\BrandCatalogFilter::searchFromRequest() : '';

        $query = \App\Services\BrandCatalogFilter::applyBlockFilter($brand, $data, $isStaff, $filterSlugs);

        if ($source === 'manual') {
            $products = $query->get();
        } else {
            $products = $query->paginate($perPage)->withQueryString();
        }

        // Categories shown in the filter row.
        $filterCategories = collect();
        if ($source !== 'manual' && $showCategoryFilter) {
            $catQuery = $brand->catalogCategories()
                ->when(! $isStaff, fn ($q) => $q->active())
                ->orderBy('sort_order')->orderBy('name')
                ->withCount(['productsAny as products_count' => fn ($q) => $isStaff ? $q : $q->where('is_active', true)]);

            // If source === 'category', restrict the filter chips to the picked categories.
            if ($source === 'category') {
                $catIds = array_values(array_filter(array_map('intval', (array) ($data['category_ids'] ?? []))));
                if ($catIds) {
                    $catQuery->whereIn('id', $catIds);
                }
            }
            $filterCategories = $catQuery->get();
        }
        $hasIcons = $filterCategories->whereNotNull('image')->where('image', '!=', '')->count() > 0;

        $resolveImg = function ($img) {
            if (!$img) return null;
            if (preg_match('#^(https?:)?//#', $img)) return $img;
            if (str_starts_with($img, 'assets/') || str_starts_with($img, 'storage/')) return asset($img);
            return asset('storage/' . $img);
        };

        $blockId = $block->id ?? 0;
        $endpoint = route('catalog.block-filter', ['brandSlug' => $brand->slug]) . '?block=' . $blockId;
        $baseUrl = url('catalogo/' . $brand->slug);
    @endphp

    <section class="brand-catalog-block"
             x-data="productFilter({ endpoint: @js($endpoint), slugs: @js($filterSlugs), baseUrl: @js($baseUrl) })">
        <div class="container" :class="loading ? 'is-loading' : ''">
            @if(!empty($data['title']))
                <h2 class="brand-catalog-block-title">{{ $data['title'] }}</h2>
            @endif
            @if(!empty($data['subtitle']))
                <p class="brand-catalog-block-subtitle">{{ $data['subtitle'] }}</p>
            @endif

            @if($source !== 'manual' && $showSearch)
                <div class="brand-catalog-search-wrap">
                    <div class="brand-catalog-search-field">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="search" placeholder="Buscar por nombre, código o descripción…"
                               x-model="search"
                               @input="onSearchInput()"
                               @keydown.escape="onSearchClear()"
                               value="{{ $initialSearch }}">
                        <button type="button" class="brand-catalog-search-clear" x-show="search" @click="onSearchClear()" aria-label="Limpiar búsqueda">✕</button>
                    </div>
                </div>
            @endif

            @if($source !== 'manual' && $showCategoryFilter && $filterCategories->count() > 1)
                <div class="brand-catalog-cat-scroll" x-data="catScroll()" aria-label="Filtro de categorías">
                    <button type="button" class="brand-catalog-cat-arrow" x-show="showPrev" @click="prev()" aria-label="Anterior">&#8249;</button>
                    <div class="brand-catalog-cat-track" x-ref="track">
                        @if($hasIcons)
                            <button type="button" @click="clear()" class="brand-catalog-icon-filter" :class="selected.length === 0 ? 'is-active' : ''">
                                <span class="brand-catalog-icon-filter-img">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" width="20" height="20"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                                </span>
                                <span class="brand-catalog-icon-filter-label">Todas</span>
                            </button>
                            @foreach($filterCategories as $cat)
                                @php $catImgSrc = $cat->image ? $resolveImg($cat->image) : null; @endphp
                                <button type="button" @click="toggle(@js($cat->slug))" class="brand-catalog-icon-filter" :class="selected.includes(@js($cat->slug)) ? 'is-active' : ''">
                                    <span class="brand-catalog-icon-filter-img">
                                        @if($catImgSrc)
                                            <img src="{{ $catImgSrc }}" alt="{{ $cat->name }}">
                                        @else
                                            <span style="font-size:1rem;font-weight:700;color:rgba(0,0,0,0.4);">{{ mb_substr($cat->name, 0, 1) }}</span>
                                        @endif
                                    </span>
                                    <span class="brand-catalog-icon-filter-label">{{ $cat->name }}</span>
                                </button>
                            @endforeach
                        @else
                            <button type="button" @click="clear()" class="brand-catalog-pill" :class="selected.length === 0 ? 'is-active' : ''">
                                Todas
                            </button>
                            @foreach($filterCategories as $cat)
                                <button type="button" @click="toggle(@js($cat->slug))" class="brand-catalog-pill" :class="selected.includes(@js($cat->slug)) ? 'is-active' : ''">
                                    {{ $cat->name }}
                                    <span class="brand-catalog-pill-count">{{ $cat->products_count }}</span>
                                </button>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" class="brand-catalog-cat-arrow" x-show="showNext" @click="next()" aria-label="Siguiente">&#8250;</button>
                </div>
            @endif

            <div class="brand-catalog-results" x-ref="results" @click="onResultsClick($event)">
                @include('public.catalog.partials.products-results', [
                    'brand' => $brand,
                    'products' => $products,
                    'columns' => $columns,
                    'resolveImg' => $resolveImg,
                ])
            </div>
        </div>
    </section>

    @once
        @push('styles')
        <style>
            /* Brand catalog block — light theme variant. Card colors lean on the page background. */
            .brand-catalog-block { padding: 3rem 0; }
            .brand-catalog-block-title { font-size: 1.85rem; font-weight: 700; color: var(--color-primary, #112f83); margin-bottom: .5rem; text-align: center; }
            .brand-catalog-block-subtitle { color: #555; text-align: center; margin-bottom: 2rem; max-width: 720px; margin-left: auto; margin-right: auto; }

            /* Search */
            .brand-catalog-block .brand-catalog-search-wrap { margin-bottom: 1.25rem; }
            .brand-catalog-block .brand-catalog-search-field { display: flex; align-items: center; background: #f5f5f5; border: 1.5px solid #e0e0e0; border-radius: .6rem; padding: .5rem .9rem; gap: .5rem; max-width: 420px; }
            .brand-catalog-block .brand-catalog-search-field:focus-within { border-color: var(--color-accent, #6da339); background: #fff; }
            .brand-catalog-block .brand-catalog-search-field svg { flex-shrink: 0; color: #888; width: 16px; height: 16px; }
            .brand-catalog-block .brand-catalog-search-field input { background: transparent; border: none; outline: none; color: #222; font-size: .9rem; font-family: inherit; flex: 1; }
            .brand-catalog-block .brand-catalog-search-field input::placeholder { color: #999; }
            .brand-catalog-block .brand-catalog-search-clear { background: none; border: none; color: #888; cursor: pointer; padding: 0; line-height: 1; font-size: 1rem; }
            .brand-catalog-block .brand-catalog-search-clear:hover { color: #222; }

            /* Filter row */
            .brand-catalog-block .container.is-loading .brand-catalog-results { opacity: .45; transition: opacity .15s; }
            .brand-catalog-block .brand-catalog-cat-scroll { display: flex; align-items: center; gap: .5rem; margin-bottom: 2rem; }
            .brand-catalog-block .brand-catalog-cat-track { display: flex; gap: .6rem; overflow-x: auto; scroll-behavior: smooth; -webkit-overflow-scrolling: touch; scrollbar-width: none; flex: 1; padding-bottom: 2px; }
            .brand-catalog-block .brand-catalog-cat-track::-webkit-scrollbar { display: none; }
            .brand-catalog-block .brand-catalog-cat-arrow { flex-shrink: 0; display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 50%; background: #eee; border: 1.5px solid #ddd; color: #555; cursor: pointer; font-size: 1.1rem; font-family: inherit; transition: background .15s, color .15s; }
            .brand-catalog-block .brand-catalog-cat-arrow:hover { background: #ddd; color: #222; }
            .brand-catalog-block .brand-catalog-pill { flex-shrink: 0; display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1.2rem; background: #f0f0f0; color: #333; border-radius: 99px; font-size: 0.9rem; font-weight: 500; border: 1px solid #ddd; transition: all .2s ease; cursor: pointer; font-family: inherit; white-space: nowrap; }
            .brand-catalog-block .brand-catalog-pill:hover { background: #e6e6e6; }
            .brand-catalog-block .brand-catalog-pill.is-active { background: var(--color-accent, #6da339); border-color: var(--color-accent, #6da339); color: #fff; }
            .brand-catalog-block .brand-catalog-pill-count { font-size: 0.75rem; opacity: 0.7; background: rgba(0,0,0,0.08); padding: 0.1rem 0.5rem; border-radius: 99px; }
            .brand-catalog-block .brand-catalog-pill.is-active .brand-catalog-pill-count { background: rgba(255,255,255,0.25); }
            .brand-catalog-block .brand-catalog-icon-filter { flex-shrink: 0; display: flex; flex-direction: column; align-items: center; gap: .4rem; background: #f5f5f5; border: 2px solid #e2e2e2; border-radius: .6rem; padding: .6rem .5rem; width: 72px; cursor: pointer; transition: all .15s; font-family: inherit; color: #555; }
            .brand-catalog-block .brand-catalog-icon-filter:hover { background: #ececec; border-color: #ccc; color: #222; }
            .brand-catalog-block .brand-catalog-icon-filter.is-active { background: rgba(109,163,57,0.12); border-color: var(--color-accent, #6da339); color: #222; }
            .brand-catalog-block .brand-catalog-icon-filter-img { width: 38px; height: 38px; border-radius: .35rem; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #fff; }
            .brand-catalog-block .brand-catalog-icon-filter-img img { width: 100%; height: 100%; object-fit: cover; }
            .brand-catalog-block .brand-catalog-icon-filter-label { font-size: .62rem; font-weight: 600; text-align: center; line-height: 1.2; text-transform: uppercase; letter-spacing: .04em; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 68px; }

            /* Grid */
            .brand-catalog-block .brand-catalog-grid { display: grid; gap: 1.5rem; }
            @media (max-width: 900px) { .brand-catalog-block .brand-catalog-grid { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; } }
            .brand-catalog-block .brand-catalog-pagination { margin-top: 2.5rem; display: flex; justify-content: center; }

            /* Card — light variant */
            .brand-catalog-block .brand-catalog-card { display: flex; flex-direction: column; background: #fff; border-radius: 12px; overflow: hidden; text-decoration: none; color: inherit; transition: transform .2s ease, box-shadow .2s ease; border: 1px solid #ececec; }
            .brand-catalog-block .brand-catalog-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,0,0,0.12); border-color: #ddd; }
            .brand-catalog-block .brand-catalog-card-image { aspect-ratio: 4/3; overflow: hidden; background: #f4f4f4; }
            .brand-catalog-block .brand-catalog-card-image img { width: 100%; height: 100%; object-fit: cover; transition: transform .3s ease; }
            .brand-catalog-block .brand-catalog-card:hover .brand-catalog-card-image img { transform: scale(1.05); }
            .brand-catalog-block .brand-catalog-card-placeholder { width: 100%; height: 100%; background: linear-gradient(135deg, #eee, #ddd); }
            .brand-catalog-block .brand-catalog-card-body { padding: 1.1rem; flex: 1; display: flex; flex-direction: column; }
            .brand-catalog-block .brand-catalog-card-category { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--color-accent, #6da339); font-weight: 600; margin-bottom: 0.4rem; }
            .brand-catalog-block .brand-catalog-card-title { font-size: 1.02rem; font-weight: 700; color: #222; margin-bottom: 0.4rem; line-height: 1.3; flex: 1; }
            .brand-catalog-block .brand-catalog-card-desc { font-size: 0.85rem; color: #666; line-height: 1.5; margin-bottom: .7rem; }
            .brand-catalog-block .brand-catalog-card-footer { display: flex; align-items: center; justify-content: space-between; margin-top: auto; }
            .brand-catalog-block .brand-catalog-icon-btn { display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; border-radius: 50%; background: var(--color-accent, #6da339); color: #fff; flex-shrink: 0; transition: filter .15s, transform .15s; }
            .brand-catalog-block .brand-catalog-card:hover .brand-catalog-icon-btn { filter: brightness(1.1); transform: scale(1.08); }
            .brand-catalog-block .brand-catalog-icon-btn svg { width: 16px; height: 16px; }

            .brand-catalog-block .brand-catalog-empty { padding: 3rem 0; text-align: center; color: #888; }
        </style>
        @endpush
    @endonce

    @include('partials.product-filter-script')
@endif
