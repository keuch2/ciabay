@php
    $height = $data['height'] ?? '600';
    $url = $data['embed_url'] ?? '';
@endphp
<section class="map-section">
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="map-section-title">{{ $data['title'] }}</h2>
        @endif
        @if(!empty($data['subtitle']))
            <p class="section-subtitle">{{ $data['subtitle'] }}</p>
        @endif
        @if($url)
            <div class="map-container">
                <iframe src="{{ $url }}" width="100%" height="{{ $height }}" style="border:0; border-radius: 12px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        @endif
    </div>
</section>
