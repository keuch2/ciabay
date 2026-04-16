@php
    $variant = $data['variant'] ?? 'specialized';
    $resolveUrl = function ($raw) {
        if (!$raw || $raw === '#') return $raw ?: '#';
        if (preg_match('#^(https?:)?//#i', $raw) || str_starts_with($raw, 'mailto:') || str_starts_with($raw, 'tel:') || str_starts_with($raw, '#')) {
            return $raw;
        }
        return url(ltrim($raw, '/'));
    };
@endphp

@if($variant === 'marcas')
    <section class="insumos-marcas" @if(!empty($data['anchor_id'])) id="{{ $data['anchor_id'] }}" @endif>
        <div class="container">
            @if(!empty($data['title']))
                <h2 class="insumos-section-title insumos-section-title--center">{{ $data['title'] }}</h2>
            @endif
            @if(!empty($data['subtitle']))
                <p class="insumos-section-subtitle">{{ $data['subtitle'] }}</p>
            @endif
            <div class="insumos-marcas-grid">
                @foreach($data['items'] ?? [] as $item)
                    @php $href = $resolveUrl($item['cta_url'] ?? '#'); @endphp
                    <a href="{{ $href }}" class="insumos-marca-card">
                        <div class="insumos-marca-logo">
                            @if(!empty($item['logo']))
                                <img src="{{ asset($item['logo']) }}" alt="{{ $item['name'] ?? '' }}">
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@else
    <section class="impl-specialized" @if(!empty($data['anchor_id'])) id="{{ $data['anchor_id'] }}" @endif>
        <div class="container">
            @if(!empty($data['title']))
                <h3 class="impl-section-title impl-section-title--center">{{ $data['title'] }}</h3>
            @endif
            @if(!empty($data['subtitle']))
                <p class="impl-section-subtitle">{{ $data['subtitle'] }}</p>
            @endif
            <div class="impl-specialized-grid">
                @foreach($data['items'] ?? [] as $item)
                    <div class="impl-specialized-card">
                        <div class="impl-specialized-logo">
                            @if(!empty($item['logo']))
                                <img src="{{ asset($item['logo']) }}" alt="{{ $item['name'] ?? '' }}">
                            @endif
                        </div>
                        @if(!empty($item['description']))
                            <p class="impl-specialized-desc">{{ $item['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
