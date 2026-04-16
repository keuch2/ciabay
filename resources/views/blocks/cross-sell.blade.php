@php
    $resolveUrl = function ($raw) {
        if (!$raw || $raw === '#') return $raw ?: '#';
        if (preg_match('#^(https?:)?//#i', $raw) || str_starts_with($raw, 'mailto:') || str_starts_with($raw, 'tel:') || str_starts_with($raw, '#')) {
            return $raw;
        }
        return url(ltrim($raw, '/'));
    };
@endphp
<section class="insumos-crosssell">
    <div class="container">
        <div class="insumos-crosssell-content">
            @if(!empty($data['icon_svg']))
                <div class="insumos-crosssell-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $data['icon_stroke'] ?? '1.5' }}" stroke-linecap="round" stroke-linejoin="round">{!! $data['icon_svg'] !!}</svg>
                </div>
            @endif
            <div class="insumos-crosssell-text">
                @if(!empty($data['title']))
                    <h3 class="insumos-crosssell-title">{{ $data['title'] }}</h3>
                @endif
                @if(!empty($data['text']))
                    <p class="insumos-crosssell-desc">{{ $data['text'] }}</p>
                @endif
            </div>
            @if(!empty($data['cta_text']))
                <a href="{{ $resolveUrl($data['cta_url'] ?? '#') }}" class="insumos-btn insumos-btn--secondary">{{ $data['cta_text'] }}</a>
            @endif
        </div>
    </div>
</section>
