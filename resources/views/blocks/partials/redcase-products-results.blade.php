@php
    // Partial for the tienda products grid + pagination.
    // Expects: $products (Collection or Paginator), $paginated (?LengthAwarePaginator), $showPrice (bool), $resolveImg (callable)
@endphp
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
                @if($product->category)
                    <span class="redcase-product-category">{{ $product->category->name }}</span>
                @endif
                <h3 class="redcase-product-name">{{ $product->name }}</h3>
                <div class="redcase-product-footer">
                    @if($showPrice && $product->price)
                        <div class="redcase-product-price">Gs. {{ number_format((int) $product->price, 0, ',', '.') }}</div>
                    @else
                        <span></span>
                    @endif
                    <span class="redcase-icon-btn" aria-label="Ver detalles">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
                    </span>
                </div>
            </div>
        </a>
    @empty
        <p style="grid-column: 1 / -1; text-align:center; color:#bbb; padding:3rem 0;">No hay productos en las categorías seleccionadas.</p>
    @endforelse
</div>
@if($paginated && $paginated->hasPages())
    <div class="redcase-pagination">
        {{ $paginated->links() }}
    </div>
@endif
