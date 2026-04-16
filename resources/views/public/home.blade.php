@extends('layouts.public')

@section('content')
    @if($page && $page->blocks->count())
        {!! \App\Services\BlockRenderer::renderAll($page->blocks) !!}
    @else
        <!-- Fallback: static hero while no blocks are configured -->
        <section class="hero">
            <div class="carousel-slide active">
                <picture>
                    <source media="(max-width: 768px)" srcset="{{ asset('assets/images/hero_prinicipal-mobile.jpg') }}">
                    <img src="{{ asset('assets/images/hero_principal.jpg') }}" alt="Ciabay - Agricultura en buenas manos">
                </picture>
                <div class="carousel-content">
                    <h1>Agricultura en buenas manos</h1>
                    <p>Más de 31 años siendo el aliado estratégico del productor paraguayo</p>
                    <a href="{{ url('contacto') }}" class="btn-primary">Contáctenos</a>
                </div>
            </div>
        </section>
    @endif
@endsection
