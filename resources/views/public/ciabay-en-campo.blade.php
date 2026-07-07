{{--
    Plantilla "ciabay-en-campo" — hard-coded (origen: nuevo_ciabay_en_campo.html).
    Se activa con template='ciabay-en-campo' en la página (select "Template" del admin).
    CSS/JS en public/assets/ (ciabay-en-campo-page.css / ciabay-en-campo-page.js), scopeados
    bajo .encampo-v2 — mismo esquema que la plantilla sucursales.
--}}
@extends('layouts.public')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,300..900&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/ciabay-en-campo-page.css') }}">
@endpush

@section('content')
<div class="encampo-v2">
<!-- retículas de globo decorativas -->
<svg class="globe tl" viewBox="0 0 480 480" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
  <circle cx="240" cy="240" r="230"/>
  <ellipse cx="240" cy="240" rx="230" ry="95"/>
  <ellipse cx="240" cy="240" rx="230" ry="170"/>
  <ellipse cx="240" cy="240" rx="95" ry="230"/>
  <ellipse cx="240" cy="240" rx="170" ry="230"/>
  <line x1="10" y1="240" x2="470" y2="240"/><line x1="240" y1="10" x2="240" y2="470"/>
</svg>
<svg class="globe br" viewBox="0 0 480 480" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
  <circle cx="240" cy="240" r="230"/>
  <ellipse cx="240" cy="240" rx="230" ry="95"/>
  <ellipse cx="240" cy="240" rx="230" ry="170"/>
  <ellipse cx="240" cy="240" rx="95" ry="230"/>
  <ellipse cx="240" cy="240" rx="170" ry="230"/>
  <line x1="10" y1="240" x2="470" y2="240"/><line x1="240" y1="10" x2="240" y2="470"/>
</svg>

<!-- ================= HERO ================= -->
<header class="hero wrap in-view">
  <div class="eyebrow rev">Agricultura en evolución</div>
  <h1 class="rev" style="transition-delay:.08s">
    CIABAY EN
    <span class="arc-word">CAMPO<svg viewBox="0 0 300 60" preserveAspectRatio="none" aria-hidden="true"><path d="M14 48 Q150 12 286 42"/></svg></span>
  </h1>
  <p class="sub rev" style="transition-delay:.16s">
    Días de campo, <strong>demostraciones en vivo</strong>, capacitaciones técnicas y viajes a fábrica.
    Así acompañamos al productor paraguayo donde las cosas realmente pasan:
    <strong>en la tierra</strong>, con la máquina trabajando.
  </p>

  <!-- Los números son editables: ajustalos a los datos reales de CIABAY -->
  <div class="stats rev" style="transition-delay:.24s">
    <div class="stat" tabindex="0">
      <div class="num">+100</div>
      <div class="lbl">Eventos por año</div>
      <div class="tip">Días de campo, demostraciones dinámicas y jornadas técnicas en todas las regiones productivas del país.</div>
    </div>
    <div class="stat" tabindex="0">
      <div class="num">+100.000</div>
      <div class="lbl">Productores convocados</div>
      <div class="tip">Familias productoras que nos acompañan campaña tras campaña en parcelas, demos y capacitaciones.</div>
    </div>
    <div class="stat" tabindex="0">
      <div class="num" style="font-size:clamp(22px,2.7vw,33px);line-height:1.1;text-transform:uppercase">Todo <em>el país</em></div>
      <div class="lbl">Cobertura de eventos</div>
      <div class="tip">De Alto Paraná al Chaco: recorremos todos los departamentos con eventos y asistencia en campo.</div>
    </div>
  </div>

  <div class="hero-photo photo-panel rev" style="transition-delay:.32s">
    <img src="{{ asset('assets/images/ciabay-en-campo/v2/productores-recorriendo-la-parcela.jpg') }}" alt="Productores recorriendo la parcela demostrativa de maíz de CIABAY con mazorcas expuestas">
    <div class="pp-badges">
      <span class="badge green">Día de campo</span>
      <span class="badge">Parcelas demostrativas</span>
      <span class="badge">Maíz</span>
    </div>
    <div class="pp-caption">
      <div class="cap-kicker">Recorrida de parcelas · Campaña de maíz</div>
      <div class="cap-big">Esto es<br><em>CIABAY en campo</em></div>
    </div>
  </div>
</header>

<!-- ================= LA EXPERIENCIA ================= -->
<section id="experiencia">
  <div class="wrap">
    <div class="sec-head rev">
      <div>
        <div class="kicker">La experiencia CIABAY</div>
        <h2>El campo<br>se vive en familia</h2>
      </div>
      <p class="lead">Detrás de cada máquina hay una familia productora. Nuestros eventos se disfrutan: asado, mates, hijos que heredan el oficio y cosechas que se festejan juntos.</p>
    </div>

    <div class="mosaic">
      <div class="photo-panel m1 rev">
        <img src="{{ asset('assets/images/ciabay-en-campo/v2/padre-e-hijo-con.jpg') }}" alt="Padre e hijo con gorras CIABAY festejando la cosecha con granos de maíz cayendo">
        <div class="pp-badges"><span class="badge green">Cosecha 2026</span></div>
        <div class="pp-caption">
          <div class="cap-kicker">Generaciones en el campo</div>
          <div class="cap-big">El festejo también<br><em>se cosecha</em></div>
        </div>
      </div>
      <div class="photo-panel m2 rev" style="transition-delay:.09s">
        <img src="{{ asset('assets/images/ciabay-en-campo/v2/familia-productora-posando-entre.jpg') }}" alt="Familia productora posando entre los lotes de soja al atardecer">
        <div class="pp-caption">
          <div class="cap-kicker">Productores anfitriones</div>
          <div class="cap-big">Cada familia tiene<br><em>una historia</em></div>
        </div>
      </div>
      <div class="photo-panel m3 rev" style="transition-delay:.18s">
        <img src="{{ asset('assets/images/ciabay-en-campo/v2/clienta-con-gorra-ciabay.jpg') }}" alt="Clienta con gorra CIABAY frente a la maquinaria decorada con la bandera paraguaya" style="object-position:50% 12%">
        <div class="pp-caption">
          <div class="cap-kicker">Comunidad</div>
          <div class="cap-big">Orgullo<br><em>paraguayo</em></div>
        </div>
      </div>
      <div class="photo-panel m4 rev" style="transition-delay:.27s">
        <img src="{{ asset('assets/images/ciabay-en-campo/v2/colaborador-de-ciabay-sonriendo.jpg') }}" alt="Colaborador de CIABAY sonriendo mientras prepara el asado del día de campo" style="object-position:50% 24%">
        <div class="pp-caption">
          <div class="cap-kicker">Rito obligatorio</div>
          <div class="cap-big">Ningún día de campo<br><em>sin asado</em></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ================= DÍAS DE CAMPO ================= -->
<section id="dias-de-campo">
  <div class="wrap">
    <div class="sec-head rev">
      <div>
        <div class="kicker">Días de campo</div>
        <h2>La parcela<br>tiene la palabra</h2>
      </div>
      <p class="lead">Nuestros días de campo, contados como los vivimos en redes: recorridas por parcelas demostrativas, técnicos que responden en el lugar y resultados que se tocan. Deslizá y mirá el feed.</p>
    </div>

    <div class="rail-zone rev" style="transition-delay:.09s">
      <div class="rail" id="rail">
        <div class="rail-fill" id="railFill"></div>
      </div>
    </div>

    <div class="car rev" style="transition-delay:.18s">
      <div class="car-track" id="carTrack" aria-label="Galería de días de campo">

        <article class="car-card sm">
          <header class="sm-head">
            <span class="sm-avatar"><i><img src="{{ asset('assets/images/ciabay-en-campo/v2/ciabay.png') }}" alt="CIABAY"></i></span>
            <div class="sm-id"><b><a href="https://www.instagram.com/ciabaysa/" target="_blank" rel="noopener">ciabaysa</a></b><span>Alto Paraná · Paraguay</span></div>
            <a class="sm-net" href="https://www.instagram.com/ciabaysa/" target="_blank" rel="noopener" aria-label="Ver el perfil de CIABAY en Instagram"><img src="{{ asset('assets/images/ciabay-en-campo/v2/instagram.png') }}" alt="Instagram"></a>
          </header>
          <div class="sm-photo">
            <img src="{{ asset('assets/images/ciabay-en-campo/v2/productores-recorriendo-parcelas-demostrativas.jpg') }}" alt="Productores recorriendo parcelas demostrativas de maíz con mazorcas identificadas">
            <div class="pp-badges"><span class="badge green">Parcelas demo</span></div>
          </div>
          <div class="sm-actions">
            <button class="sm-like" type="button" aria-label="Me gusta"><svg width="23" height="23" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9" fill="none"><path class="h-fill" d="M12 21c-.6-.5-9-6.1-9-11.5C3 6.4 5.4 4 8.3 4c1.5 0 2.9.7 3.7 1.8C12.8 4.7 14.2 4 15.7 4 18.6 4 21 6.4 21 9.5 21 14.9 12.6 20.5 12 21z" fill="currentColor" stroke="none"/><path d="M12 21c-.6-.5-9-6.1-9-11.5C3 6.4 5.4 4 8.3 4c1.5 0 2.9.7 3.7 1.8C12.8 4.7 14.2 4 15.7 4 18.6 4 21 6.4 21 9.5 21 14.9 12.6 20.5 12 21z"/></svg></button>
            <button type="button" aria-label="Comentarios"><svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M21 11.6c0 4.3-4 7.8-9 7.8-1 0-2-.1-2.9-.4L4 21l1.2-4C3.8 15.6 3 13.7 3 11.6 3 7.3 7 3.8 12 3.8s9 3.5 9 7.8z"/></svg></button>
            <button type="button" aria-label="Compartir"><svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M21 3 3.6 10.3l6.9 2.8L13.3 20 21 3z"/><path d="M21 3 10.5 13.1"/></svg></button>
            <button class="sm-save" type="button" aria-label="Guardar"><svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M6 3.5h12V21l-6-4.2L6 21V3.5z"/></svg></button>
          </div>
          <div class="sm-likes"><b>1.248</b> Me gusta</div>
          <p class="sm-cap"><b>ciabaysa</b> Caminar en la parcela, ver la diferencia. Cada híbrido identificado y expuesto: el productor compara materiales lado a lado, en el mismo suelo y con el mismo clima. <span class="ht">#CIABAYenCampo #DíaDeCampo #Maíz</span></p>
          <div class="sm-time">Hace 2 días</div>
        </article>

        <article class="car-card sm">
          <header class="sm-head">
            <span class="sm-avatar"><i><img src="{{ asset('assets/images/ciabay-en-campo/v2/ciabay.png') }}" alt="CIABAY"></i></span>
            <div class="sm-id"><b><a href="https://www.instagram.com/ciabaysa/" target="_blank" rel="noopener">ciabaysa</a></b><span>Canindeyú · Paraguay</span></div>
            <a class="sm-net" href="https://www.instagram.com/ciabaysa/" target="_blank" rel="noopener" aria-label="Ver el perfil de CIABAY en Instagram"><img src="{{ asset('assets/images/ciabay-en-campo/v2/instagram.png') }}" alt="Instagram"></a>
          </header>
          <div class="sm-photo">
            <img src="{{ asset('assets/images/ciabay-en-campo/v2/tecnico-agronomo-mostrando-el.jpg') }}" alt="Técnico agrónomo mostrando el desarrollo radicular de una planta de maíz">
            <div class="pp-badges"><span class="badge">Suelo y raíces</span></div>
          </div>
          <div class="sm-actions">
            <button class="sm-like" type="button" aria-label="Me gusta"><svg width="23" height="23" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9" fill="none"><path class="h-fill" d="M12 21c-.6-.5-9-6.1-9-11.5C3 6.4 5.4 4 8.3 4c1.5 0 2.9.7 3.7 1.8C12.8 4.7 14.2 4 15.7 4 18.6 4 21 6.4 21 9.5 21 14.9 12.6 20.5 12 21z" fill="currentColor" stroke="none"/><path d="M12 21c-.6-.5-9-6.1-9-11.5C3 6.4 5.4 4 8.3 4c1.5 0 2.9.7 3.7 1.8C12.8 4.7 14.2 4 15.7 4 18.6 4 21 6.4 21 9.5 21 14.9 12.6 20.5 12 21z"/></svg></button>
            <button type="button" aria-label="Comentarios"><svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M21 11.6c0 4.3-4 7.8-9 7.8-1 0-2-.1-2.9-.4L4 21l1.2-4C3.8 15.6 3 13.7 3 11.6 3 7.3 7 3.8 12 3.8s9 3.5 9 7.8z"/></svg></button>
            <button type="button" aria-label="Compartir"><svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M21 3 3.6 10.3l6.9 2.8L13.3 20 21 3z"/><path d="M21 3 10.5 13.1"/></svg></button>
            <button class="sm-save" type="button" aria-label="Guardar"><svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M6 3.5h12V21l-6-4.2L6 21V3.5z"/></svg></button>
          </div>
          <div class="sm-likes"><b>986</b> Me gusta</div>
          <p class="sm-cap"><b>ciabaysa</b> La tecnología, a ras de suelo. Nuestros técnicos muestran lo que no se ve desde el camino: desarrollo radicular, calidad de implantación y el efecto real de cada decisión de siembra. <span class="ht">#Agronomía #CIABAYenCampo</span></p>
          <div class="sm-time">Hace 4 días</div>
        </article>

        <article class="car-card sm">
          <header class="sm-head">
            <span class="sm-avatar"><i><img src="{{ asset('assets/images/ciabay-en-campo/v2/ciabay.png') }}" alt="CIABAY"></i></span>
            <div class="sm-id"><b><a href="https://www.instagram.com/ciabaysa/" target="_blank" rel="noopener">ciabaysa</a></b><span>Caaguazú · Paraguay</span></div>
            <a class="sm-net" href="https://www.instagram.com/ciabaysa/" target="_blank" rel="noopener" aria-label="Ver el perfil de CIABAY en Instagram"><img src="{{ asset('assets/images/ciabay-en-campo/v2/instagram.png') }}" alt="Instagram"></a>
          </header>
          <div class="sm-photo">
            <img src="{{ asset('assets/images/ciabay-en-campo/v2/mazorcas-de-maiz-expuestas.jpg') }}" alt="Mazorcas de maíz expuestas en la parcela demostrativa">
            <div class="pp-badges"><span class="badge green">Cosecha</span></div>
          </div>
          <div class="sm-actions">
            <button class="sm-like" type="button" aria-label="Me gusta"><svg width="23" height="23" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9" fill="none"><path class="h-fill" d="M12 21c-.6-.5-9-6.1-9-11.5C3 6.4 5.4 4 8.3 4c1.5 0 2.9.7 3.7 1.8C12.8 4.7 14.2 4 15.7 4 18.6 4 21 6.4 21 9.5 21 14.9 12.6 20.5 12 21z" fill="currentColor" stroke="none"/><path d="M12 21c-.6-.5-9-6.1-9-11.5C3 6.4 5.4 4 8.3 4c1.5 0 2.9.7 3.7 1.8C12.8 4.7 14.2 4 15.7 4 18.6 4 21 6.4 21 9.5 21 14.9 12.6 20.5 12 21z"/></svg></button>
            <button type="button" aria-label="Comentarios"><svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M21 11.6c0 4.3-4 7.8-9 7.8-1 0-2-.1-2.9-.4L4 21l1.2-4C3.8 15.6 3 13.7 3 11.6 3 7.3 7 3.8 12 3.8s9 3.5 9 7.8z"/></svg></button>
            <button type="button" aria-label="Compartir"><svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M21 3 3.6 10.3l6.9 2.8L13.3 20 21 3z"/><path d="M21 3 10.5 13.1"/></svg></button>
            <button class="sm-save" type="button" aria-label="Guardar"><svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M6 3.5h12V21l-6-4.2L6 21V3.5z"/></svg></button>
          </div>
          <div class="sm-likes"><b>2.104</b> Me gusta</div>
          <p class="sm-cap"><b>ciabaysa</b> El rinde no se cuenta, se muestra. Mazorcas expuestas, espigas medidas, datos en mano: el resultado final a la altura de los ojos. <span class="ht">#Rinde #Genética #DíaDeCampo</span></p>
          <div class="sm-time">Hace 6 días</div>
        </article>

        <article class="car-card sm">
          <header class="sm-head">
            <span class="sm-avatar"><i><img src="{{ asset('assets/images/ciabay-en-campo/v2/ciabay.png') }}" alt="CIABAY"></i></span>
            <div class="sm-id"><b><a href="https://www.instagram.com/ciabaysa/" target="_blank" rel="noopener">ciabaysa</a></b><span>San Pedro · Paraguay</span></div>
            <a class="sm-net" href="https://www.instagram.com/ciabaysa/" target="_blank" rel="noopener" aria-label="Ver el perfil de CIABAY en Instagram"><img src="{{ asset('assets/images/ciabay-en-campo/v2/instagram.png') }}" alt="Instagram"></a>
          </header>
          <div class="sm-photo">
            <img src="{{ asset('assets/images/ciabay-en-campo/v2/productor-junto-al-cartel.jpg') }}" alt="Productor junto al cartel CIABAY de la parcela demostrativa NS75 VIP3">
            <div class="pp-badges"><span class="badge">Testimonios</span></div>
          </div>
          <div class="sm-actions">
            <button class="sm-like" type="button" aria-label="Me gusta"><svg width="23" height="23" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9" fill="none"><path class="h-fill" d="M12 21c-.6-.5-9-6.1-9-11.5C3 6.4 5.4 4 8.3 4c1.5 0 2.9.7 3.7 1.8C12.8 4.7 14.2 4 15.7 4 18.6 4 21 6.4 21 9.5 21 14.9 12.6 20.5 12 21z" fill="currentColor" stroke="none"/><path d="M12 21c-.6-.5-9-6.1-9-11.5C3 6.4 5.4 4 8.3 4c1.5 0 2.9.7 3.7 1.8C12.8 4.7 14.2 4 15.7 4 18.6 4 21 6.4 21 9.5 21 14.9 12.6 20.5 12 21z"/></svg></button>
            <button type="button" aria-label="Comentarios"><svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M21 11.6c0 4.3-4 7.8-9 7.8-1 0-2-.1-2.9-.4L4 21l1.2-4C3.8 15.6 3 13.7 3 11.6 3 7.3 7 3.8 12 3.8s9 3.5 9 7.8z"/></svg></button>
            <button type="button" aria-label="Compartir"><svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M21 3 3.6 10.3l6.9 2.8L13.3 20 21 3z"/><path d="M21 3 10.5 13.1"/></svg></button>
            <button class="sm-save" type="button" aria-label="Guardar"><svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M6 3.5h12V21l-6-4.2L6 21V3.5z"/></svg></button>
          </div>
          <div class="sm-likes"><b>1.532</b> Me gusta</div>
          <p class="sm-cap"><b>ciabaysa</b> Quien siembra, recomienda. Los protagonistas son los productores: cuentan su experiencia con cada material y cada máquina delante de sus propios lotes. <span class="ht">#Testimonios #Comunidad</span></p>
          <div class="sm-time">Hace 1 semana</div>
        </article>

        <article class="car-card sm">
          <header class="sm-head">
            <span class="sm-avatar"><i><img src="{{ asset('assets/images/ciabay-en-campo/v2/ciabay.png') }}" alt="CIABAY"></i></span>
            <div class="sm-id"><b><a href="https://www.instagram.com/ciabaysa/" target="_blank" rel="noopener">ciabaysa</a></b><span>Itapúa · Paraguay</span></div>
            <a class="sm-net" href="https://www.instagram.com/ciabaysa/" target="_blank" rel="noopener" aria-label="Ver el perfil de CIABAY en Instagram"><img src="{{ asset('assets/images/ciabay-en-campo/v2/instagram.png') }}" alt="Instagram"></a>
          </header>
          <div class="sm-photo">
            <img src="{{ asset('assets/images/ciabay-en-campo/v2/asistentes-con-gorras-ciabay.jpg') }}" alt="Asistentes con gorras CIABAY siguiendo una charla técnica frente al maizal">
            <div class="pp-badges"><span class="badge green">Capacitación</span></div>
          </div>
          <div class="sm-actions">
            <button class="sm-like" type="button" aria-label="Me gusta"><svg width="23" height="23" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9" fill="none"><path class="h-fill" d="M12 21c-.6-.5-9-6.1-9-11.5C3 6.4 5.4 4 8.3 4c1.5 0 2.9.7 3.7 1.8C12.8 4.7 14.2 4 15.7 4 18.6 4 21 6.4 21 9.5 21 14.9 12.6 20.5 12 21z" fill="currentColor" stroke="none"/><path d="M12 21c-.6-.5-9-6.1-9-11.5C3 6.4 5.4 4 8.3 4c1.5 0 2.9.7 3.7 1.8C12.8 4.7 14.2 4 15.7 4 18.6 4 21 6.4 21 9.5 21 14.9 12.6 20.5 12 21z"/></svg></button>
            <button type="button" aria-label="Comentarios"><svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M21 11.6c0 4.3-4 7.8-9 7.8-1 0-2-.1-2.9-.4L4 21l1.2-4C3.8 15.6 3 13.7 3 11.6 3 7.3 7 3.8 12 3.8s9 3.5 9 7.8z"/></svg></button>
            <button type="button" aria-label="Compartir"><svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M21 3 3.6 10.3l6.9 2.8L13.3 20 21 3z"/><path d="M21 3 10.5 13.1"/></svg></button>
            <button class="sm-save" type="button" aria-label="Guardar"><svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M6 3.5h12V21l-6-4.2L6 21V3.5z"/></svg></button>
          </div>
          <div class="sm-likes"><b>874</b> Me gusta</div>
          <p class="sm-cap"><b>ciabaysa</b> El aula es el maizal. Charlas cortas y concretas al pie del cultivo: manejo, regulación de máquinas y decisiones de campaña, con preguntas y respuestas en el momento. <span class="ht">#CharlasTécnicas #Manejo</span></p>
          <div class="sm-time">Hace 1 semana</div>
        </article>

        <article class="car-card sm">
          <header class="sm-head">
            <span class="sm-avatar"><i><img src="{{ asset('assets/images/ciabay-en-campo/v2/ciabay.png') }}" alt="CIABAY"></i></span>
            <div class="sm-id"><b><a href="https://www.instagram.com/ciabaysa/" target="_blank" rel="noopener">ciabaysa</a></b><span>Alto Paraná · Paraguay</span></div>
            <a class="sm-net" href="https://www.instagram.com/ciabaysa/" target="_blank" rel="noopener" aria-label="Ver el perfil de CIABAY en Instagram"><img src="{{ asset('assets/images/ciabay-en-campo/v2/instagram.png') }}" alt="Instagram"></a>
          </header>
          <div class="sm-photo">
            <img src="{{ asset('assets/images/ciabay-en-campo/v2/asesor-de-ciabay-conversando.jpg') }}" alt="Asesor de CIABAY conversando con un productor frente a la plataforma Bocuda de Vence Tudo" style="object-position:50% 26%">
            <div class="pp-badges"><span class="badge">Vence Tudo Bocuda</span></div>
          </div>
          <div class="sm-actions">
            <button class="sm-like" type="button" aria-label="Me gusta"><svg width="23" height="23" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9" fill="none"><path class="h-fill" d="M12 21c-.6-.5-9-6.1-9-11.5C3 6.4 5.4 4 8.3 4c1.5 0 2.9.7 3.7 1.8C12.8 4.7 14.2 4 15.7 4 18.6 4 21 6.4 21 9.5 21 14.9 12.6 20.5 12 21z" fill="currentColor" stroke="none"/><path d="M12 21c-.6-.5-9-6.1-9-11.5C3 6.4 5.4 4 8.3 4c1.5 0 2.9.7 3.7 1.8C12.8 4.7 14.2 4 15.7 4 18.6 4 21 6.4 21 9.5 21 14.9 12.6 20.5 12 21z"/></svg></button>
            <button type="button" aria-label="Comentarios"><svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M21 11.6c0 4.3-4 7.8-9 7.8-1 0-2-.1-2.9-.4L4 21l1.2-4C3.8 15.6 3 13.7 3 11.6 3 7.3 7 3.8 12 3.8s9 3.5 9 7.8z"/></svg></button>
            <button type="button" aria-label="Compartir"><svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M21 3 3.6 10.3l6.9 2.8L13.3 20 21 3z"/><path d="M21 3 10.5 13.1"/></svg></button>
            <button class="sm-save" type="button" aria-label="Guardar"><svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M6 3.5h12V21l-6-4.2L6 21V3.5z"/></svg></button>
          </div>
          <div class="sm-likes"><b>1.093</b> Me gusta</div>
          <p class="sm-cap"><b>ciabaysa</b> Mano a mano frente a la máquina. Cada consulta se responde al lado del equipo: configuración, mantenimiento y financiación, explicados sin vueltas. <span class="ht">#Asesoría #Posventa</span></p>
          <div class="sm-time">Hace 2 semanas</div>
        </article>

      </div>
      <div class="car-ui">
        <button class="car-btn" id="carPrev" aria-label="Anterior">←</button>
        <div class="car-prog"><i id="carProg"></i></div>
        <button class="car-btn" id="carNext" aria-label="Siguiente">→</button>
      </div>
    </div>
  </div>
</section>

<!-- ================= DEMOSTRACIONES EN VIVO ================= -->
<section id="demostraciones">
  <div class="wrap">
    <div class="sec-head rev">
      <div>
        <div class="kicker">Demostraciones en vivo</div>
        <h2>Máquinas<br>trabajando</h2>
      </div>
      <p class="lead">Cosechadoras, sembradoras y pulverizadores operando en condiciones reales. Subite, mirá de cerca y comprobá el rendimiento antes de decidir.</p>
    </div>

    <div class="demo-grid">
      <div class="photo-panel wide rev">
        <img src="{{ asset('assets/images/ciabay-en-campo/v2/descarga-de-maiz-de.jpg') }}" alt="Descarga de maíz de la cosechadora con la bandera paraguaya flameando">
        <div class="pp-badges"><span class="badge green">Cosecha demostrativa</span><span class="badge">Resultado real</span></div>
        <div class="pp-caption">
          <div class="cap-kicker">Descarga en vivo · Campaña de maíz</div>
          <div class="cap-big">Esto no es una promesa.<br><em>Es la descarga de hoy.</em></div>
        </div>
      </div>

      <div class="photo-panel half rev" style="transition-delay:.09s">
        <img src="{{ asset('assets/images/ciabay-en-campo/v2/cosechadora-case-ih-con.jpg') }}" alt="Cosechadora Case IH con plataforma maicera Vence Tudo Bocuda 7720 en plena cosecha">
        <div class="pp-badges"><span class="badge">Bocuda 7720</span></div>
        <div class="pp-caption">
          <div class="cap-kicker">Plataforma maicera · Vence Tudo</div>
          <div class="cap-big">Bocuda<br><em>en acción</em></div>
        </div>
      </div>

      <div class="photo-panel half rev" style="transition-delay:.18s">
        <img src="{{ asset('assets/images/ciabay-en-campo/v2/operario-cargando-semilla-en.jpg') }}" alt="Operario cargando semilla en los depósitos de la sembradora Vence Tudo" style="object-position:50% 22%">
        <div class="pp-badges"><span class="badge">Siembra</span></div>
        <div class="pp-caption">
          <div class="cap-kicker">Puesta a punto · Sembradoras</div>
          <div class="cap-big">Cada demo empieza<br><em>antes del amanecer</em></div>
        </div>
      </div>

      <div class="photo-panel wide rev" style="transition-delay:.09s">
        <img src="{{ asset('assets/images/ciabay-en-campo/v2/tractor-case-ih-farmall.jpg') }}" alt="Tractor Case IH Farmall 130A con sembradora Vence Tudo trabajando de noche">
        <div class="pp-badges"><span class="badge green">Demo en vivo</span><span class="badge">Case IH Farmall 130A</span><span class="badge">Vence Tudo</span></div>
        <div class="pp-caption">
          <div class="cap-kicker">Siembra nocturna · Demostración dinámica</div>
          <div class="cap-big">La siembra no espera.<br><em>Nosotros tampoco.</em></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ================= CLAIM ================= -->
<section>
  <div class="wrap">
    <div class="claim rev">
      <div class="kicker">Nuestra filosofía</div>
      <p class="phrase">Ver la máquina trabajar <em>vale más</em> que <u>mil folletos</u>.</p>
      <p class="foot"><b>Días de campo</b> · Demos en vivo · Capacitaciones · Viajes a fábrica · Posventa</p>
    </div>
  </div>
</section>

<!-- ================= CAPACITACIONES Y VIAJES ================= -->
<section id="capacitaciones">
  <div class="wrap">
    <div class="sec-head rev">
      <div>
        <div class="kicker">Capacitaciones</div>
        <h2>Aprender<br>de primera mano</h2>
      </div>
      <p class="lead">Entrenamos a operadores, técnicos y clientes junto a las propias fábricas, con el conocimiento aplicado directamente sobre la máquina y el cultivo.</p>
    </div>

    <div class="cap-grid">
      <article class="card rev">
        <div class="c-photo">
          <img src="{{ asset('assets/images/ciabay-en-campo/v2/grupo-de-tecnicos-y.jpg') }}" alt="Grupo de técnicos y clientes frente al pulverizador Case IH Patriot en un campo de abono verde">
          <div class="pp-badges"><span class="badge green">Entrenamiento</span></div>
        </div>
        <div class="c-body">
          <h3>Escuela de operadores</h3>
          <p>Jornadas prácticas de <strong>pulverización, siembra y cosecha</strong>: regulación, calibración y tecnología de precisión, directamente sobre la máquina y el cultivo.</p>
          <div class="c-tags"><span class="tag">Case IH</span><span class="tag">Agricultura de precisión</span><span class="tag">Operadores</span></div>
        </div>
      </article>

      <article class="card rev" style="transition-delay:.09s">
        <div class="c-photo">
          <img src="{{ asset('assets/images/ciabay-en-campo/v2/equipo-tecnico-de-ciabay.jpg') }}" alt="Equipo técnico de CIABAY posando frente a un pulverizador Case IH">
          <div class="pp-badges"><span class="badge">Equipo certificado</span></div>
        </div>
        <div class="c-body">
          <h3>Técnicos que no paran de estudiar</h3>
          <p>Nuestro equipo de posventa se certifica de forma continua. El conocimiento de fábrica llega a tu campo con cada visita.</p>
          <div class="c-tags"><span class="tag">Posventa</span><span class="tag">Certificaciones</span><span class="tag">Servicio</span></div>
        </div>
      </article>
    </div>
  </div>
</section>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/ciabay-en-campo-page.js') }}"></script>
@endpush
