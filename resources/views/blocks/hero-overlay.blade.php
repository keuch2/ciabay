<section class="page-hero" style="background-image: url('{{ asset($data['image'] ?? 'assets/images/hero_principal.jpg') }}');">
    <div class="page-hero-overlay">
        <div class="page-hero-content">
            @if(!empty($data['title']))
                <h1>{{ $data['title'] }}</h1>
            @endif
            @if(!empty($data['subtitle']))
                <p>{{ $data['subtitle'] }}</p>
            @endif
            @if(!empty($data['button_text']))
                @php
                    $raw = $data['button_url'] ?? '#';
                    if ($raw === '#' || preg_match('#^(https?:)?//#i', $raw) || str_starts_with($raw, 'mailto:') || str_starts_with($raw, 'tel:') || str_starts_with($raw, '#')) {
                        $href = $raw;
                    } else {
                        $href = url(ltrim($raw, '/'));
                    }
                    $target = $data['button_target'] ?? '_self';
                @endphp
                <a href="{{ $href }}" class="btn-primary" @if($target === '_blank') target="_blank" rel="noopener noreferrer" @endif>{{ $data['button_text'] }}</a>
            @endif
        </div>
    </div>
</section>
