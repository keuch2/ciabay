@php
    $alt = !empty($data['alt']);
    $reversed = !empty($data['reversed']);
    $tagColor = $data['tag_color'] ?? 'green';
    $ctaColor = $data['cta_color'] ?? $tagColor;
    $resolveUrl = function ($raw) {
        if (!$raw || $raw === '#') return $raw ?: '#';
        if (preg_match('#^(https?:)?//#i', $raw) || str_starts_with($raw, 'mailto:') || str_starts_with($raw, 'tel:') || str_starts_with($raw, '#')) {
            return $raw;
        }
        return url(ltrim($raw, '/'));
    };
@endphp
<section class="insumos-category{{ $alt ? ' insumos-category--alt' : '' }}" @if(!empty($data['anchor_id'])) id="{{ $data['anchor_id'] }}" @endif>
    <div class="container">
        <div class="insumos-category-grid{{ $reversed ? ' insumos-category-grid--reverse' : '' }}">
            <div class="insumos-category-content">
                @if(!empty($data['tag']))
                    <span class="insumos-category-tag insumos-category-tag--{{ $tagColor }}">{{ $data['tag'] }}</span>
                @endif
                @if(!empty($data['title']))
                    <h3 class="insumos-category-title">{{ $data['title'] }}</h3>
                @endif
                @if(!empty($data['text']))
                    <p class="insumos-category-text">{{ $data['text'] }}</p>
                @endif
                @if(!empty($data['chips']) && is_array($data['chips']))
                    <div class="insumos-category-tags">
                        @foreach($data['chips'] as $chip)
                            <span class="insumos-cultivo-tag">{{ $chip }}</span>
                        @endforeach
                    </div>
                @endif
                @if(!empty($data['brands']) && is_array($data['brands']))
                    <div class="insumos-category-brands">
                        <span class="insumos-brand-label">{{ $data['brands_label'] ?? 'Marcas destacadas:' }}</span>
                        <div class="insumos-brand-names">
                            @foreach($data['brands'] as $brand)
                                <span>{{ $brand }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if(!empty($data['cta_text']))
                    <a href="{{ $resolveUrl($data['cta_url'] ?? '#') }}" class="insumos-btn insumos-btn--{{ $ctaColor }}">{{ $data['cta_text'] }}</a>
                @endif
            </div>
            <div class="insumos-category-image">
                @if(!empty($data['image']))
                    <img src="{{ asset($data['image']) }}" alt="{{ $data['title'] ?? '' }}">
                @endif
            </div>
        </div>
    </div>
</section>
