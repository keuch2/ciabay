@php
    $variant = $data['variant'] ?? 'historia';
    if ($variant === 'mvv') {
        $sectionTag = 'section';
        $sectionClass = 'mvv-valores';
        $titleClass = 'mvv-section-title';
        $gridClass = 'mvv-valores-grid';
        $cardClass = 'mvv-valor-card';
        $iconClass = 'mvv-valor-icon';
        $labelClass = 'mvv-valor-title';
        $labelTag = 'h3';
    } else {
        // historia variant renders as a <div> so it can nest inside pillars-direccionadores section
        $sectionTag = 'div';
        $sectionClass = 'valores-section';
        $titleClass = 'valores-title';
        $gridClass = 'valores-grid';
        $cardClass = 'valor-item';
        $iconClass = 'valor-icon';
        $labelClass = 'valor-text';
        $labelTag = 'p';
    }
@endphp
<{{ $sectionTag }} class="{{ $sectionClass }}">
    @if($sectionTag === 'section')
        <div class="container">
    @else
        @php /* historia variant still needs container padding since it's rendered as a div (not wrapped by parent section in the block composition) */ @endphp
    @endif
    @if(!empty($data['title']))
        <h{{ $variant === 'mvv' ? '2' : '3' }} class="{{ $titleClass }}">{{ $data['title'] }}</h{{ $variant === 'mvv' ? '2' : '3' }}>
    @endif
    <div class="{{ $gridClass }}">
        @foreach($data['items'] ?? [] as $item)
            <div class="{{ $cardClass }}">
                @if(!empty($item['icon_svg']))
                    <div class="{{ $iconClass }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $item['icon_stroke'] ?? ($variant === 'mvv' ? '1.5' : '2') }}" stroke-linecap="round" stroke-linejoin="round">{!! $item['icon_svg'] !!}</svg>
                    </div>
                @endif
                @if(!empty($item['label']))
                    <{{ $labelTag }} class="{{ $labelClass }}">{{ $item['label'] }}</{{ $labelTag }}>
                @endif
            </div>
        @endforeach
    </div>
    @if($sectionTag === 'section')
        </div>
    @endif
</{{ $sectionTag }}>
