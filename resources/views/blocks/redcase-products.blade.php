@php
    $source = $data['source'] ?? 'all';
    $isStaff = auth()->check() && auth()->user()->isStaff();
    $query = \App\Models\Product::with('category')->orderBy('sort_order');
    if (! $isStaff) $query->active();
    if ($source === 'category' && !empty($data['category_id'])) {
        $query->where('product_category_id', $data['category_id']);
    } elseif ($source === 'manual' && !empty($data['product_ids']) && is_array($data['product_ids'])) {
        $query->whereIn('id', $data['product_ids']);
    }
    $products = $query->get();

    $resolveImg = function($img) {
        if (!$img) return null;
        if (preg_match('#^(https?:)?//#', $img)) return $img;
        if (str_starts_with($img, 'assets/') || str_starts_with($img, 'storage/')) return asset($img);
        return asset('storage/' . $img);
    };
@endphp
<section class="redcase-products" style="background:#1a1a1a;">
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="redcase-section-title">{{ $data['title'] }}</h2>
        @endif
        @if(!empty($data['subtitle']))
            <p class="redcase-section-subtitle">{{ $data['subtitle'] }}</p>
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
                        <span class="redcase-product-btn">Ver Detalles</span>
                    </div>
                </a>
            @empty
                <p style="grid-column: 1 / -1; text-align:center; color:#666; padding:3rem 0;">No hay productos disponibles.</p>
            @endforelse
        </div>
    </div>
</section>
