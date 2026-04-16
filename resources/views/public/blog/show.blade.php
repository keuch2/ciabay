@extends('layouts.public')

@section('content')
<article>
    <section style="background:var(--color-primary);color:#fff;padding:3rem 0;">
        <div class="container">
            @if($post->category)
                <span style="font-size:0.85rem;opacity:0.8;">{{ $post->category->name }}</span>
            @endif
            <h1 style="margin:0.5rem 0;">{{ $post->title }}</h1>
            <p style="opacity:0.7;font-size:0.9rem;">
                {{ $post->published_at?->format('d/m/Y') }}
                @if($post->author) &middot; {{ $post->author->name }} @endif
            </p>
        </div>
    </section>

    <section style="padding:3rem 0;">
        <div class="container" style="max-width:800px;">
            @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" style="width:100%;border-radius:12px;margin-bottom:2rem;">
            @endif
            <div class="blog-content" style="font-size:1.05rem;line-height:1.8;color:var(--color-text);">
                {!! $post->content !!}
            </div>
        </div>
    </section>
</article>
@endsection
