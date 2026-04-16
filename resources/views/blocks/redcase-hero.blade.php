@php
    $image = $data['image'] ?? 'assets/images/redcaseih/hero.jpg';
    $logo = $data['logo'] ?? 'assets/images/redcase-blanco.png';
@endphp
<section class="redcase-hero">
    <div class="redcase-hero-bg">
        <img src="{{ asset($image) }}" alt="{{ $data['title'] ?? 'Red Case IH Store' }}">
    </div>
    <div class="redcase-hero-overlay">
        <div class="container">
            <div class="redcase-hero-content">
                @if($logo)
                    <img src="{{ asset($logo) }}" alt="{{ $data['title'] ?? 'Red Case IH' }}" class="redcase-hero-logo">
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
