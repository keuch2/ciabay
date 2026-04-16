<section class="quote-section" style="background: {{ $data['background'] ?? 'var(--color-primary)' }}; color: {{ $data['color'] ?? '#fff' }}; padding: 4rem 0; text-align: center;">
    <div class="container" style="max-width: 800px;">
        @if(!empty($data['quote']))
            <blockquote style="font-size: 1.5rem; font-style: italic; line-height: 1.6; margin-bottom: 1rem;">
                "{{ $data['quote'] }}"
            </blockquote>
        @endif
        @if(!empty($data['author']))
            <cite style="font-size: 1rem; opacity: 0.8;">— {{ $data['author'] }}</cite>
        @endif
    </div>
</section>
