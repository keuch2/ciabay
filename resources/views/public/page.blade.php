@extends('layouts.public')

@section('content')
    @if($page->blocks->count())
        {!! \App\Services\BlockRenderer::renderAll($page->blocks) !!}
    @else
        <section style="padding: 4rem 0;">
            <div class="container">
                <h1>{{ $page->title }}</h1>
            </div>
        </section>
    @endif
@endsection
