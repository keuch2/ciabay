@php
    $variant = $data['variant'] ?? 'default';
    $sectionClass = $variant === 'mvv' ? 'mvv-objetivos' : 'callout-section';
    $contentClass = $variant === 'mvv' ? 'mvv-objetivos-content' : 'callout-content';
    $iconClass = $variant === 'mvv' ? 'mvv-objetivos-icon' : 'callout-icon';
    $titleClass = $variant === 'mvv' ? 'mvv-objetivos-title' : 'callout-title';
    $textClass = $variant === 'mvv' ? 'mvv-objetivos-text' : 'callout-text';
@endphp
<section class="{{ $sectionClass }}" @if($variant !== 'mvv') style="padding: 3rem 0; text-align: center;" @endif>
    <div class="container">
        <div class="{{ $contentClass }}">
            @if(!empty($data['icon_svg']))
                <div class="{{ $iconClass }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $data['icon_stroke'] ?? '1.5' }}" stroke-linecap="round" stroke-linejoin="round">{!! $data['icon_svg'] !!}</svg>
                </div>
            @endif
            @if(!empty($data['title']))
                <h2 class="{{ $titleClass }}">{{ $data['title'] }}</h2>
            @endif
            @if(!empty($data['text']))
                <p class="{{ $textClass }}">{!! $data['text'] !!}</p>
            @endif
        </div>
    </div>
</section>
