<section class="testimonials-section" style="padding: 4rem 0; background: {{ $data['background'] ?? '#f8f9fa' }};">
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="section-title">{{ $data['title'] }}</h2>
        @endif
        <div class="testimonials-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem; margin-top: 2rem;">
            @foreach($data['testimonials'] ?? [] as $testimonial)
                <div class="testimonial-card" style="background: #fff; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,.06);">
                    @if(!empty($testimonial['text']))
                        <p style="font-style: italic; color: #555; line-height: 1.6; margin-bottom: 1rem;">"{{ $testimonial['text'] }}"</p>
                    @endif
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        @if(!empty($testimonial['avatar']))
                            <img src="{{ asset($testimonial['avatar']) }}" alt="{{ $testimonial['name'] ?? '' }}" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover;">
                        @endif
                        <div>
                            @if(!empty($testimonial['name']))
                                <p style="font-weight: 700; font-size: 0.95rem;">{{ $testimonial['name'] }}</p>
                            @endif
                            @if(!empty($testimonial['role']))
                                <p style="font-size: 0.8rem; color: #999;">{{ $testimonial['role'] }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
