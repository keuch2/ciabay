<section class="unidades-negocio-section">
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="section-title">{{ $data['title'] }}</h2>
        @endif
        @if(!empty($data['subtitle']))
            <p class="section-subtitle">{{ $data['subtitle'] }}</p>
        @endif
        <div class="unidades-grid">
            @foreach($data['items'] ?? [] as $item)
                @php
                    $raw = $item['url'] ?? '';
                    $hasLink = $raw !== '';
                    if ($hasLink) {
                        if (preg_match('#^(https?:)?//#i', $raw) || str_starts_with($raw, 'mailto:') || str_starts_with($raw, 'tel:') || str_starts_with($raw, '#')) {
                            $href = $raw;
                        } else {
                            $href = url(ltrim($raw, '/'));
                        }
                    }
                @endphp
                @if($hasLink)
                    <a class="unidad-card" href="{{ $href }}">
                @else
                    <div class="unidad-card">
                @endif
                    @if(!empty($item['image']))
                        <div class="unidad-image">
                            <img src="{{ asset($item['image']) }}" alt="{{ $item['alt'] ?? $item['title'] ?? '' }}">
                        </div>
                    @endif
                    <h3 class="unidad-title">{{ $item['title'] ?? '' }}</h3>
                    @if(!empty($item['description']))
                        <p class="unidad-description">{{ $item['description'] }}</p>
                    @endif
                </{{ $hasLink ? 'a' : 'div' }}>
            @endforeach
        </div>
    </div>
</section>
