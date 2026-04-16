@php
    $resolveUrl = function ($raw) {
        if (!$raw || $raw === '#') return $raw ?: '#';
        if (preg_match('#^(https?:)?//#i', $raw) || str_starts_with($raw, 'mailto:') || str_starts_with($raw, 'tel:') || str_starts_with($raw, '#')) {
            return $raw;
        }
        return url(ltrim($raw, '/'));
    };
@endphp
<section class="impl-categories" @if(!empty($data['anchor_id'])) id="{{ $data['anchor_id'] }}" @endif>
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="impl-section-title impl-section-title--center">{{ $data['title'] }}</h2>
        @endif
        @if(!empty($data['subtitle']))
            <p class="impl-section-subtitle">{{ $data['subtitle'] }}</p>
        @endif
        <div class="impl-categories-grid">
            @foreach($data['items'] ?? [] as $item)
                <div class="impl-category-card">
                    @if(!empty($item['icon_svg']))
                        <div class="impl-category-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $item['icon_stroke'] ?? '1.5' }}" stroke-linecap="round" stroke-linejoin="round">{!! $item['icon_svg'] !!}</svg>
                        </div>
                    @endif
                    @if(!empty($item['title']))
                        <h3 class="impl-category-title">{{ $item['title'] }}</h3>
                    @endif
                    @if(!empty($item['list']) && is_array($item['list']))
                        <ul class="impl-category-list">
                            @foreach($item['list'] as $li)
                                <li>{{ $li }}</li>
                            @endforeach
                        </ul>
                    @endif
                    @if(!empty($item['cta_text']))
                        <a href="{{ $resolveUrl($item['cta_url'] ?? '#') }}" class="impl-btn impl-btn--category">{{ $item['cta_text'] }}</a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
