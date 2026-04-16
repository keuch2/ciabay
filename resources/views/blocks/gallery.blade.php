<section class="gallery-section" style="padding: 4rem 0;">
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="section-title">{{ $data['title'] }}</h2>
        @endif
        <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem; margin-top: 2rem;">
            @foreach($data['images'] ?? [] as $image)
                <div class="gallery-item" style="border-radius: 8px; overflow: hidden;">
                    <img src="{{ asset($image['src'] ?? $image) }}" alt="{{ $image['alt'] ?? '' }}" style="width: 100%; height: 200px; object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                </div>
            @endforeach
        </div>
    </div>
</section>
