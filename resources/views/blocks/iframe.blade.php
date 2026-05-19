@php
    $url = $data['embed_url'] ?? '';
    $height = (int) ($data['height'] ?? 600);
    $widthMode = $data['width_mode'] ?? 'container';
    $widthCustom = trim($data['width_custom'] ?? '');
    $allowFullscreen = (bool) ($data['allow_fullscreen'] ?? true);
    $allowScroll = (bool) ($data['allow_scroll'] ?? true);

    $wrapperStyle = '';
    $iframeWidth = '100%';
    if ($widthMode === 'full') {
        $wrapperStyle = 'margin-left: calc(50% - 50vw); width: 100vw; max-width: 100vw;';
    } elseif ($widthMode === 'custom' && $widthCustom !== '') {
        $wrapperStyle = 'max-width: ' . e($widthCustom) . '; margin-left: auto; margin-right: auto;';
    }
@endphp
@if($url)
<section class="iframe-block" style="padding: 2rem 0; overflow-x: hidden;">
    <div class="container">
        <div style="{{ $wrapperStyle }}">
            <iframe
                src="{{ $url }}"
                width="{{ $iframeWidth }}"
                height="{{ $height }}"
                style="border:0; display: block;"
                scrolling="{{ $allowScroll ? 'yes' : 'no' }}"
                @if($allowFullscreen) allowfullscreen @endif
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>
@endif
