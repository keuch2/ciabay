<section class="rich-text-section" style="padding: 4rem 0;">
    <div class="container" style="max-width: 900px;">
        @if(!empty($data['title']))
            <h2 class="section-title">{{ $data['title'] }}</h2>
        @endif
        @if(!empty($data['content']))
            <div class="rich-text-content" style="font-size: 1.05rem; line-height: 1.8; color: var(--color-text);">
                {!! $data['content'] !!}
            </div>
        @endif
    </div>
</section>
