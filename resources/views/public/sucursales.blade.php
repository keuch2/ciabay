{{--
    Plantilla "sucursales" — mapa interactivo de sucursales (hard-coded).
    Origen: nuevo_sucursales.html. Se activa poniendo template = 'sucursales'
    en la página (select "Plantilla" del admin). CSS/JS en public/assets/
    (sucursales-page.css / sucursales-page.js), scopeados bajo .sucursales-v2.
--}}
@extends('layouts.public')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wdth,wght@0,62..125,100..900;1,62..125,100..900&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/sucursales-page.css') }}">
@endpush

@section('content')
<div class="sucursales-v2">

    <!-- fondo decorativo: mundo visto desde arriba -->
    <svg class="globe globe-a" viewBox="0 0 800 800" aria-hidden="true">
        <g id="globeart" stroke-width="1.2">
            <circle cx="400" cy="400" r="70"/>
            <circle cx="400" cy="400" r="150"/>
            <circle cx="400" cy="400" r="230"/>
            <circle cx="400" cy="400" r="310"/>
            <circle cx="400" cy="400" r="352" stroke-dasharray="2 10"/>
            <circle cx="400" cy="400" r="390" stroke-width="1.6"/>
            <line x1="790" y1="400" x2="10" y2="400"/>
            <line x1="777" y1="501" x2="23" y2="299"/>
            <line x1="738" y1="595" x2="62" y2="205"/>
            <line x1="676" y1="676" x2="124" y2="124"/>
            <line x1="595" y1="738" x2="205" y2="62"/>
            <line x1="501" y1="777" x2="299" y2="23"/>
            <line x1="400" y1="790" x2="400" y2="10"/>
            <line x1="299" y1="777" x2="501" y2="23"/>
            <line x1="205" y1="738" x2="595" y2="62"/>
            <line x1="124" y1="676" x2="676" y2="124"/>
            <line x1="62" y1="595" x2="738" y2="205"/>
            <line x1="23" y1="501" x2="777" y2="299"/>
        </g>
    </svg>
    <svg class="globe globe-b" viewBox="0 0 800 800" aria-hidden="true"><use href="#globeart"/></svg>

    <main class="wrap">

        <section class="hero">
            <canvas id="globo3d" aria-hidden="true"></canvas>
            <div class="eyebrow">Red CIABAY · Paraguay</div>
            <h1>Nuestras<br>
                <span class="arc-word">Sucursales
                    <svg viewBox="0 0 300 26" preserveAspectRatio="none" aria-hidden="true">
                        <path d="M4 22 Q150 -10 296 22" stroke="#79b943" stroke-width="7" fill="none" stroke-linecap="round"/>
                    </svg>
                </span>
            </h1>
            <p class="sub">Estamos presentes en las principales zonas productivas del país. Elegí un departamento en el mapa y encontrá la sucursal más cercana a tu campo.</p>
            <div class="stats" role="list">
                <div class="stat" role="listitem"><div class="n"><em>08</em></div><div class="l">Sucursales</div></div>
                <div class="stat" role="listitem"><div class="n"><em>06</em></div><div class="l">Departamentos</div></div>
                <div class="stat" role="listitem"><div class="n"><em>02</em></div><div class="l">Regiones · Oriental y Chaco</div></div>
            </div>
        </section>

        <section class="main" id="sucursales">
            <div class="map-col">
                <div class="map-hint"><span class="dotpulse"></span> HACÉ CLIC EN UN DEPARTAMENTO</div>
                <svg id="mapa" viewBox="0 0 620 680" role="group" aria-label="Mapa de Paraguay por departamentos"></svg>
                <div class="legend">
                    <span><i class="c1"></i> DEPARTAMENTO CON SUCURSAL</span>
                    <span><i class="c2"></i> SUCURSAL</span>
                    <span><i class="c3"></i> CASA MATRIZ</span>
                </div>
            </div>

            <div class="panel-col">
                <div class="chips" id="chips"></div>
                <div class="panel-head">
                    <div class="k" id="pk">Red completa</div>
                    <h2 id="ptitle"></h2>
                </div>
                <div class="cards" id="cards"></div>
            </div>
        </section>

    </main>

    <div id="tip"></div>

</div>
@endsection

@push('scripts')
    @php
        $sucursalesImgs = [];
        foreach (['matriz', 'bellavista', 'campo9', 'katuete', 'lomaplata', 'rioverde', 'sanalberto', 'santarita'] as $sucId) {
            $sucursalesImgs[$sucId] = asset('assets/images/sucursales/v2/' . $sucId . '.jpg');
        }
    @endphp
    <script>
        window.SUCURSALES_IMG = {!! json_encode($sucursalesImgs) !!};
    </script>
    <script src="{{ asset('assets/js/sucursales-page.js') }}"></script>
@endpush
