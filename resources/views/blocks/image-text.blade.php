@php
    $variant = $data['variant'] ?? 'default';
    $reversed = !empty($data['reversed']);
    $resolveUrl = function ($raw) {
        if (!$raw || $raw === '#') return $raw ?: '#';
        if (preg_match('#^(https?:)?//#i', $raw) || str_starts_with($raw, 'mailto:') || str_starts_with($raw, 'tel:') || str_starts_with($raw, '#')) {
            return $raw;
        }
        return url(ltrim($raw, '/'));
    };
@endphp

@if($variant === 'impl-repuestos')
    <section class="impl-repuestos" @if(!empty($data['anchor_id'])) id="{{ $data['anchor_id'] }}" @endif>
        <div class="container">
            <div class="impl-repuestos-grid">
                <div class="impl-repuestos-content">
                    @if(!empty($data['tag']))
                        <span class="impl-repuestos-tag">{{ $data['tag'] }}</span>
                    @endif
                    @if(!empty($data['title']))
                        <h2 class="impl-repuestos-title">{{ $data['title'] }}</h2>
                    @endif
                    @if(!empty($data['text']))
                        <p class="impl-repuestos-text">{!! $data['text'] !!}</p>
                    @endif
                    @if(!empty($data['list']) && is_array($data['list']))
                        <ul class="impl-repuestos-list">
                            @foreach($data['list'] as $li)
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    {{ $li }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @if(!empty($data['button_text']))
                        <a href="{{ $resolveUrl($data['button_url'] ?? '#') }}" class="impl-btn impl-btn--primary">{{ $data['button_text'] }}</a>
                    @endif
                </div>
                <div class="impl-repuestos-image">
                    @if(!empty($data['image']))
                        <img src="{{ asset($data['image']) }}" alt="{{ $data['title'] ?? '' }}">
                    @endif
                </div>
            </div>
        </div>
    </section>
@else
    <section class="image-text-section" style="padding: 4rem 0;">
        <div class="container">
            <div class="image-text-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center;">
                <div class="{{ $reversed ? 'order-2' : '' }}">
                    @if(!empty($data['image']))
                        <img src="{{ asset($data['image']) }}" alt="{{ $data['title'] ?? '' }}" style="width: 100%; border-radius: 12px;">
                    @endif
                </div>
                <div class="{{ $reversed ? 'order-1' : '' }}">
                    @if(!empty($data['title']))
                        <h2 class="section-title">{{ $data['title'] }}</h2>
                    @endif
                    @if(!empty($data['text']))
                        <div class="intro-text">{!! $data['text'] !!}</div>
                    @endif
                    @if(!empty($data['button_text']))
                        <a href="{{ $resolveUrl($data['button_url'] ?? '#') }}" class="btn-primary" style="margin-top: 1.5rem; display: inline-block;">{{ $data['button_text'] }}</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif
