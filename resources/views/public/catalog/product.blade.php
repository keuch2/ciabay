@extends('layouts.public', [
    'metaTitle' => $product->name . ' | Catálogo ' . $brand->name,
    'metaDescription' => \Illuminate\Support\Str::limit(strip_tags($product->short_description ?? $product->description ?? ''), 160) ?: 'Producto del catálogo ' . $brand->name,
])

@php
    $resolveImg = function ($img) {
        if (!$img) return null;
        if (preg_match('#^(https?:)?//#', $img)) return $img;
        if (str_starts_with($img, 'assets/') || str_starts_with($img, 'storage/')) return asset($img);
        return asset('storage/' . $img);
    };
    $gallery = $product->gallery();
    $productUrl = url('catalogo/' . $brand->slug . '/' . $product->slug);

    // WhatsApp button composition
    $whatsappNumber = $brand->catalog_contact_whatsapp
        ?: \App\Models\Setting::get('whatsapp_number', '595981000000');
    $messageTemplate = $brand->catalog_contact_message
        ?: "Hola, me interesa este producto: {producto}\n{url}";
    $whatsappMsg = str_replace(
        ['{producto}', '{url}', '{marca}'],
        [$product->name, $productUrl, $brand->name],
        $messageTemplate
    );
    $whatsappHref = 'https://wa.me/' . preg_replace('/\s+/', '', (string) $whatsappNumber) . '?text=' . rawurlencode($whatsappMsg);
@endphp

@section('content')
<main class="main-content">
    <section class="catalog-product-detail">
        <div class="container">
            <nav class="catalog-breadcrumb">
                <a href="{{ url('catalogo/' . $brand->slug) }}">Catálogo {{ $brand->name }}</a>
                <span>›</span>
                @if($product->category)
                    <a href="{{ url('catalogo/' . $brand->slug . '?categoria=' . $product->category->slug) }}">{{ $product->category->name }}</a>
                    <span>›</span>
                @endif
                <span>{{ $product->name }}</span>
            </nav>

            <div class="catalog-product-grid" x-data="{ active: 0 }">
                <div class="catalog-gallery">
                    <div class="catalog-gallery-main">
                        @forelse($gallery as $i => $img)
                            <img src="{{ $resolveImg($img) }}"
                                 alt="{{ $product->name }}"
                                 class="catalog-gallery-image"
                                 @if($i !== 0) x-cloak @endif
                                 x-show="active === {{ $i }}"
                                 x-transition>
                        @empty
                            <div class="catalog-gallery-empty">Sin imagen</div>
                        @endforelse
                    </div>
                    @if(count($gallery) > 1)
                        <div class="catalog-gallery-thumbs">
                            @foreach($gallery as $i => $img)
                                <button type="button"
                                        class="catalog-gallery-thumb"
                                        :class="{ 'is-active': active === {{ $i }} }"
                                        @click="active = {{ $i }}"
                                        aria-label="Imagen {{ $i + 1 }}">
                                    <img src="{{ $resolveImg($img) }}" alt="">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="catalog-info">
                    @if($product->category)
                        <span class="catalog-category">{{ $product->category->name }}</span>
                    @endif
                    <h1 class="catalog-title">{{ $product->name }}</h1>

                    @if($product->short_description)
                        <p class="catalog-short">{{ $product->short_description }}</p>
                    @endif

                    @if($product->description)
                        <div class="catalog-description">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    @endif

                    @if($product->contact_enabled)
                        <a href="{{ $whatsappHref }}" target="_blank" rel="noopener noreferrer" class="catalog-contact-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Contactar a un vendedor
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @if($related->count())
        <section class="catalog-related">
            <div class="container">
                <h2 class="catalog-related-title">Otros productos de {{ $brand->name }}</h2>
                <div class="brand-catalog-grid">
                    @foreach($related as $rel)
                        @php $relSrc = $resolveImg($rel->image); @endphp
                        <a href="{{ url('catalogo/' . $brand->slug . '/' . $rel->slug) }}" class="brand-catalog-card">
                            <div class="brand-catalog-card-image">
                                @if($relSrc)
                                    <img src="{{ $relSrc }}" alt="{{ $rel->name }}">
                                @else
                                    <div class="brand-catalog-card-placeholder"></div>
                                @endif
                            </div>
                            <div class="brand-catalog-card-body">
                                @if($rel->category)
                                    <span class="brand-catalog-card-category">{{ $rel->category->name }}</span>
                                @endif
                                <h3 class="brand-catalog-card-title">{{ $rel->name }}</h3>
                                <span class="brand-catalog-card-cta">Ver detalle →</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</main>

@push('styles')
<style>
[x-cloak] { display: none !important; }
.main-content:has(.catalog-product-detail) { background: #1a1a1a; color: #fff; }
.catalog-product-detail { padding: 3rem 0 4rem; background: #1a1a1a; color: #fff; }

.catalog-breadcrumb { font-size: 0.85rem; color: rgba(255,255,255,0.6); margin-bottom: 1.5rem; display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center; }
.catalog-breadcrumb a { color: #fff; text-decoration: none; }
.catalog-breadcrumb a:hover { color: var(--color-accent, #6da339); }
.catalog-breadcrumb span:not(:last-child) { color: rgba(255,255,255,0.4); }

.catalog-product-grid { display: grid; grid-template-columns: 1.1fr 1fr; gap: 3rem; align-items: start; }

.catalog-gallery-main { background: #2a2a2a; border-radius: 16px; overflow: hidden; aspect-ratio: 1/1; position: relative; box-shadow: 0 4px 20px rgba(0,0,0,.5); }
.catalog-gallery-main .catalog-gallery-image { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
.catalog-gallery-empty { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.4); font-size: 1rem; }

.catalog-gallery-thumbs { display: grid; grid-template-columns: repeat(auto-fill, minmax(72px, 1fr)); gap: 0.5rem; margin-top: 0.75rem; }
.catalog-gallery-thumb { background: #2a2a2a; border: 2px solid transparent; border-radius: 8px; padding: 0; cursor: pointer; overflow: hidden; aspect-ratio: 1/1; transition: border-color .2s ease; }
.catalog-gallery-thumb:hover { border-color: rgba(255,255,255,0.2); }
.catalog-gallery-thumb.is-active { border-color: var(--color-accent, #6da339); }
.catalog-gallery-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }

.catalog-info { padding-top: 0.5rem; }
.catalog-category { display: inline-block; background: rgba(255,255,255,0.1); color: #fff; padding: 0.35rem 0.8rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 1rem; }
.catalog-title { font-size: 2rem; font-weight: 700; color: #fff; margin-bottom: 1rem; line-height: 1.15; }
.catalog-short { font-size: 1.05rem; color: rgba(255,255,255,0.9); margin-bottom: 1.25rem; font-weight: 500; }
.catalog-description { color: rgba(255,255,255,0.75); line-height: 1.7; margin-bottom: 2rem; font-size: 0.98rem; }

.catalog-contact-btn { display: inline-flex; align-items: center; gap: 0.75rem; background: #25D366; color: #fff; padding: 1rem 2rem; border-radius: 99px; font-weight: 700; font-size: 1.05rem; text-decoration: none; transition: transform .15s ease, box-shadow .15s ease; box-shadow: 0 4px 14px rgba(37, 211, 102, 0.35); }
.catalog-contact-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(37, 211, 102, 0.45); }

.catalog-related { padding: 3rem 0 5rem; background: #1a1a1a; border-top: 1px solid rgba(255,255,255,0.08); }
.catalog-related-title { font-size: 1.5rem; font-weight: 700; color: #fff; margin-bottom: 1.5rem; }

@media (max-width: 768px) {
    .catalog-product-grid { grid-template-columns: 1fr; gap: 1.5rem; }
    .catalog-title { font-size: 1.5rem; }
}
</style>
@endpush
@endsection
