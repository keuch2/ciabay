@php
    $variant = $data['variant'] ?? 'default';
    $sectionClass = $variant === 'historia' ? 'historia-story' : 'narrative-section';
    $titleClass = $variant === 'historia' ? 'historia-section-title' : 'section-title';
    $contentClass = $variant === 'historia' ? 'historia-story-content' : 'narrative-content';
    $paraClass = $variant === 'historia' ? 'historia-story-paragraph' : 'narrative-paragraph';
    $captionClass = $variant === 'historia' ? 'historia-story-caption' : 'narrative-caption';
@endphp
<section class="{{ $sectionClass }}" @if($variant !== 'historia') style="padding: 3rem 0;" @endif>
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="{{ $titleClass }}">{{ $data['title'] }}</h2>
        @endif
        <div class="{{ $contentClass }}">
            @foreach($data['paragraphs'] ?? [] as $para)
                @if(!empty($para['text']))
                    <p class="{{ $paraClass }}">{!! $para['text'] !!}</p>
                @endif
            @endforeach
            @if(!empty($data['caption']))
                <p class="{{ $captionClass }}">{{ $data['caption'] }}</p>
            @endif
        </div>
    </div>
</section>
