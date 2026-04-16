@php
    $variant = $data['variant'] ?? 'default';
@endphp

@if($variant === 'insumos-valor')
    <section class="insumos-valor" @if(!empty($data['anchor_id'])) id="{{ $data['anchor_id'] }}" @endif>
        <div class="container">
            <div class="insumos-valor-content">
                @if(!empty($data['title']))
                    <h2 class="insumos-section-title">{{ $data['title'] }}</h2>
                @endif
                @if(!empty($data['subtitle']))
                    <p class="insumos-valor-text">{!! $data['subtitle'] !!}</p>
                @endif
                <div class="insumos-valor-grid">
                    @foreach($data['features'] ?? [] as $f)
                        <div class="insumos-valor-card">
                            @if(!empty($f['icon_svg']))
                                <div class="insumos-valor-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $f['icon_stroke'] ?? '1.5' }}" stroke-linecap="round" stroke-linejoin="round">{!! $f['icon_svg'] !!}</svg>
                                </div>
                            @endif
                            @if(!empty($f['title']))
                                <h3 class="insumos-valor-card-title">{{ $f['title'] }}</h3>
                            @endif
                            @if(!empty($f['text']))
                                <p class="insumos-valor-card-text">{{ $f['text'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@else
    <section class="features-section" style="padding: 4rem 0; background: {{ $data['background'] ?? '#fff' }};">
        <div class="container">
            @if(!empty($data['title']))
                <h2 class="section-title">{{ $data['title'] }}</h2>
            @endif
            @if(!empty($data['subtitle']))
                <p class="section-subtitle">{{ $data['subtitle'] }}</p>
            @endif
            <div class="features-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 2rem; margin-top: 2rem;">
                @foreach($data['features'] ?? [] as $feature)
                    <div class="feature-card" style="padding: 1.5rem; border-radius: 12px; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,.06);">
                        @if(!empty($feature['icon']))
                            <div style="font-size: 2rem; margin-bottom: 1rem; color: var(--color-primary);">{!! $feature['icon'] !!}</div>
                        @endif
                        @if(!empty($feature['image']))
                            <img src="{{ asset($feature['image']) }}" alt="{{ $feature['title'] ?? '' }}" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 1rem;">
                        @endif
                        @if(!empty($feature['title']))
                            <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $feature['title'] }}</h3>
                        @endif
                        @if(!empty($feature['text']))
                            <p style="font-size: 0.9rem; color: #666; line-height: 1.6;">{{ $feature['text'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
