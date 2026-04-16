@php
    $variant = $data['variant'] ?? 'default';
    $sectionClass = match($variant) {
        'mvv-pillars' => 'mvv-pillars',
        'direccionadores' => 'historia-direccionadores',
        default => 'pillars-section',
    };
    $gridClass = match($variant) {
        'mvv-pillars' => 'mvv-pillars-grid',
        'direccionadores' => 'direccionadores-grid',
        default => 'pillars-grid',
    };
    $cardClass = match($variant) {
        'mvv-pillars' => 'mvv-pillar-card',
        'direccionadores' => 'direccionador-card',
        default => 'pillar-card',
    };
    $titleClass = match($variant) {
        'mvv-pillars' => 'mvv-pillar-title',
        'direccionadores' => 'direccionador-title',
        default => 'pillar-title',
    };
    $textClass = match($variant) {
        'mvv-pillars' => 'mvv-pillar-text',
        'direccionadores' => 'direccionador-text',
        default => 'pillar-text',
    };
    $iconClass = match($variant) {
        'mvv-pillars' => 'mvv-pillar-icon',
        'direccionadores' => 'direccionador-icon',
        default => 'pillar-icon',
    };
    $sectionTitleClass = $variant === 'direccionadores' ? 'historia-section-title historia-section-title--center' : 'section-title';
@endphp
<section class="{{ $sectionClass }}" @if($variant === 'default') style="padding: 4rem 0;" @endif>
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="{{ $sectionTitleClass }}">{{ $data['title'] }}</h2>
        @endif
        <div class="{{ $gridClass }}" @if($variant === 'default') style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem; margin-top: 2rem;" @endif>
            @foreach($data['pillars'] ?? [] as $i => $pillar)
                @php
                    $pillarClass = $cardClass;
                    if ($variant === 'mvv-pillars' && !empty($pillar['modifier'])) {
                        $pillarClass .= ' mvv-pillar-card--' . $pillar['modifier'];
                    }
                @endphp
                <div class="{{ $pillarClass }}" @if($variant === 'default') style="background: {{ $pillar['background'] ?? '#fff' }}; border-radius: 12px; padding: 2rem; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,.08);" @endif>
                    @if(!empty($pillar['icon_svg']))
                        <div class="{{ $iconClass }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $pillar['icon_stroke'] ?? '1.5' }}" stroke-linecap="round" stroke-linejoin="round">{!! $pillar['icon_svg'] !!}</svg>
                        </div>
                    @elseif(!empty($pillar['icon']))
                        <div class="{{ $iconClass }}" @if($variant === 'default') style="font-size: 2.5rem; margin-bottom: 1rem;" @endif>{!! $pillar['icon'] !!}</div>
                    @endif
                    @if(!empty($pillar['title']))
                        <h{{ $variant === 'mvv-pillars' ? '2' : '3' }} class="{{ $titleClass }}" @if($variant === 'default') style="font-size: 1.2rem; font-weight: 700; margin-bottom: 0.75rem; color: {{ $pillar['title_color'] ?? 'var(--color-primary)' }};" @endif>{{ $pillar['title'] }}</h{{ $variant === 'mvv-pillars' ? '2' : '3' }}>
                    @endif
                    @if(!empty($pillar['text']))
                        <p class="{{ $textClass }}" @if($variant === 'default') style="font-size: 0.95rem; color: #666; line-height: 1.6;" @endif>{{ $pillar['text'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>

        @if($variant === 'direccionadores' && !empty($data['valores_title']))
            {{-- Optional "Valores" sub-section for historia-style direccionadores --}}
        @endif
    </div>
</section>
