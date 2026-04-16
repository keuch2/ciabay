@php
    $variant = $data['variant'] ?? 'default';
    $prefix = match($variant) {
        'impl' => 'impl',
        'insumos' => 'insumos',
        'mvv' => 'mvv',
        'historia' => 'historia',
        default => null,
    };
    // Variants with dedicated button CSS in styles.css
    $hasNativeButtonStyles = in_array($variant, ['impl', 'insumos'], true);
    $buttons = $data['buttons'] ?? [];
    if (empty($buttons) && !empty($data['button_text'])) {
        $buttons = [[
            'text' => $data['button_text'],
            'url' => $data['button_url'] ?? '#',
            'style' => 'primary',
            'target' => $data['button_target'] ?? '_self',
        ]];
    }
    $resolveUrl = function ($raw) {
        if (!$raw || $raw === '#') return $raw ?: '#';
        if (preg_match('#^(https?:)?//#i', $raw) || str_starts_with($raw, 'mailto:') || str_starts_with($raw, 'tel:') || str_starts_with($raw, '#')) {
            return $raw;
        }
        return url(ltrim($raw, '/'));
    };
    // Inline styles used as a fallback for variants without dedicated button CSS.
    $inlineBtnStyle = [
        'primary' => 'display:inline-block;padding:1rem 2.5rem;background-color:var(--color-accent,#6da339);color:#fff;font-size:1.05rem;font-weight:600;border-radius:50px;text-decoration:none;letter-spacing:1px;text-transform:uppercase;box-shadow:0 4px 20px rgba(0,0,0,0.25);transition:transform .15s ease, box-shadow .15s ease;',
        'outline-white' => 'display:inline-block;padding:1rem 2.5rem;background:transparent;color:#fff;font-size:1.05rem;font-weight:600;border:2px solid #fff;border-radius:50px;text-decoration:none;letter-spacing:1px;text-transform:uppercase;transition:all .15s ease;',
        'whatsapp' => 'display:inline-flex;align-items:center;gap:.5rem;padding:1rem 2.5rem;background-color:#25D366;color:#fff;font-size:1.05rem;font-weight:600;border-radius:50px;text-decoration:none;letter-spacing:1px;text-transform:uppercase;box-shadow:0 4px 20px rgba(37,211,102,0.35);transition:transform .15s ease;',
    ];
    $image = $data['image'] ?? '';
    $imageSrc = $image ? asset($image) : asset('assets/images/hero_principal.jpg');
@endphp

@if($prefix)
    <section class="{{ $prefix }}-hero">
        <div class="{{ $prefix }}-hero-bg">
            <img src="{{ $imageSrc }}" alt="{{ $data['title'] ?? '' }}">
        </div>
        @if(!empty($data['title']) || !empty($data['subtitle']) || count($buttons))
            <div class="{{ $prefix }}-hero-overlay">
                <div class="container">
                    <div class="{{ $prefix }}-hero-content">
                        @if(!empty($data['title']))
                            <h1 class="{{ $prefix }}-hero-title">{{ $data['title'] }}</h1>
                        @endif
                        @if(!empty($data['subtitle']))
                            <p class="{{ $prefix }}-hero-subtitle">{{ $data['subtitle'] }}</p>
                        @endif
                        @if(count($buttons))
                            <div @if($hasNativeButtonStyles && count($buttons) > 1) class="{{ $prefix }}-hero-buttons" @else style="margin-top:1.5rem;display:flex;flex-wrap:wrap;gap:1rem;justify-content:center;" @endif>
                                @foreach($buttons as $btn)
                                    @php
                                        $href = $resolveUrl($btn['url'] ?? '#');
                                        $style = $btn['style'] ?? 'primary';
                                        $target = $btn['target'] ?? '_self';
                                        if ($hasNativeButtonStyles) {
                                            $class = count($buttons) === 1
                                                ? $prefix . '-hero-btn'
                                                : $prefix . '-btn ' . $prefix . '-btn--' . $style . ' ' . $prefix . '-btn--large';
                                            $inlineStyle = null;
                                        } else {
                                            $class = null;
                                            $inlineStyle = $inlineBtnStyle[$style] ?? $inlineBtnStyle['primary'];
                                        }
                                    @endphp
                                    <a href="{{ $href }}"
                                       @if($class) class="{{ $class }}" @endif
                                       @if($inlineStyle) style="{{ $inlineStyle }}" @endif
                                       @if($target === '_blank') target="_blank" rel="noopener noreferrer" @endif>{{ $btn['text'] ?? '' }}</a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </section>
@else
    {{-- default variant matches static site's .page-hero with image inside .page-hero-image --}}
    <section class="page-hero">
        <div class="page-hero-image">
            <img src="{{ $imageSrc }}" alt="{{ $data['title'] ?? '' }}">
            <div class="page-hero-overlay">
                <div class="container">
                    @if(!empty($data['title']))
                        <h1 class="page-hero-title">{{ $data['title'] }}</h1>
                    @endif
                    @if(!empty($data['subtitle']))
                        <p>{{ $data['subtitle'] }}</p>
                    @endif
                    @if(count($buttons))
                        <div style="margin-top:1.5rem;display:flex;flex-wrap:wrap;gap:1rem;justify-content:center;">
                            @foreach($buttons as $btn)
                                @php
                                    $href = $resolveUrl($btn['url'] ?? '#');
                                    $style = $btn['style'] ?? 'primary';
                                    $target = $btn['target'] ?? '_self';
                                    $inlineStyle = $inlineBtnStyle[$style] ?? $inlineBtnStyle['primary'];
                                @endphp
                                <a href="{{ $href }}" style="{{ $inlineStyle }}"
                                   @if($target === '_blank') target="_blank" rel="noopener noreferrer" @endif>{{ $btn['text'] ?? '' }}</a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif
