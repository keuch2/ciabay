@extends('layouts.public', [
    'metaTitle' => 'Catálogo ' . $brand->name . ' | Ciabay',
    'metaDescription' => \Illuminate\Support\Str::limit(strip_tags($brand->catalog_intro ?? $brand->description ?? 'Catálogo oficial ' . $brand->name), 160),
])

@php
    $resolveImg = function ($img) {
        if (!$img) return null;
        if (preg_match('#^(https?:)?//#', $img)) return $img;
        if (str_starts_with($img, 'assets/') || str_starts_with($img, 'storage/')) return asset($img);
        return asset('storage/' . $img);
    };
    $heroSrc = $resolveImg($brand->catalog_hero_image);
    $logoSrc = $resolveImg($brand->logo);
    $filterEndpoint = route('catalog.filter', ['brandSlug' => $brand->slug]);
    $selectedSlugs = $selectedSlugs ?? [];
    $initialSearch = \App\Services\BrandCatalogFilter::searchFromRequest();
    $hasIcons = $categories->whereNotNull('image')->where('image', '!=', '')->count() > 0;
@endphp

@section('content')
<main class="main-content">
    {{-- Hero --}}
    <section class="brand-catalog-hero">
        @if($heroSrc)
            <div class="brand-catalog-hero-bg">
                <img src="{{ $heroSrc }}" alt="{{ $brand->name }}">
            </div>
        @endif
        <div class="brand-catalog-hero-overlay">
            <div class="container">
                <div class="brand-catalog-hero-content">
                    @if($logoSrc)
                        <img src="{{ $logoSrc }}" alt="{{ $brand->name }}" class="brand-catalog-hero-logo">
                    @endif
                    <h1 class="brand-catalog-hero-title">Catálogo {{ $brand->name }}</h1>
                    @if($brand->catalog_intro)
                        <p class="brand-catalog-hero-subtitle">{{ $brand->catalog_intro }}</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Category submenu + products grid --}}
    <section class="brand-catalog-section"
             x-data="productFilter({ endpoint: @js($filterEndpoint), slugs: @js($selectedSlugs), baseUrl: @js(url('catalogo/' . $brand->slug)) })">
        <div class="container" :class="loading ? 'is-loading' : ''">

            {{-- Search --}}
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

            @if($categories->count())
                <nav class="brand-catalog-categories" aria-label="Filtro de categorías">
                    @if($hasIcons)
                        {{-- Icon-card style --}}
                        <button type="button" @click="clear()" class="brand-catalog-icon-filter" :class="selected.length === 0 ? 'is-active' : ''">
                            <span class="brand-catalog-icon-filter-img">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" width="22" height="22"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                            </span>
                            <span class="brand-catalog-icon-filter-label">Todas</span>
                        </button>
                        @foreach($categories as $cat)
                            @php $catImgSrc = $cat->image ? $resolveImg($cat->image) : null; @endphp
                            <button type="button" @click="toggle(@js($cat->slug))" class="brand-catalog-icon-filter" :class="selected.includes(@js($cat->slug)) ? 'is-active' : ''">
                                <span class="brand-catalog-icon-filter-img">
                                    @if($catImgSrc)
                                        <img src="{{ $catImgSrc }}" alt="{{ $cat->name }}">
                                    @else
                                        <span style="font-size:1.1rem;font-weight:700;color:rgba(255,255,255,0.6);">{{ mb_substr($cat->name, 0, 1) }}</span>
                                    @endif
                                </span>
                                <span class="brand-catalog-icon-filter-label">{{ $cat->name }}</span>
                            </button>
                        @endforeach
                    @else
                        {{-- Pill style --}}
                        <button type="button" @click="clear()"
                                class="brand-catalog-pill"
                                :class="selected.length === 0 ? 'is-active' : ''">
                            Todas
                        </button>
                        @foreach($categories as $cat)
                            <button type="button" @click="toggle(@js($cat->slug))"
                                    class="brand-catalog-pill"
                                    :class="selected.includes(@js($cat->slug)) ? 'is-active' : ''">
                                {{ $cat->name }}
                                <span class="brand-catalog-pill-count">{{ $cat->products_count }}</span>
                            </button>
                        @endforeach
                    @endif
                </nav>
            @endif

            @if($selectedCategories->count() === 1 && $selectedCategories->first()->description)
                <p class="brand-catalog-category-description">{{ $selectedCategories->first()->description }}</p>
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
</main>

@push('styles')
<style>
.main-content:has(.brand-catalog-hero) { background: #1a1a1a; color: #fff; }
.brand-catalog-hero { position: relative; min-height: 360px; overflow: hidden; background: #111; }
.brand-catalog-hero-bg { position: absolute; inset: 0; }
.brand-catalog-hero-bg img { width: 100%; height: 100%; object-fit: cover; opacity: 0.45; }
.brand-catalog-hero-overlay { position: relative; z-index: 2; padding: 6rem 0 4rem; background: linear-gradient(180deg, rgba(26,26,26,0.3) 0%, rgba(26,26,26,0.85) 100%); }
.brand-catalog-hero-content { max-width: 760px; }
.brand-catalog-hero-logo { max-width: 180px; max-height: 80px; object-fit: contain; margin-bottom: 1.5rem; filter: brightness(0) invert(1); }
.brand-catalog-hero-title { font-size: 2.75rem; font-weight: 700; color: #fff; margin-bottom: 1rem; line-height: 1.1; }
.brand-catalog-hero-subtitle { font-size: 1.125rem; color: rgba(255,255,255,0.85); line-height: 1.6; max-width: 620px; }

.brand-catalog-section { padding: 3rem 0 5rem; background: #1a1a1a; }

/* Search */
.brand-catalog-search-wrap { margin-bottom: 1.5rem; }
.brand-catalog-search-field { display: flex; align-items: center; background: rgba(255,255,255,0.07); border: 1.5px solid rgba(255,255,255,0.15); border-radius: .6rem; padding: .5rem .9rem; gap: .5rem; max-width: 420px; }
.brand-catalog-search-field:focus-within { border-color: rgba(255,255,255,0.35); background: rgba(255,255,255,0.1); }
.brand-catalog-search-field svg { flex-shrink: 0; color: rgba(255,255,255,0.45); width: 16px; height: 16px; }
.brand-catalog-search-field input { background: transparent; border: none; outline: none; color: #fff; font-size: .9rem; font-family: inherit; flex: 1; }
.brand-catalog-search-field input::placeholder { color: rgba(255,255,255,0.4); }
.brand-catalog-search-clear { background: none; border: none; color: rgba(255,255,255,0.45); cursor: pointer; padding: 0; line-height: 1; font-size: 1rem; }
.brand-catalog-search-clear:hover { color: #fff; }

/* Category filter */
.brand-catalog-categories { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 2rem; }
.brand-catalog-pill { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1.2rem; background: rgba(255,255,255,0.08); color: #fff; text-decoration: none; border-radius: 99px; font-size: 0.9rem; font-weight: 500; border: 1px solid rgba(255,255,255,0.1); transition: all .2s ease; cursor: pointer; font-family: inherit; }
.brand-catalog-section.is-loading .brand-catalog-results, .brand-catalog-section .is-loading .brand-catalog-results { opacity: .45; transition: opacity .15s; }
.container.is-loading .brand-catalog-results { opacity: .45; transition: opacity .15s; }
.brand-catalog-pill:hover { background: rgba(255,255,255,0.15); border-color: rgba(255,255,255,0.3); }
.brand-catalog-pill.is-active { background: var(--color-accent, #6da339); border-color: var(--color-accent, #6da339); color: #fff; }
.brand-catalog-pill-count { font-size: 0.75rem; opacity: 0.7; background: rgba(0,0,0,0.2); padding: 0.1rem 0.5rem; border-radius: 99px; }

/* Icon-card filter */
.brand-catalog-icon-filter { display: flex; flex-direction: column; align-items: center; gap: .4rem; background: rgba(255,255,255,0.06); border: 2px solid rgba(255,255,255,0.08); border-radius: .6rem; padding: .6rem .5rem; width: 76px; cursor: pointer; transition: all .15s; font-family: inherit; color: rgba(255,255,255,0.75); }
.brand-catalog-icon-filter:hover { background: rgba(255,255,255,0.12); border-color: rgba(255,255,255,0.25); color: #fff; }
.brand-catalog-icon-filter.is-active { background: rgba(109,163,57,0.2); border-color: var(--color-accent, #6da339); color: #fff; }
.brand-catalog-icon-filter-img { width: 40px; height: 40px; border-radius: .35rem; overflow: hidden; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.08); }
.brand-catalog-icon-filter-img img { width: 100%; height: 100%; object-fit: cover; }
.brand-catalog-icon-filter-label { font-size: .65rem; font-weight: 600; text-align: center; line-height: 1.2; text-transform: uppercase; letter-spacing: .04em; }

.brand-catalog-category-description { color: rgba(255,255,255,0.7); font-size: 0.95rem; margin-bottom: 2rem; max-width: 700px; }

/* Grid */
.brand-catalog-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.5rem; }
@media (max-width: 900px) { .brand-catalog-grid { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; } }
.brand-catalog-pagination { margin-top: 3rem; display: flex; justify-content: center; }
.brand-catalog-pagination nav { color: rgba(255,255,255,0.9); }
.brand-catalog-pagination nav a, .brand-catalog-pagination nav span { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: rgba(255,255,255,0.85); }
.brand-catalog-pagination nav a:hover { background: rgba(255,255,255,0.12); }

/* Card */
.brand-catalog-card { display: flex; flex-direction: column; background: #2a2a2a; border-radius: 12px; overflow: hidden; text-decoration: none; color: inherit; transition: transform .2s ease, box-shadow .2s ease; border: 1px solid rgba(255,255,255,0.05); }
.brand-catalog-card:hover { transform: translateY(-4px); box-shadow: 0 15px 40px rgba(0,0,0,0.4); border-color: rgba(255,255,255,0.15); }
.brand-catalog-card-image { aspect-ratio: 4/3; overflow: hidden; background: #333; }
.brand-catalog-card-image img { width: 100%; height: 100%; object-fit: cover; transition: transform .3s ease; }
.brand-catalog-card:hover .brand-catalog-card-image img { transform: scale(1.05); }
.brand-catalog-card-placeholder { width: 100%; height: 100%; background: linear-gradient(135deg, #333, #222); }
.brand-catalog-card-body { padding: 1.25rem; flex: 1; display: flex; flex-direction: column; }
.brand-catalog-card-category { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--color-accent, #6da339); font-weight: 600; margin-bottom: 0.5rem; }
.brand-catalog-card-title { font-size: 1.05rem; font-weight: 700; color: #fff; margin-bottom: 0.5rem; line-height: 1.3; flex: 1; }
.brand-catalog-card-desc { font-size: 0.85rem; color: rgba(255,255,255,0.65); line-height: 1.5; margin-bottom: .75rem; }
.brand-catalog-card-footer { display: flex; align-items: center; justify-content: space-between; margin-top: auto; }
.brand-catalog-icon-btn { display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; border-radius: 50%; background: var(--color-accent, #6da339); color: #fff; flex-shrink: 0; transition: background .15s, transform .15s; }
.brand-catalog-card:hover .brand-catalog-icon-btn { filter: brightness(1.15); transform: scale(1.08); }
.brand-catalog-icon-btn svg { width: 16px; height: 16px; }

.brand-catalog-empty { padding: 4rem 0; text-align: center; color: rgba(255,255,255,0.6); }
.brand-catalog-empty p { margin-bottom: 1.5rem; }

@media (max-width: 640px) {
    .brand-catalog-hero-title { font-size: 1.85rem; }
    .brand-catalog-hero-subtitle { font-size: 0.95rem; }
    .brand-catalog-hero-overlay { padding: 4rem 0 3rem; }
}
</style>
@endpush

@include('partials.product-filter-script')

@endsection
