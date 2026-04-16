@extends('layouts.public')

@section('content')
<section class="blog-hero" style="background:var(--color-primary);color:#fff;padding:3rem 0;text-align:center;">
    <div class="container">
        <h1>Blog</h1>
        <p>Novedades y artículos del mundo agrícola</p>
    </div>
</section>

<section style="padding:3rem 0;">
    <div class="container">
        @if($posts->count())
            <div class="blog-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:2rem;">
                @foreach($posts as $post)
                    <article class="blog-card" style="border-radius:12px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.1);">
                        @if($post->featured_image)
                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" style="width:100%;height:200px;object-fit:cover;">
                        @endif
                        <div style="padding:1.5rem;">
                            @if($post->category)
                                <span style="font-size:0.75rem;color:var(--color-primary);font-weight:600;text-transform:uppercase;">{{ $post->category->name }}</span>
                            @endif
                            <h2 style="font-size:1.25rem;margin:0.5rem 0;"><a href="{{ route('blog.show', $post->slug) }}" style="color:var(--color-text);text-decoration:none;">{{ $post->title }}</a></h2>
                            <p style="color:#666;font-size:0.9rem;">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}</p>
                            <div style="margin-top:1rem;font-size:0.8rem;color:#999;">
                                {{ $post->published_at?->format('d/m/Y') }}
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div style="margin-top:2rem;">
                {{ $posts->links() }}
            </div>
        @else
            <p style="text-align:center;color:#666;">No hay publicaciones todavía.</p>
        @endif
    </div>
</section>
@endsection
