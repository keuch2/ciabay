@php
    // Partial for the brand catalog products grid + pagination.
    // Expects: $brand, $products (paginator), $columns (int), $resolveImg (callable)
@endphp
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
                    <div class="brand-catalog-card-footer">
                        <span></span>
                        <span class="brand-catalog-icon-btn" aria-label="Ver detalle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
                        </span>
                    </div>
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
        <p>No hay productos en las categorías seleccionadas.</p>
    </div>
@endif
