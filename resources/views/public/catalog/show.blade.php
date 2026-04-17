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
    <section class="brand-catalog-section">
        <div class="container">
            @if($categories->count())
                <nav class="brand-catalog-categories">
                    <a href="{{ url('catalogo/' . $brand->slug) }}"
                       class="brand-catalog-pill {{ !$selectedCategory ? 'is-active' : '' }}">
                        Todas
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ url('catalogo/' . $brand->slug . '?categoria=' . $cat->slug) }}"
                           class="brand-catalog-pill {{ $selectedCategory?->id === $cat->id ? 'is-active' : '' }}">
                            {{ $cat->name }}
                            <span class="brand-catalog-pill-count">{{ $cat->products_count }}</span>
                        </a>
                    @endforeach
                </nav>
            @endif

            @if($selectedCategory && $selectedCategory->description)
                <p class="brand-catalog-category-description">{{ $selectedCategory->description }}</p>
            @endif

            @if($products->count())
                <div class="brand-catalog-grid" style="grid-template-columns: repeat({{ $columns }}, minmax(0, 1fr));">
                    @foreach($products as $product)
                        @php $src = $resolveImg($product->image); @endphp
                        <a href="{{ url('catalogo/' . $brand->slug . '/' . $product->slug) }}" class="brand-catalog-card">
                            <div class="brand-catalog-card-image">
                                @if($src)
                                    <img src="{{ $src }}" alt="{{ $product->name }}">
                                @else
                                    <div class="brand-catalog-card-placeholder"></div>
                                @endif
                            </div>
                            <div class="brand-catalog-card-body">
                                @if($product->category)
                                    <span class="brand-catalog-card-category">{{ $product->category->name }}</span>
                                @endif
                                <h3 class="brand-catalog-card-title">{{ $product->name }}</h3>
                                @if($product->short_description)
                                    <p class="brand-catalog-card-desc">{{ $product->short_description }}</p>
                                @endif
                                <span class="brand-catalog-card-cta">Ver detalle →</span>
                            </div>
                        </a>
                    @endforeach
                </div>

                @if($products->hasPages())
                    <div class="brand-catalog-pagination">
                        {{ $products->withQueryString()->links() }}
                    </div>
                @endif
            @else
                <div class="brand-catalog-empty">
                    <p>{{ $selectedCategory ? 'No hay productos en esta categoría todavía.' : 'Pronto vamos a sumar productos a este catálogo.' }}</p>
                    @if($selectedCategory)
                        <a href="{{ url('catalogo/' . $brand->slug) }}" class="brand-catalog-pill">Ver todo el catálogo</a>
                    @endif
                </div>
            @endif
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
.brand-catalog-categories { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 2rem; }
.brand-catalog-pill { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1.2rem; background: rgba(255,255,255,0.08); color: #fff; text-decoration: none; border-radius: 99px; font-size: 0.9rem; font-weight: 500; border: 1px solid rgba(255,255,255,0.1); transition: all .2s ease; }
.brand-catalog-pill:hover { background: rgba(255,255,255,0.15); border-color: rgba(255,255,255,0.3); }
.brand-catalog-pill.is-active { background: var(--color-accent, #6da339); border-color: var(--color-accent, #6da339); color: #fff; }
.brand-catalog-pill-count { font-size: 0.75rem; opacity: 0.7; background: rgba(0,0,0,0.2); padding: 0.1rem 0.5rem; border-radius: 99px; }

.brand-catalog-category-description { color: rgba(255,255,255,0.7); font-size: 0.95rem; margin-bottom: 2rem; max-width: 700px; }

.brand-catalog-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.5rem; }
@media (max-width: 900px) { .brand-catalog-grid { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; } }
@media (max-width: 560px) { .brand-catalog-grid { grid-template-columns: 1fr !important; } }
.brand-catalog-pagination { margin-top: 3rem; display: flex; justify-content: center; }
.brand-catalog-pagination nav { color: rgba(255,255,255,0.9); }
.brand-catalog-pagination nav a, .brand-catalog-pagination nav span { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: rgba(255,255,255,0.85); }
.brand-catalog-pagination nav a:hover { background: rgba(255,255,255,0.12); }
.brand-catalog-card { display: flex; flex-direction: column; background: #2a2a2a; border-radius: 12px; overflow: hidden; text-decoration: none; color: inherit; transition: transform .2s ease, box-shadow .2s ease; border: 1px solid rgba(255,255,255,0.05); }
.brand-catalog-card:hover { transform: translateY(-4px); box-shadow: 0 15px 40px rgba(0,0,0,0.4); border-color: rgba(255,255,255,0.15); }
.brand-catalog-card-image { aspect-ratio: 4/3; overflow: hidden; background: #333; }
.brand-catalog-card-image img { width: 100%; height: 100%; object-fit: cover; transition: transform .3s ease; }
.brand-catalog-card:hover .brand-catalog-card-image img { transform: scale(1.05); }
.brand-catalog-card-placeholder { width: 100%; height: 100%; background: linear-gradient(135deg, #333, #222); }
.brand-catalog-card-body { padding: 1.25rem; flex: 1; display: flex; flex-direction: column; }
.brand-catalog-card-category { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--color-accent, #6da339); font-weight: 600; margin-bottom: 0.5rem; }
.brand-catalog-card-title { font-size: 1.05rem; font-weight: 700; color: #fff; margin-bottom: 0.5rem; line-height: 1.3; }
.brand-catalog-card-desc { font-size: 0.85rem; color: rgba(255,255,255,0.65); line-height: 1.5; margin-bottom: 1rem; flex: 1; }
.brand-catalog-card-cta { font-size: 0.85rem; color: var(--color-accent, #6da339); font-weight: 600; margin-top: auto; }

.brand-catalog-empty { padding: 4rem 0; text-align: center; color: rgba(255,255,255,0.6); }
.brand-catalog-empty p { margin-bottom: 1.5rem; }

@media (max-width: 640px) {
    .brand-catalog-hero-title { font-size: 1.85rem; }
    .brand-catalog-hero-subtitle { font-size: 0.95rem; }
    .brand-catalog-hero-overlay { padding: 4rem 0 3rem; }
}
</style>
@endpush
@endsection
