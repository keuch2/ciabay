<section class="intro-section" style="padding: 4rem 0;">
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="section-title">{{ $data['title'] }}</h2>
        @endif
        @if(!empty($data['text']))
            <div class="intro-text">{!! $data['text'] !!}</div>
        @endif
    </div>
</section>
