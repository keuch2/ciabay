@php
    $resolveImg = function($img) {
        if (!$img) return null;
        if (preg_match('#^(https?:)?//#', $img)) return $img;
        if (str_starts_with($img, 'assets/') || str_starts_with($img, 'storage/')) return asset($img);
        return asset('storage/' . $img);
    };
    $image = $data['image'] ?? 'assets/images/redcaseih/hero.jpg';
    $logo = $data['logo'] ?? 'assets/images/redcase-blanco.png';
@endphp
<section class="redcase-hero">
    <div class="redcase-hero-bg">
        <img src="{{ $resolveImg($image) }}" alt="{{ $data['title'] ?? 'Red Case IH Store' }}">
    </div>
    <div class="redcase-hero-overlay">
        <div class="container">
            <div class="redcase-hero-content">
                @if($logo)
                    <img src="{{ $resolveImg($logo) }}" alt="{{ $data['title'] ?? 'Red Case IH' }}" class="redcase-hero-logo">
                @endif
                @if(!empty($data['title']))
                    <h1 class="redcase-hero-title">{{ $data['title'] }}</h1>
                @endif
                @if(!empty($data['subtitle']))
                    <p class="redcase-hero-subtitle">{{ $data['subtitle'] }}</p>
                @endif
            </div>
        </div>
    </div>
</section>
