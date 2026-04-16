<section class="agriculture-title-section">
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="agriculture-main-title">{!! str_replace("\n", '<br>', e($data['title'])) !!}</h2>
        @endif
    </div>
</section>
