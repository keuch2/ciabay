<section class="brands-section">
    <div class="container">
        @if(!empty($data['title']))
            <h3 class="brands-title">{{ $data['title'] }}</h3>
        @endif
        <div class="brands-carousel">
            <button class="brands-carousel-arrow brands-carousel-prev" aria-label="Anterior">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
            <div class="brands-carousel-track-container">
                <div class="brands-carousel-track">
                    @foreach($data['brands'] ?? [] as $brand)
                        <div class="brands-carousel-slide">
                            @if(!empty($brand['logo']))
                                <img src="{{ asset($brand['logo']) }}" alt="{{ $brand['name'] ?? '' }}">
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <button class="brands-carousel-arrow brands-carousel-next" aria-label="Siguiente">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        </div>
    </div>
</section>
