{{--
    Plantilla "nidera" — hard-coded (origen: nuevo_nidera.html).
    Se activa con template='nidera' en la página (select "Template" del admin).
    CSS/JS en public/assets/ (nidera-page.css / nidera-page.js), scopeados
    bajo .nidera-v2 — mismo esquema que las plantillas sucursales / ciabay-en-campo.
    El detalle de cada híbrido es un overlay JS con deep-link por hash (#producto-ns-66).
--}}
@extends('layouts.public')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,300..900&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/nidera-page.css') }}">
@endpush

@section('content')
<div class="nidera-v2">
<div class="scroll-progress" aria-hidden="true"><i id="spFill"></i></div>

<svg class="globe tl" viewBox="0 0 480 480" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
  <!-- cuerpo de la espiga -->
  <ellipse cx="240" cy="180" rx="78" ry="152"/>
  <ellipse cx="240" cy="180" rx="58" ry="152"/>
  <ellipse cx="240" cy="180" rx="37" ry="151"/>
  <ellipse cx="240" cy="180" rx="15" ry="150"/>
  <!-- hileras de granos -->
  <ellipse cx="240" cy="64" rx="42" ry="9"/>
  <ellipse cx="240" cy="93" rx="57" ry="10"/>
  <ellipse cx="240" cy="122" rx="67" ry="10"/>
  <ellipse cx="240" cy="151" rx="74" ry="10"/>
  <ellipse cx="240" cy="180" rx="78" ry="10"/>
  <ellipse cx="240" cy="209" rx="74" ry="10"/>
  <ellipse cx="240" cy="238" rx="67" ry="10"/>
  <ellipse cx="240" cy="267" rx="57" ry="10"/>
  <ellipse cx="240" cy="296" rx="42" ry="9"/>
  <!-- chalas -->
  <path d="M234 324 C196 358 158 396 136 448"/>
  <path d="M246 324 C284 358 322 396 344 448"/>
  <path d="M240 330 C234 372 228 408 214 452"/>
  <path d="M240 330 C248 374 254 410 266 452"/>
  <!-- barbas -->
  <path d="M232 30 C226 18 218 10 206 4"/>
  <path d="M240 28 C240 16 238 8 240 0"/>
  <path d="M248 30 C254 18 262 10 274 4"/>
</svg>
<svg class="globe br" viewBox="0 0 480 480" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
  <!-- cuerpo de la espiga -->
  <ellipse cx="240" cy="180" rx="78" ry="152"/>
  <ellipse cx="240" cy="180" rx="58" ry="152"/>
  <ellipse cx="240" cy="180" rx="37" ry="151"/>
  <ellipse cx="240" cy="180" rx="15" ry="150"/>
  <!-- hileras de granos -->
  <ellipse cx="240" cy="64" rx="42" ry="9"/>
  <ellipse cx="240" cy="93" rx="57" ry="10"/>
  <ellipse cx="240" cy="122" rx="67" ry="10"/>
  <ellipse cx="240" cy="151" rx="74" ry="10"/>
  <ellipse cx="240" cy="180" rx="78" ry="10"/>
  <ellipse cx="240" cy="209" rx="74" ry="10"/>
  <ellipse cx="240" cy="238" rx="67" ry="10"/>
  <ellipse cx="240" cy="267" rx="57" ry="10"/>
  <ellipse cx="240" cy="296" rx="42" ry="9"/>
  <!-- chalas -->
  <path d="M234 324 C196 358 158 396 136 448"/>
  <path d="M246 324 C284 358 322 396 344 448"/>
  <path d="M240 330 C234 372 228 408 214 452"/>
  <path d="M240 330 C248 374 254 410 266 452"/>
  <!-- barbas -->
  <path d="M232 30 C226 18 218 10 206 4"/>
  <path d="M240 28 C240 16 238 8 240 0"/>
  <path d="M248 30 C254 18 262 10 274 4"/>
</svg>

<!-- ═══════════ HERO ═══════════ -->
<header class="hero" id="hero">
  <canvas class="kern-canvas" id="kernCanvas" aria-hidden="true"></canvas>
  <div class="hero-strip">
      <div class="item">
        <div class="ph ph-rev rv"><img decoding="async" src="{{ asset('assets/images/nidera/v2/productores-conversando-en-un.jpg') }}" alt="Productores conversando en un día de campo CIABAY"></div>
        <div class="cap rv">Productores + CIABAY</div>
      </div>
      <div class="item">
        <div class="ph ph-rev rv" style="transition-delay:.1s"><img decoding="async" src="{{ asset('assets/images/nidera/v2/manos-de-productor-mostrando.jpg') }}" alt="Manos de productor mostrando el grano de maíz Nidera"></div>
        <div class="cap rv" style="transition-delay:.1s">El grano en detalle</div>
      </div>
      <div class="item">
        <div class="ph ph-rev rv" style="transition-delay:.2s"><img decoding="async" src="{{ asset('assets/images/nidera/v2/bandera-paraguaya-y-banderin.jpg') }}" alt="Bandera paraguaya y banderín CIABAY sobre la parcela demostrativa"></div>
        <div class="cap rv" style="transition-delay:.2s">Orgullo paraguayo</div>
      </div>
      <div class="item">
        <div class="ph ph-rev rv" style="transition-delay:.3s"><img decoding="async" src="{{ asset('assets/images/nidera/v2/grupo-de-productores-recorriendo.jpg') }}" alt="Grupo de productores recorriendo el maizal en el día de campo Nidera"></div>
        <div class="cap rv" style="transition-delay:.3s">Día de campo Nidera</div>
      </div>
  </div>
  <div class="wrap">
    <div class="hero-head">
      <h1 class="rv" style="transition-delay:.08s">
        <span class="row1"><span class="lr"><b>Nidera</b> <span class="kern-text">Maíz</span></span></span>
        <span class="row2"><span class="lr">Genética que <span class="uw">rinde<svg viewBox="0 0 300 60" preserveAspectRatio="none" aria-hidden="true"><path d="M14 48 Q150 12 286 42"/></svg></span></span></span>
      </h1>
      <p class="hero-sub rv" style="transition-delay:.17s">
        La genética de maíz <strong>Nidera</strong> llega al campo paraguayo de la mano de
        <strong>CIABAY</strong>: híbridos de <strong>alto potencial de rinde</strong>, sanidad de
        planta y estabilidad probada parcela por parcela, campaña tras campaña.
      </p>
    </div>
  </div>
</header>

<!-- ═══════════ TICKER ═══════════ -->
<div class="ticker" aria-hidden="true">
  <div class="ticker-track">
    <div class="ticker-half"><span>Genética que rinde</span><i></i><span>Tecnología VIP 3</span><i></i><span>Zafra &amp; zafriña</span><i></i><span>Alto potencial</span><i></i><span>Sanidad de planta</span><i></i><span>Respaldo CIABAY</span><i></i></div>
    <div class="ticker-half"><span>Genética que rinde</span><i></i><span>Tecnología VIP 3</span><i></i><span>Zafra &amp; zafriña</span><i></i><span>Alto potencial</span><i></i><span>Sanidad de planta</span><i></i><span>Respaldo CIABAY</span><i></i></div>
  </div>
</div>

<!-- ═══════════ CLAIM ═══════════ -->
<section class="wrap">
  <div class="claim rv">
    <div class="kicker">Nuestra convicción</div>
    <div class="phrase">
      El rinde <em>no se promete</em>:<br>se <u>demuestra</u> en la parcela.
    </div>
    <div class="foot">Genética <i>·</i> Sanidad <i>·</i> Estabilidad <i>·</i> Respaldo CIABAY</div>
  </div>
</section>

<!-- ═══════════ LA MARCA ═══════════ -->
<section class="wrap" id="genetica">
  <div class="sec-head rv">
    <div>
      <h2>Genética que se ve<br>en la espiga</h2>
    </div>
    <p>Nidera Maíz combina mejoramiento genético de élite con biotecnología de punta,
    seleccionado para el sistema productivo paraguayo.</p>
  </div>
  <div class="editorial">
    <div class="txt-panel rv">
      <h3>Espigas uniformes, granos profundos, <em>plantas sanas</em></h3>
      <p>Detrás de cada híbrido Nidera hay décadas de <b>mejoramiento genético</b> y una red de
      ensayos que cruza ambientes, fechas de siembra y niveles de tecnología. El resultado se ve
      a simple vista: <strong>espigas parejas</strong>, buen llenado hasta la punta y plantas que
      llegan verdes al final del ciclo.</p>
      <p>El portfolio incorpora <strong>biotecnología de última generación</strong> para protección
      contra lepidópteros y tolerancia a herbicidas, cuidando el potencial de rinde desde la
      emergencia hasta la cosecha.</p>
      <p>Y porque cada chacra es distinta, la genética se prueba donde importa: <b>en el campo
      paraguayo</b>, del norte de San Pedro al este de Alto Paraná, en zafra y en zafriña.</p>
      <div class="tags">
        <span class="tag">Alto potencial</span>
        <span class="tag">Sanidad de planta</span>
        <span class="tag">Grano profundo</span>
        <span class="tag">Stay green</span>
        <span class="tag">Estabilidad</span>
      </div>
    </div>
    <div class="ph ph-rev rv" style="transition-delay:.12s">
      <img id="srcEspigas" decoding="async" src="{{ asset('assets/images/nidera/v2/espigas-de-maiz-nidera.jpg') }}" alt="Espigas de maíz Nidera en parcela demostrativa">
      <div class="badges">
        <span class="badge green">Parcela demostrativa</span>
        <span class="badge">Nidera Maíz</span>
      </div>
      <div class="ph-cap">
        <b>La espiga <em>habla</em> por sí sola</b>
        Llenado completo · Sanidad de punta a punta
      </div>
    </div>
  </div>
</section>

<!-- ═══════════ HÍBRIDOS ═══════════ -->
<section class="wrap" id="hibridos">
  <div class="sec-head rv">
    <div>
      <h2>Un híbrido para<br>cada planteo</h2>
    </div>
    <p>Cuatro híbridos con tecnología VIP 3. Tocá cualquiera de los productos
    para conocer su perfil en detalle.</p>
  </div>
  <div class="prod-list">
    <a class="prod-row rv" href="#producto-ns-66" data-pid="ns-66" data-num="01">
      <span class="pl">
        <span class="idx">01</span>
        <span>
          <span class="nm">NS 66 <span class="vip">VIP 3</span> <span class="vip launch">Lanzamiento</span></span>
          <span class="tg" style="display:block">Elevado techo productivo con consistencia</span>
        </span>
      </span>
      <span class="go" aria-hidden="true">→</span>
    </a>
    <a class="prod-row rv" href="#producto-ns-80" data-pid="ns-80" data-num="02" style="transition-delay:.07s">
      <span class="pl">
        <span class="idx">02</span>
        <span>
          <span class="nm">NS 80 <span class="vip">VIP 3</span></span>
          <span class="tg" style="display:block">Triple propósito más rentable</span>
        </span>
      </span>
      <span class="go" aria-hidden="true">→</span>
    </a>
    <a class="prod-row rv" href="#producto-ns-71" data-pid="ns-71" data-num="03" style="transition-delay:.14s">
      <span class="pl">
        <span class="idx">03</span>
        <span>
          <span class="nm">NS 71 <span class="vip">VIP 3</span></span>
          <span class="tg" style="display:block">Estabilidad y seguridad en todos los ambientes</span>
        </span>
      </span>
      <span class="go" aria-hidden="true">→</span>
    </a>
    <a class="prod-row rv" href="#producto-ns-75" data-pid="ns-75" data-num="04" style="transition-delay:.21s">
      <span class="pl">
        <span class="idx">04</span>
        <span>
          <span class="nm">NS 75 <span class="vip">VIP 3</span></span>
          <span class="tg" style="display:block">Versatilidad temprana con máximo rendimiento</span>
        </span>
      </span>
      <span class="go" aria-hidden="true">→</span>
    </a>
  </div>
</section>

<!-- ═══════════ DÍA DE CAMPO ═══════════ -->
<section class="wrap" id="diadecampo">
  <div class="sec-head rv">
    <div>
      <h2>Así se vive un<br>día de campo Nidera</h2>
    </div>
    <p>Recorré la parcela como si estuvieras ahí: la demostración es donde
    la genética deja de ser promesa y pasa a ser evidencia.</p>
  </div>

  <div class="car rv">
    <div class="car-steps" id="carSteps">
      <div class="car-step on" data-i="0"><div class="num">01</div><div class="lbl">La recorrida</div></div>
      <div class="car-step" data-i="1"><div class="num">02</div><div class="lbl">Las espigas</div></div>
      <div class="car-step" data-i="2"><div class="num">03</div><div class="lbl">El detalle</div></div>
      <div class="car-step" data-i="3"><div class="num">04</div><div class="lbl">La semilla</div></div>
      <div class="car-step" data-i="4"><div class="num">05</div><div class="lbl">La cosecha</div></div>
    </div>
    <div class="rail" id="rail">
      <div class="rail-fill" id="railFill"></div>
    </div>

    <div class="car-track" id="carTrack">
      <article class="car-card">
        <div class="ph">
          <img id="srcGrupo" decoding="async" src="{{ asset('assets/images/nidera/v2/productores-recorriendo-la-parcela.jpg') }}" alt="Productores recorriendo la parcela de maíz Nidera junto al equipo técnico CIABAY">
          <div class="badges"><span class="badge green">01 · Recorrida</span></div>
        </div>
        <div class="body">
          <div class="m">Productores + técnicos CIABAY</div>
          <h4>La parcela se camina</h4>
          <p>Entre las filas, el equipo técnico explica el manejo, la densidad y el
          comportamiento del híbrido. Las preguntas se responden mirando la planta.</p>
        </div>
      </article>
      <article class="car-card">
        <div class="ph">
          <img src="{{ asset('assets/images/nidera/v2/espigas-de-maiz-nidera.jpg') }}" alt="Espigas de maíz Nidera expuestas en la parcela demostrativa">
          <div class="badges"><span class="badge green">02 · Espigas</span></div>
        </div>
        <div class="body">
          <div class="m">Evidencia a la vista</div>
          <h4>Las espigas al frente</h4>
          <p>Cada híbrido muestra sus espigas en el lote: uniformidad, tamaño y llenado
          se comparan uno al lado del otro, sin filtros.</p>
        </div>
      </article>
      <article class="car-card">
        <div class="ph">
          <img id="srcManos" decoding="async" src="{{ asset('assets/images/nidera/v2/productor-analizando-una-espiga.jpg') }}" alt="Productor analizando una espiga de maíz Nidera en sus manos">
          <div class="badges"><span class="badge green">03 · Detalle</span></div>
        </div>
        <div class="body">
          <div class="m">Grano por grano</div>
          <h4>El maíz se toca</h4>
          <p>El productor desgrana, pesa a ojo y saca sus propias conclusiones.
          La decisión de siembra empieza en la palma de la mano.</p>
        </div>
      </article>
      <article class="car-card">
        <div class="ph">
          <img id="srcBolsa" decoding="async" src="{{ asset('assets/images/nidera/v2/bolsa-de-semillas-de.jpg') }}" alt="Bolsa de semillas de maíz Nidera en el campo">
          <div class="badges"><span class="badge green">04 · Semilla</span></div>
        </div>
        <div class="body">
          <div class="m">De la parcela a tu chacra</div>
          <h4>La bolsa que sigue</h4>
          <p>Lo que convence en la demostración se reserva para la próxima campaña.
          Nidera Maíz, disponible en toda la red CIABAY.</p>
        </div>
      </article>
      <article class="car-card">
        <div class="ph">
          <img id="srcCosecha" decoding="async" src="{{ asset('assets/images/nidera/v2/productores-mostrando-granos-de.jpg') }}" alt="Productores mostrando granos de maíz NS 80 VIP 3 sobre la cosecha, junto al cartel CIABAY y Nidera Semillas">
          <div class="badges"><span class="badge green">05 · Cosecha</span></div>
        </div>
        <div class="body">
          <div class="m">El resultado final</div>
          <h4>El maíz que llena las manos</h4>
          <p>La campaña cierra con el carro lleno: el rinde que se vio en la parcela
          ahora se cosecha a manos llenas.</p>
        </div>
      </article>
    </div>

    <div class="car-ui">
      <button class="car-btn" id="carPrev" aria-label="Anterior">←</button>
      <div class="car-prog"><i id="carProgFill"></i></div>
      <button class="car-btn" id="carNext" aria-label="Siguiente">→</button>
    </div>
  </div>
</section>

<!-- ═══════════ REELS ═══════════ -->
<section class="wrap" id="reels">
  <div class="sec-head rv">
    <div>
      <h2>Del maizal<br>a tus redes</h2>
    </div>
    <p>El día de campo no termina en el lote: seguí las demostraciones,
    los resultados y el detrás de escena de Nidera Maíz en las redes de CIABAY.</p>
  </div>
  <div class="phones">
    <div class="phone-wrap rv">
      <div class="phone">
        <span class="b b-mute"></span><span class="b b-v1"></span><span class="b b-v2"></span><span class="b b-pow"></span>
        <div class="screen">
          <div class="fb" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="2.5" y="2.5" width="19" height="19" rx="5.5"/><circle cx="12" cy="12" r="4.4"/><circle cx="17.6" cy="6.4" r="1.1" fill="#8f9bb8" stroke="none"/></svg><span>Cargando reel<br>@@ciabaysa</span></div>
          <iframe src="https://www.instagram.com/reel/DaLTTAwjo-c/embed/" loading="lazy" scrolling="no" allowfullscreen allow="autoplay; encrypted-media; picture-in-picture; clipboard-write" title="Reel de Instagram — CIABAY Nidera 01"></iframe>
        </div>
      </div>
      <div class="phone-cap">Reel 01 · @@ciabaysa</div>
    </div>
    <div class="phone-wrap rv" style="transition-delay:.12s">
      <div class="phone">
        <span class="b b-mute"></span><span class="b b-v1"></span><span class="b b-v2"></span><span class="b b-pow"></span>
        <div class="screen">
          <div class="fb" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="2.5" y="2.5" width="19" height="19" rx="5.5"/><circle cx="12" cy="12" r="4.4"/><circle cx="17.6" cy="6.4" r="1.1" fill="#8f9bb8" stroke="none"/></svg><span>Cargando reel<br>@@ciabaysa</span></div>
          <iframe src="https://www.instagram.com/reel/DZZxxmjHUco/embed/" loading="lazy" scrolling="no" allowfullscreen allow="autoplay; encrypted-media; picture-in-picture; clipboard-write" title="Reel de Instagram — CIABAY Nidera 02"></iframe>
        </div>
      </div>
      <div class="phone-cap">Reel 02 · @@ciabaysa</div>
    </div>
    <div class="phone-wrap rv" style="transition-delay:.24s">
      <div class="phone">
        <span class="b b-mute"></span><span class="b b-v1"></span><span class="b b-v2"></span><span class="b b-pow"></span>
        <div class="screen">
          <div class="fb" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="2.5" y="2.5" width="19" height="19" rx="5.5"/><circle cx="12" cy="12" r="4.4"/><circle cx="17.6" cy="6.4" r="1.1" fill="#8f9bb8" stroke="none"/></svg><span>Cargando reel<br>@@ciabaysa</span></div>
          <iframe src="https://www.instagram.com/reel/DUYx7BIDHKV/embed/" loading="lazy" scrolling="no" allowfullscreen allow="autoplay; encrypted-media; picture-in-picture; clipboard-write" title="Reel de Instagram — CIABAY Nidera 03"></iframe>
        </div>
      </div>
      <div class="phone-cap">Reel 03 · @@ciabaysa</div>
    </div>
  </div>
  <div class="ig-more rv">
    <a href="https://www.instagram.com/ciabaysa/" target="_blank" rel="noopener">Ver más en Instagram ↗</a>
  </div>
</section>

<!-- ═══════════ CTA ═══════════ -->
<section class="wrap" id="contacto">
  <div class="cta rv">
    <div>
      <div class="kicker">El respaldo</div>
      <a class="phrase" href="https://wa.me/595983105077?text=%C2%A1Hola%21%20Quiero%20reservar%20semillas%20Nidera%20Ma%C3%ADz%20para%20la%20pr%C3%B3xima%20campa%C3%B1a." target="_blank" rel="noopener">
        Reservá tu <u>semilla</u> para la próxima campaña <em>con CIABAY</em>
      </a>
      <div class="foot">8 sucursales <i>·</i> Asesoramiento técnico <i>·</i> <svg class="wa-ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.149-.174.198-.298.297-.497.1-.198.05-.371-.025-.52-.074-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>WhatsApp directo +595 983 105 077</div>
    </div>
    <a class="cta-btn" href="https://wa.me/595983105077?text=%C2%A1Hola%21%20Quiero%20reservar%20semillas%20Nidera%20Ma%C3%ADz%20para%20la%20pr%C3%B3xima%20campa%C3%B1a." target="_blank" rel="noopener" aria-label="Reservar semilla por WhatsApp"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.149-.174.198-.298.297-.497.1-.198.05-.371-.025-.52-.074-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg></a>
  </div>
</section>
<!-- ═══════════ DETALLE DE PRODUCTO (overlay) ═══════════ -->
<div class="pd" id="pd" role="dialog" aria-modal="true" aria-label="Detalle de producto"></div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/nidera-page.js') }}"></script>
@endpush
