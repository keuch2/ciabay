@php $slides = $data['slides'] ?? []; @endphp
<section class="hero-carousel">
    <div class="carousel-container">
        <div class="carousel-slides">
            @foreach($slides as $index => $slide)
                <div @class(['carousel-slide', 'active' => $index === 0])>
                    <picture>
                        @if(!empty($slide['mobile_image']))
                            <source media="(max-width: 768px)" srcset="{{ asset($slide['mobile_image']) }}">
                        @endif
                        <img src="{{ asset($slide['image'] ?? 'assets/images/hero_principal.jpg') }}" alt="{{ $slide['alt'] ?? $slide['title'] ?? 'Ciabay' }}">
                    </picture>
                    @if(!empty($slide['title']) || !empty($slide['subtitle']) || !empty($slide['button_text']))
                        <div class="carousel-content">
                            @if(!empty($slide['title']))
                                <h1>{{ $slide['title'] }}</h1>
                            @endif
                            @if(!empty($slide['subtitle']))
                                <p>{{ $slide['subtitle'] }}</p>
                            @endif
                            @if(!empty($slide['button_text']))
                                <a href="{{ $slide['button_url'] ?? '#' }}" class="btn-primary">{{ $slide['button_text'] }}</a>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        @if(count($slides) > 1)
            <button class="carousel-arrow carousel-arrow-prev" aria-label="Anterior">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
            <button class="carousel-arrow carousel-arrow-next" aria-label="Siguiente">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        @endif
    </div>

    <div class="arc-divider"></div>
</section>
