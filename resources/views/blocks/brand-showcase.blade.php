@php
    $resolveUrl = function ($raw) {
        if (!$raw || $raw === '#') return $raw ?: '#';
        if (preg_match('#^(https?:)?//#i', $raw) || str_starts_with($raw, 'mailto:') || str_starts_with($raw, 'tel:') || str_starts_with($raw, '#')) {
            return $raw;
        }
        return url(ltrim($raw, '/'));
    };
@endphp
<section class="impl-brands-section" @if(!empty($data['anchor_id'])) id="{{ $data['anchor_id'] }}" @endif>
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="impl-section-title impl-section-title--center">{{ $data['title'] }}</h2>
        @endif
        @if(!empty($data['subtitle']))
            <p class="impl-section-subtitle">{{ $data['subtitle'] }}</p>
        @endif
        <div class="impl-brands-grid">
            @foreach($data['brands'] ?? [] as $brand)
                <div class="impl-brand-card @if(!empty($brand['slug'])) impl-brand-card--{{ $brand['slug'] }} @endif">
                    <div class="impl-brand-header">
                        <div class="impl-brand-logo">
                            @if(!empty($brand['logo']))
                                <img src="{{ asset($brand['logo']) }}" alt="{{ $brand['name'] ?? '' }}" class="impl-brand-logo-img">
                            @endif
                        </div>
                        @if(!empty($brand['tagline']))
                            <span class="impl-brand-tagline">{{ $brand['tagline'] }}</span>
                        @endif
                    </div>
                    <div class="impl-brand-content">
                        @if(!empty($brand['description']))
                            <p class="impl-brand-desc">{{ $brand['description'] }}</p>
                        @endif
                        @if(!empty($brand['products']) && is_array($brand['products']))
                            <div class="impl-brand-products">
                                @foreach($brand['products'] as $product)
                                    <span class="impl-brand-product-tag">{{ $product }}</span>
                                @endforeach
                            </div>
                        @endif
                        @if(!empty($brand['cta_text']))
                            <a href="{{ $resolveUrl($brand['cta_url'] ?? '#') }}" class="impl-btn impl-btn--brand">{{ $brand['cta_text'] }}</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
