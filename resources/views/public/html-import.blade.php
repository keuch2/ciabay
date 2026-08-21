{{--
    Vista genérica de las páginas importadas desde una maqueta HTML
    (template reservado 'html-import'). El contenido procesado vive en la
    tabla page_imports (body/JS) y en storage/imported-pages/{page_id}/
    (CSS + media). El HTML NUNCA se compila como Blade: se emite como
    string con {!! !!} (los @ y {{ }} de una maqueta romperían la vista),
    y los placeholders __PAGE_ASSETS__ se resuelven con asset() en render
    time para soportar deploys con prefijo de path.
--}}
@extends('layouts.public')

@php($import = $page->htmlImport)

@if(! $import)
    @if(! empty($isDraft) || (auth()->check() && auth()->user()->isStaff()))
        @section('content')
            <section style="padding:4rem 0;text-align:center;">
                <div class="container">
                    <h1>{{ $page->title }}</h1>
                    <p style="margin-top:1rem;color:#92400e;background:#fef3c7;display:inline-block;padding:.75rem 1.25rem;border-radius:.5rem;">
                        Esta página tiene la plantilla "HTML importado" pero todavía no se subió ninguna maqueta.
                        Subila desde el editor de la página en el admin. (Aviso visible solo para administradores.)
                    </p>
                </div>
            </section>
        @endsection
    @else
        @php(abort(404))
    @endif
@else
    @push('styles')
        @if($import->google_fonts)
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            @foreach($import->google_fonts as $fontHref)
                <link href="{{ $fontHref }}" rel="stylesheet">
            @endforeach
        @endif
        @if($import->cssUrl())
            <link rel="stylesheet" href="{{ $import->cssUrl() }}">
        @endif
    @endpush

    @section('content')
<div class="{{ \App\Services\HtmlPageImporter::WRAPPER_CLASS }}">
{!! $import->renderedBody() !!}
</div>
    @endsection

    @push('scripts')
        <script>
            (function () {
                // --site-header-h: el CSS scopeado la usa para que los sticky
                // de la maqueta calcen debajo del header del sitio.
                var hdr = document.querySelector('.main-header');
                var set = function () {
                    document.documentElement.style.setProperty('--site-header-h', (hdr ? hdr.offsetHeight : 0) + 'px');
                };
                set();
                window.addEventListener('resize', set, { passive: true });
                @if(!empty($import->manifest['body_class']))
                    // clase que la maqueta traía en su <body> (el CSS scopeado
                    // body.clase .html-import ... la espera ahí)
                    document.body.classList.add(...@json(preg_split('/\s+/', trim($import->manifest['body_class']))));
                @endif
            })();
        </script>
        @if($import->renderedJs())
            <script id="html-import-js">{!! $import->renderedJs() !!}</script>
        @endif
    @endpush
@endif
