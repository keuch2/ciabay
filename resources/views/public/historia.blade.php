{{--
    Plantilla "historia" — hard-coded (origen: nuevo_historia.html).
    Se activa con template='historia' en la página (select "Template" del admin).
    CSS/JS en public/assets/ (historia-page.css / historia-page.js), scopeados
    bajo .historia-v2 — mismo esquema que la plantilla sucursales.
--}}
@extends('layouts.public')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,300..900&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/historia-page.css') }}">
@endpush

@section('content')
<div class="historia-v2">
<!-- Retículas de globo decorativas en esquinas -->
<div class="reticle tl" aria-hidden="true">
  <svg width="480" height="480" viewBox="0 0 480 480" fill="none" stroke="currentColor" stroke-width="1.4">
    <circle cx="240" cy="240" r="230"/>
    <ellipse cx="240" cy="240" rx="230" ry="95"/><ellipse cx="240" cy="240" rx="230" ry="170"/>
    <ellipse cx="240" cy="240" rx="95" ry="230"/><ellipse cx="240" cy="240" rx="170" ry="230"/>
    <line x1="10" y1="240" x2="470" y2="240"/><line x1="240" y1="10" x2="240" y2="470"/>
  </svg>
</div>
<div class="reticle br" aria-hidden="true">
  <svg width="540" height="540" viewBox="0 0 480 480" fill="none" stroke="currentColor" stroke-width="1.4">
    <circle cx="240" cy="240" r="230"/>
    <ellipse cx="240" cy="240" rx="230" ry="95"/><ellipse cx="240" cy="240" rx="230" ry="170"/>
    <ellipse cx="240" cy="240" rx="95" ry="230"/><ellipse cx="240" cy="240" rx="170" ry="230"/>
    <line x1="10" y1="240" x2="470" y2="240"/><line x1="240" y1="10" x2="240" y2="470"/>
  </svg>
</div>

<!-- ================= HERO ================= -->
<header class="hero">
  <div class="wrap">
    <div class="hero-inner">
      <div class="eyebrow">Nuestra historia · Agricultura en buenas manos</div>
      <h1>Acá se inició <span class="arc-word">todo<svg viewBox="0 0 300 60" preserveAspectRatio="none" aria-hidden="true"><path d="M14 48 Q150 12 286 42"/></svg></span></h1>
      <p class="sub">Hace 31 años acompañamos al agro paraguayo con una <strong>propuesta integral</strong>, construida sobre experiencia, cercanía y compromiso.</p>

      <div class="stats" role="list">
        <div class="stat" role="listitem" tabindex="0">
          <b>’70s</b><span>El origen</span>
          <span class="tip">A finales de la década del 70, Don Oscar Lourenço llegó a Paraguay y comenzó su trayectoria en el comercio de granos.</span>
        </div>
        <div class="stat" role="listitem" tabindex="0">
          <b>1995</b><span>Nace CIABAY</span>
          <span class="tip">Con el propósito de ofrecer una solución integral al productor paraguayo.</span>
        </div>
        <div class="stat" role="listitem" tabindex="0">
          <b>+<em>31</em></b><span>Años en el mercado</span>
          <span class="tip">En 2025 cumplimos 30 años, reafirmando nuestro compromiso con el agro paraguayo.</span>
        </div>
        <div class="stat" role="listitem" tabindex="0">
          <b>8</b><span>Sucursales</span>
          <span class="tip">Presencia en las principales regiones productivas del país.</span>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- ================= COMPARADOR AYER / HOY ================= -->
<section class="section" id="transformacion">
  <div class="wrap">
    <div class="sec-head">
      <div>
        <div class="kicker">Ayer y hoy</div>
        <h2>La misma esencia,<br>otra escala</h2>
      </div>
      <p>Arrastrá el control verde y mirá la transformación: de la primera casa de CIABAY S.A. a la red de sucursales de hoy.</p>
    </div>

    <div class="compare" id="compare" style="--pos:90%">
      <div class="layer after">
        <img src="{{ asset('assets/images/historia/v2/sucursal-actual-de-ciabay.jpg') }}" alt="Sucursal actual de CIABAY, vista aérea con cartel Case IH y bandera paraguaya">
        <span class="cmp-badge right"><b>HOY</b>Red nacional · 8 sucursales</span>
      </div>
      <div class="layer before">
        <img src="{{ asset('assets/images/historia/v2/primera-casa-comercial-de.jpg') }}" alt="Primera casa comercial de CIABAY S.A. con tractores Case IH en exhibición">
        <span class="cmp-badge left"><b>AYER</b>CIABAY S.A. · Los inicios</span>
      </div>
      <div class="cmp-divider" aria-hidden="true"></div>
      <button class="cmp-handle" id="cmpHandle" role="slider" aria-label="Comparar la sucursal de ayer con la de hoy" aria-valuemin="0" aria-valuemax="100" aria-valuenow="90" aria-orientation="horizontal">⇆</button>
    </div>
    <div class="cmp-hint">← Arrastrá para comparar →</div>
  </div>
</section>

<!-- ================= EL LEGADO ================= -->
<section class="section">
  <div class="wrap">
    <div class="sec-head">
      <div>
        <div class="kicker">Nuestra historia en el agro paraguayo</div>
        <h2>El legado de<br>Don Oscar Lourenço</h2>
      </div>
    </div>
    <div class="legacy">
      <div class="txt">
        <div class="lead-in">— De los granos a la solución integral</div>
        <p>A finales de la década del 70, Don Oscar Lourenço llegó a Paraguay y comenzó su trayectoria en el comercio de granos. Con visión y esfuerzo, fundó <strong>Silo Amambay</strong>, una de las principales acopiadoras y comercializadoras de granos del país, marcando el inicio de un legado en el sector agrícola.</p>
        <p>Hoy, ese legado sigue vivo con el trabajo de muchas personas que, día a día, sostienen la misma convicción: <b>hacer las cosas bien y estar cerca del productor.</b></p>
      </div>
      <div class="pic">
        <img src="{{ asset('assets/images/historia/v2/muro-del-silo-amambay.jpg') }}" alt="Muro del Silo Amambay con la inscripción: Acá se inició todo">
        <div class="badges">
          <span class="badge green">Patrimonio</span>
          <span class="badge">«Acá se inició todo…»</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ================= BANNER FUNDADORES ================= -->
<section class="photo-banner">
  <div class="wrap">
    <figure class="photo-frame">
      <img src="{{ asset('assets/images/historia/v2/oscar-lourenco-y-vladimir.jpg') }}" alt="Oscar Lourenço y Vladimir Pesenti frente al Silo Amambay, donde se inició la historia de CIABAY">
      <div class="photo-badges">
        <span class="badge green">Años 70 · El origen</span>
        <span class="badge">Silo Amambay</span>
      </div>
      <figcaption class="photo-cap">
        <div class="q">Hacer las cosas bien y estar <em>cerca del productor</em></div>
        <div class="who">Oscar Lourenço · Vladimir Pesenti<small>Silo Amambay S.A. — «Acá se inició todo…»</small></div>
      </figcaption>
    </figure>
  </div>
</section>

<!-- ================= PRESIDENTE ================= -->
<section class="section">
  <div class="wrap">
    <div class="president">
      <div class="pic">
        <img src="{{ asset('assets/images/historia/v2/eduardo-lourenco-presidente-del.jpg') }}" alt="Eduardo Lourenço, presidente del Grupo CIABAY, en la casa matriz">
        <div class="badges">
          <span class="badge green">Presidencia</span>
          <span class="badge">Grupo CIABAY</span>
        </div>
      </div>
      <div class="panel">
        <div class="kicker">Al frente del grupo</div>
        <h3 class="name">Eduardo<br>Lourenço</h3>
        <div class="role">Presidente del Grupo CIABAY</div>
        <p>Bajo su liderazgo, el legado de la <b>familia Lourenço</b> se proyecta al futuro: la misma convicción de <b>hacer las cosas bien y estar cerca del productor</b>, hoy al frente de una identidad que sigue evolucionando con el agro paraguayo.</p>
      </div>
    </div>
  </div>
</section>

<!-- ================= LÍNEA DE TIEMPO HORIZONTAL ================= -->
<main class="section">
  <div class="wrap">
    <div class="sec-head">
      <div>
        <div class="kicker">Línea de tiempo</div>
        <h2>Una identidad que<br>evolucionó con el agro</h2>
      </div>
      <p>De Silo Amambay a la marca actual: cada etapa cuenta una parte de la historia. Deslizá la línea, filtrá por era o tocá el botón verde para el detalle.</p>
    </div>

    <div class="tl-toolbar">
      <div class="chips" id="chips" role="tablist" aria-label="Filtrar hitos por era">
        <button class="chip active" data-era="all">Todos</button>
        <button class="chip" data-era="origen">Orígenes</button>
        <button class="chip" data-era="fundacion">Años 90</button>
        <button class="chip" data-era="consolidacion">Años 2000</button>
        <button class="chip" data-era="identidad">Años 2010</button>
        <button class="chip" data-era="hoy">Hoy</button>
      </div>
      <div class="tl-nav">
        <button class="tl-btn" id="tlPrev" aria-label="Hito anterior">←</button>
        <button class="tl-btn" id="tlNext" aria-label="Hito siguiente">→</button>
      </div>
    </div>

    <div class="timeline-h">
      <div class="rail" aria-hidden="true"><i id="railFill"></i></div>
      <div class="track" id="timeline" tabindex="0" aria-label="Línea de tiempo horizontal, usá las flechas para desplazarte">

        <!-- AÑOS 70 -->
        <article class="milestone" data-era="origen">
          <div class="year-big"><b>’70s</b><span>Orígenes</span></div>
          <div class="card">
            <div class="media">
              <img class="photo" src="{{ asset('assets/images/historia/v2/fotografias-historicas-del-equipo.jpg') }}" alt="Fotografías históricas del equipo fundador de Silo Amambay" style="object-position:center 30%">
              <div class="badges">
                <span class="badge green">Orígenes</span>
                <span class="badge">Comercio de granos</span>
              </div>
            </div>
            <div class="body">
              <h3>Don Oscar funda Silo Amambay</h3>
              <p>A finales de la década del 70, Don Oscar Lourenço llegó a Paraguay y comenzó su trayectoria en el comercio de granos.</p>
              <div class="detail"><p>Con visión y esfuerzo fundó Silo Amambay, una de las principales acopiadoras y comercializadoras de granos del país: el inicio de un legado en el sector agrícola.</p></div>
              <div class="foot">
                <div class="tags"><span class="tag">Acopio</span><span class="tag">Legado</span></div>
                <button class="more" aria-label="Ver más detalle">→</button>
              </div>
            </div>
          </div>
        </article>

        <!-- 1995 -->
        <article class="milestone" data-era="fundacion">
          <div class="year-big"><b>1995</b><span>Fundación</span></div>
          <div class="card">
            <div class="media logo">
              <div class="logo-frame"><img src="{{ asset('assets/images/historia/v2/logo-original-de-ciabay.png') }}" alt="Logo original de Ciabay S.A., 1995"></div>
              <div class="badges">
                <span class="badge green">Fundación</span>
                <span class="badge">Identidad original</span>
              </div>
            </div>
            <div class="body">
              <h3>Nace CIABAY S.A.</h3>
              <p>Nace Ciabay S.A. con el propósito de ofrecer una solución integral al productor paraguayo.</p>
              <div class="detail"><p>Comercial e Industrial Amambay S.A.: un nombre que honra al silo donde comenzó todo.</p></div>
              <div class="foot">
                <div class="tags"><span class="tag">Solución integral</span></div>
                <button class="more" aria-label="Ver más detalle">→</button>
              </div>
            </div>
          </div>
        </article>

        <!-- 2000 -->
        <article class="milestone" data-era="consolidacion">
          <div class="year-big"><b>2000</b><span>Consolidación</span></div>
          <div class="card">
            <div class="media logo">
              <div class="logo-frame"><img src="{{ asset('assets/images/historia/v2/logo-de-ciabay-s.png') }}" alt="Logo de Ciabay S.A. del año 2000"></div>
              <div class="badges">
                <span class="badge green">Consolidación</span>
                <span class="badge">Marca</span>
              </div>
            </div>
            <div class="body">
              <h3>Identidad comercial reforzada</h3>
              <p>Reforzamos nuestra identidad comercial, consolidando presencia y confianza.</p>
              <div class="detail"><p>Las ondas verdes del logotipo se afirman como símbolo de la casa en todo el país.</p></div>
              <div class="foot">
                <div class="tags"><span class="tag">Presencia</span><span class="tag">Confianza</span></div>
                <button class="more" aria-label="Ver más detalle">→</button>
              </div>
            </div>
          </div>
        </article>

        <!-- 2008 -->
        <article class="milestone" data-era="consolidacion">
          <div class="year-big"><b>2008</b><span>Evolución</span></div>
          <div class="card">
            <div class="media logo">
              <div class="logo-frame"><img src="{{ asset('assets/images/historia/v2/logo-de-ciabay-2008.png') }}" alt="Logo de Ciabay 2008 con iconografía agrícola"></div>
              <div class="badges">
                <span class="badge green">Evolución</span>
                <span class="badge">Iconografía agrícola</span>
              </div>
            </div>
            <div class="body">
              <h3>Modernización de marca</h3>
              <p>Avanzamos en una modernización de marca con iconografía agrícola, reflejando evolución y cercanía.</p>
              <div class="detail"><p>La iconografía del campo llega al logotipo, reflejando la amplitud de la propuesta para cada etapa del cultivo.</p></div>
              <div class="foot">
                <div class="tags"><span class="tag">Evolución</span><span class="tag">Cercanía</span></div>
                <button class="more" aria-label="Ver más detalle">→</button>
              </div>
            </div>
          </div>
        </article>

        <!-- 2018 -->
        <article class="milestone" data-era="identidad">
          <div class="year-big"><b>2018</b><span>Identidad actual</span></div>
          <div class="card">
            <div class="media logo">
              <div class="logo-frame"><img src="{{ asset('assets/images/historia/v2/identidad-actual-de-ciabay.png') }}" alt="Identidad actual de CIABAY: Agricultura en buenas manos"></div>
              <div class="badges">
                <span class="badge green">Identidad actual</span>
                <span class="badge">Innovación</span>
              </div>
            </div>
            <div class="body">
              <h3>La identidad actual</h3>
              <p>Presentamos nuestra identidad actual, reflejando innovación y proyección.</p>
              <div class="detail"><p>El azul institucional, la curva verde y el lema «Agricultura en buenas manos» acompañan la marca hasta hoy.</p></div>
              <div class="foot">
                <div class="tags"><span class="tag">Innovación</span><span class="tag">Proyección</span></div>
                <button class="more" aria-label="Ver más detalle">→</button>
              </div>
            </div>
          </div>
        </article>

        <!-- 2025 -->
        <article class="milestone" data-era="hoy">
          <div class="year-big"><b>2025</b><span>30 años</span></div>
          <div class="card">
            <div class="media logo">
              <div class="logo-frame"><img src="{{ asset('assets/images/historia/v2/sello-conmemorativo-30-anos.png') }}" alt="Sello conmemorativo 30 años CIABAY"></div>
              <div class="badges">
                <span class="badge green">Aniversario</span>
                <span class="badge">30 años</span>
              </div>
            </div>
            <div class="body">
              <h3>30 años en el mercado</h3>
              <p>Cumplimos 30 años en el mercado, reafirmando nuestro compromiso con el agro paraguayo.</p>
              <div class="detail"><p>Tres décadas después de la fundación, la historia sigue escribiéndose junto al productor paraguayo.</p></div>
              <div class="foot">
                <div class="tags"><span class="tag">Compromiso</span><span class="tag">Aniversario</span></div>
                <button class="more" aria-label="Ver más detalle">→</button>
              </div>
            </div>
          </div>
        </article>

        <!-- HOY -->
        <article class="milestone" data-era="hoy">
          <div class="year-big"><b>HOY</b><span>Presente</span></div>
          <div class="card">
            <div class="media">
              <img class="photo" src="{{ asset('assets/images/historia/v2/casa-ciabay-con-la.jpg') }}" alt="Casa CIABAY con la flota de camiones de reparto de insumos" style="object-position:center 46%">
              <div class="badges">
                <span class="badge green">Presente</span>
                <span class="badge">8 sucursales</span>
              </div>
            </div>
            <div class="body">
              <h3>Agricultura en buenas manos</h3>
              <p>Hace 31 años acompañamos al agro paraguayo con una propuesta integral, construida sobre experiencia, cercanía y compromiso.</p>
              <div class="detail"><p>Con 8 sucursales en las principales regiones productivas, el equipo CIABAY sigue cerca del productor, campaña tras campaña.</p></div>
              <div class="foot">
                <div class="tags"><span class="tag">Paraguay</span><span class="tag">+200 personas</span></div>
                <button class="more" aria-label="Ver más detalle">→</button>
              </div>
            </div>
          </div>
        </article>

      </div>
      <div class="tl-progress" aria-hidden="true"><i id="tlBar"></i></div>
    </div>
  </div>
</main>

<!-- ================= BLOQUE DESTACADO + FOTO ================= -->
<section class="section">
  <div class="wrap">
    <div class="claim">
      <div class="claim-txt">
        <div class="kicker k">Cómo trabajamos</div>
        <p class="big"><em>Crecemos con el productor</em>, aportando soluciones que suman valor desde la <u>planificación hasta los resultados</u>.</p>
        <div class="src">Experiencia · Cercanía · Compromiso</div>
      </div>
      <div class="claim-pic">
        <img src="{{ asset('assets/images/historia/v2/joven-productor-con-gorra.jpg') }}" alt="Joven productor con gorra CIABAY dejando caer granos de maíz entre las manos">
        <div class="badges">
          <span class="badge green">Junto al productor</span>
          <span class="badge">Cosecha de maíz</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ================= DIRECCIONADORES ================= -->
<section class="section">
  <div class="wrap">
    <div class="sec-head">
      <div>
        <div class="kicker">Direccionadores</div>
        <h2>Misión y visión</h2>
      </div>
      <p>El norte que guía cada decisión, desde el primer silo hasta la red nacional de hoy.</p>
    </div>
    <div class="grid2">
      <div class="vcard dcard">
        <div class="ic-grad"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7 L12 12 L15.5 14"/></svg></div>
        <div class="num">MISIÓN</div>
        <h3>Soluciones sostenibles</h3>
        <p>Proveer un conjunto de soluciones sostenibles para las necesidades del agricultor.</p>
      </div>
      <div class="vcard dcard">
        <div class="ic-grad"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12 C5 6.5 8.5 4.5 12 4.5 C15.5 4.5 19 6.5 22 12 C19 17.5 15.5 19.5 12 19.5 C8.5 19.5 5 17.5 2 12 Z"/><circle cx="12" cy="12" r="3"/></svg></div>
        <div class="num">VISIÓN</div>
        <h3>La mejor opción integral</h3>
        <p>Ser reconocido por el agricultor como la mejor opción integral para su negocio.</p>
      </div>
    </div>
  </div>
</section>

<!-- ================= VALORES + FOTO ================= -->
<section class="section last">
  <div class="wrap">
    <div class="sec-head">
      <div>
        <div class="kicker">Valores</div>
        <h2>Lo que nos mueve</h2>
      </div>
      <p>Seis valores que sostienen la misma convicción desde los años 70: hacer las cosas bien.</p>
    </div>
    <div class="val-wrap">
      <div class="val-pic">
        <img src="{{ asset('assets/images/historia/v2/equipo-ciabay-junto-a.jpg') }}" alt="Equipo CIABAY junto a productores en un día de campo, observando el perfil de suelo de un cultivo de soja">
        <div class="badges">
          <span class="badge green">Día de campo</span>
          <span class="badge">Junto al productor</span>
        </div>
        <div class="val-cap">Valores que se viven en el campo, no en un papel</div>
      </div>
      <div class="grid-val">
      <div class="vcard valc">
        <div class="icv"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 6 L11 12 L5 18"/><path d="M12 6 L18 12 L12 18"/></svg></div>
        <div><b>Proactividad</b><span>Nos anticipamos</span></div>
      </div>
      <div class="vcard valc">
        <div class="icv"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3 L20 6 V11 C20 16 16.5 19.5 12 21 C7.5 19.5 4 16 4 11 V6 Z"/></svg></div>
        <div><b>Integridad</b><span>Hacemos lo correcto</span></div>
      </div>
      <div class="vcard valc">
        <div class="icv"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20 C7 16 3.5 12.8 3.5 9.2 C3.5 6.6 5.5 4.8 7.8 4.8 C9.4 4.8 11 5.7 12 7.2 C13 5.7 14.6 4.8 16.2 4.8 C18.5 4.8 20.5 6.6 20.5 9.2 C20.5 12.8 17 16 12 20 Z"/></svg></div>
        <div><b>Empatía</b><span>Escuchamos al productor</span></div>
      </div>
      <div class="vcard valc">
        <div class="icv"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="16" rx="3"/><line x1="4" y1="10" x2="20" y2="10"/><line x1="10" y1="10" x2="10" y2="20"/></svg></div>
        <div><b>Transparencia</b><span>Claridad en todo</span></div>
      </div>
      <div class="vcard valc">
        <div class="icv"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12 H7 L10 6 L14 18 L17 12 H21"/></svg></div>
        <div><b>Orientado a resultados</b><span>Sumamos valor</span></div>
      </div>
      <div class="vcard valc">
        <div class="icv"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M7 11 L11 3 C12.2 3 13.2 4 13.2 5.2 L12.6 9 H18.5 C19.9 9 20.8 10.3 20.4 11.6 L18.6 18.6 C18.3 19.7 17.4 20.4 16.3 20.4 H7"/><rect x="3" y="10.5" width="4" height="10" rx="1.4"/></svg></div>
        <div><b>Cliente satisfecho</b><span>Nuestra medida</span></div>
      </div>
      </div>
    </div>
  </div>
</section>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/historia-page.js') }}"></script>
@endpush
