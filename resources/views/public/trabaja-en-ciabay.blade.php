{{--
    Plantilla "trabaja-en-ciabay" — hard-coded (origen: nuevo_trabaja_en_ciabay.html).
    Se activa con template='trabaja-en-ciabay' en la página (select "Template" del admin).
    CSS/JS en public/assets/ (trabaja-en-ciabay-page.css / trabaja-en-ciabay-page.js), scopeados
    bajo .trabaja-v2 — mismo esquema que la plantilla sucursales.
--}}
@extends('layouts.public')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,300..900&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/trabaja-en-ciabay-page.css') }}">
@endpush

@section('content')
<div class="trabaja-v2">
<!-- Retículas de globo decorativas -->
<svg class="globe tl" viewBox="0 0 480 480" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
  <circle cx="240" cy="240" r="230"/>
  <ellipse cx="240" cy="240" rx="230" ry="95"/>
  <ellipse cx="240" cy="240" rx="230" ry="170"/>
  <ellipse cx="240" cy="240" rx="95" ry="230"/>
  <ellipse cx="240" cy="240" rx="170" ry="230"/>
  <line x1="10" y1="240" x2="470" y2="240"/>
  <line x1="240" y1="10" x2="240" y2="470"/>
</svg>
<svg class="globe br" viewBox="0 0 480 480" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
  <circle cx="240" cy="240" r="230"/>
  <ellipse cx="240" cy="240" rx="230" ry="95"/>
  <ellipse cx="240" cy="240" rx="230" ry="170"/>
  <ellipse cx="240" cy="240" rx="95" ry="230"/>
  <ellipse cx="240" cy="240" rx="170" ry="230"/>
  <line x1="10" y1="240" x2="470" y2="240"/>
  <line x1="240" y1="10" x2="240" y2="470"/>
</svg>

<!-- ============ HERO ============ -->
<header class="hero">
  <div class="wrap">
    <div class="eyebrow rv">Trabajá con nosotros</div>
    <h1 class="rv" style="--d:80ms">Sé parte de la <span class="arc-word">familia<svg viewBox="0 0 300 60" preserveAspectRatio="none" aria-hidden="true"><path d="M14 48 Q150 12 286 42"/></svg></span> CIABAY</h1>
    <p class="sub rv" style="--d:160ms">En CIABAY <strong>el que entra, crece</strong>: capacitamos, acompañamos y <strong>promovemos a nuestra propia gente</strong>. Acá no venís a cumplir horario: venís a construir <strong>una carrera</strong>.</p>
  </div>
</header>

<!-- ============ CASOS DE ÉXITO ============ -->
<section id="casos">
  <div class="wrap">
    <div class="sec-head">
      <div class="rv">
        <div class="kicker">Casos de éxito</div>
        <h2>Acá se crece</h2>
      </div>
      <p class="side rv" style="--d:120ms">Historias reales de gente que empezó desde abajo y hoy lidera su área. En CIABAY la carrera se construye adentro, con oportunidades que se ganan trabajando.</p>
    </div>

    <div class="stories">
      <!-- Charles -->
      <article class="story rv">
        <div class="ph">
          <img src="{{ asset('assets/images/trabaja-en-ciabay/v2/charles-ortiz-asesor-de.jpg') }}" alt="Charles Ortiz, asesor de ventas de CIABAY, en un maizal">
          <div class="badges">
            <span class="badge">Insumos</span>
          </div>
          <div class="ph-name">Charles <em>Ortiz</em></div>
        </div>
        <div class="body">
          <div class="rol">Asesor de ventas · Insumos</div>
          <div class="ruta">
            <div class="step">
              <span class="dot"></span>
              <div><span class="lbl">Empezó como</span><strong>Asistente técnico de ventas</strong></div>
            </div>
            <div class="step now">
              <span class="dot"></span>
              <div><span class="lbl">Hoy</span><strong>Asesor de ventas</strong></div>
            </div>
          </div>
          <p>Entró como asistente técnico y hoy es <strong>uno de los asesores más posicionados de CIABAY en Insumos</strong>, acompañando a los productores en el campo, cosecha tras cosecha.</p>
          <div class="tags">
            <span class="tag">Ventas</span>
            <span class="tag">Campo</span>
            <span class="tag">Asesoramiento</span>
          </div>
        </div>
      </article>

      <!-- Marcos -->
      <article class="story rv" style="--d:90ms">
        <div class="ph">
          <img src="{{ asset('assets/images/trabaja-en-ciabay/v2/marcos-villalba-operando-el.jpg') }}" alt="Marcos Villalba operando el monitor de un tractor" style="object-position:64% 38%">
          <div class="badges">
            <span class="badge">Postventa</span>
          </div>
          <div class="ph-name">Marcos <em>Villalba</em></div>
        </div>
        <div class="body">
          <div class="rol">Mecánico · Asistencia a clientes</div>
          <div class="ruta">
            <div class="step">
              <span class="dot"></span>
              <div><span class="lbl">Empezó como</span><strong>Auxiliar de depósito</strong></div>
            </div>
            <div class="step now">
              <span class="dot"></span>
              <div><span class="lbl">Hoy</span><strong>Mecánico de asistencia</strong></div>
            </div>
          </div>
          <p>Arrancó en el depósito y hoy está <strong>al lado del cliente</strong>: donde hay una máquina que necesita asistencia, ahí está Marcos, con la tecnología en la mano.</p>
          <div class="tags">
            <span class="tag">Mecánica</span>
            <span class="tag">Asistencia</span>
            <span class="tag">Tecnología</span>
          </div>
        </div>
      </article>

      <!-- Isaías -->
      <article class="story rv" style="--d:180ms">
        <div class="ph">
          <img src="{{ asset('assets/images/trabaja-en-ciabay/v2/williams-gomez-frente-a.jpg') }}" alt="Williams Gómez frente a una cosechadora Case IH" style="object-position:46% 30%">
          <div class="badges">
            <span class="badge">Taller · Hernandarias</span>
          </div>
          <div class="ph-name">Williams <em>Gómez</em></div>
        </div>
        <div class="body">
          <div class="rol">Mecánico técnico · Case IH</div>
          <div class="ruta">
            <div class="step">
              <span class="dot"></span>
              <div><span class="lbl">Empezó como</span><strong>Auxiliar de mecánico</strong></div>
            </div>
            <div class="step now">
              <span class="dot"></span>
              <div><span class="lbl">Hoy</span><strong>Mecánico técnico Case IH</strong></div>
            </div>
          </div>
          <p>Inició como auxiliar de mecánico y hoy es <strong>mecánico técnico de Case IH</strong>, la marca líder que representamos, en la sucursal Hernandarias.</p>
          <div class="tags">
            <span class="tag">Case IH</span>
            <span class="tag">Hernandarias</span>
            <span class="tag">Técnico</span>
          </div>
        </div>
      </article>

      <!-- Camila -->
      <article class="story rv" style="--d:270ms">
        <div class="ph">
          <img src="{{ asset('assets/images/trabaja-en-ciabay/v2/camila-pereira-frente-a.jpg') }}" alt="Camila Pereira frente a la Puerta de Brandeburgo en Alemania" style="object-position:50% 34%">
          <div class="badges">
            <span class="badge">Marketing</span>
          </div>
          <div class="ph-name">Camila <em>Pereira</em></div>
        </div>
        <div class="body">
          <div class="rol">Analista de Marketing</div>
          <div class="ruta">
            <div class="step">
              <span class="dot"></span>
              <div><span class="lbl">Empezó como</span><strong>Auxiliar de marketing</strong></div>
            </div>
            <div class="step now">
              <span class="dot"></span>
              <div><span class="lbl">Hoy</span><strong>Analista de marketing</strong></div>
            </div>
          </div>
          <p>Arrancó como auxiliar y hoy es analista de Marketing. En 2025 cumplió <strong>un gran sueño: viajar a Alemania</strong>, con los colores de CIABAY puestos.</p>
          <div class="tags">
            <span class="tag">Marketing</span>
            <span class="tag">Análisis</span>
            <span class="tag">Alemania 2025</span>
          </div>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ============ POSTULÁ ============ -->
<section id="postular">
  <div class="wrap">
    <div class="cta-panel rv">
      <div class="kicker">Postulá</div>
      <h2>Tu historia puede ser <u>la próxima</u></h2>
      <p class="txt">Si querés crecer en el agro, trabajar con <strong>marcas líderes</strong> y formar parte de un equipo que te acompaña de verdad, mandanos tu currículum. <strong>Todas las historias de arriba empezaron con este paso.</strong></p>
      <div class="cta-actions">
        <a class="btn-cv" href="https://grupo.ciabay.com/index.php?class=VacanciasDisponibles&amp;method=onShow" target="_blank" rel="noopener">Enviá tu CV <span class="fl">→</span></a>
        <span class="cta-note"><b>Grupo CIABAY</b> · Portal de vacancias disponibles</span>
      </div>
    </div>
  </div>
</section>

<!-- ============ CLAIM ============ -->
<section id="forma">
  <div class="wrap">
    <div class="claim rv">
      <div class="kicker">Nuestra forma de trabajar</div>
      <div class="frase">Acá no se consigue <em>un empleo</em>. Se construye <u>una carrera</u>.</div>
      <div class="fin"><b>Promoción interna</b> · Capacitación continua · Marcas líderes · <b>Una familia</b></div>
    </div>
  </div>
</section>

<!-- ============ NUESTRA GENTE ============ -->
<section id="gente">
  <div class="wrap">
    <div class="sec-head">
      <div class="rv">
        <div class="kicker">Nuestra gente</div>
        <h2>Una sola camiseta</h2>
      </div>
      <p class="side rv" style="--d:120ms">Cerca de 300 personas en todo el país, con un promedio de edad de 37 años. Un equipo joven, con experiencia y con la camiseta bien puesta.</p>
    </div>

    <div class="collage">
      <div class="cell pic c-grupo rv">
        <img src="{{ asset('assets/images/trabaja-en-ciabay/v2/equipo-de-colaboradores-de.jpg') }}" alt="Equipo de colaboradores de CIABAY con la camiseta de Paraguay" style="object-position:50% 58%">
        <span class="badge">Equipo CIABAY</span>
        <div class="cap">Una sola <em>camiseta</em></div>
      </div>
      <div class="cell pic c-mujeres rv" style="--d:80ms">
        <img src="{{ asset('assets/images/trabaja-en-ciabay/v2/colaboradoras-de-ciabay-con.jpg') }}" alt="Colaboradoras de CIABAY con la albirroja frente al logo" style="object-position:50% 42%">
        <div class="cap">Albirroja <em>en la casa</em></div>
      </div>
      <div class="cell tcell c-claim rv" style="--d:160ms">
        <div class="tnum">±300</div>
        <div class="ttxt">Personas. <em>Una familia.</em></div>
        <div class="tmini">CIABAY · Paraguay</div>
      </div>
      <div class="cell pic c-oficina rv" style="--d:240ms">
        <img src="{{ asset('assets/images/trabaja-en-ciabay/v2/companeras-de-ciabay-en.jpg') }}" alt="Compañeras de CIABAY en la oficina" style="object-position:50% 26%">
      </div>
      <div class="cell pic c-cine rv" style="--d:120ms">
        <img src="{{ asset('assets/images/trabaja-en-ciabay/v2/colaboradores-de-ciabay-en.jpg') }}" alt="Colaboradores de CIABAY en una función de cine del equipo" style="object-position:50% 32%">
        <div class="cap">Momentos <em>juntos</em></div>
      </div>
      <div class="cell pic c-caseih rv" style="--d:200ms">
        <img src="{{ asset('assets/images/trabaja-en-ciabay/v2/equipo-de-postventa-de.jpg') }}" alt="Equipo de postventa de CIABAY frente a una cosechadora Case IH" style="object-position:50% 62%">
        <span class="badge">Postventa · Case IH</span>
      </div>
      <div class="cell pic c-evento rv" style="--d:280ms">
        <img src="{{ asset('assets/images/trabaja-en-ciabay/v2/grupo-de-colaboradores-de.jpg') }}" alt="Grupo de colaboradores de CIABAY en un evento del equipo" style="object-position:50% 38%">
      </div>
    </div>

    <div class="stats-band rv" style="--d:120ms">
      <div class="stat" tabindex="0">
        <div class="num"><span data-count="37">0</span> <em>años</em></div>
        <div class="lab">Edad promedio</div>
        <div class="tip">Un equipo joven y con experiencia: la edad promedio en CIABAY es de 37 años.</div>
      </div>
      <div class="stat" tabindex="0">
        <div class="num">±<span data-count="300">0</span></div>
        <div class="lab">Funcionarios</div>
        <div class="tip">Aproximadamente 300 personas forman parte de CIABAY en todo el Paraguay.</div>
      </div>
      <div class="stat" tabindex="0">
        <div class="num"><span data-count="1">0</span> <em>familia</em></div>
        <div class="lab">Una sola forma de trabajar</div>
        <div class="tip">Sucursales en todo el país, una sola forma de trabajar: como familia.</div>
      </div>
    </div>
  </div>
</section>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/trabaja-en-ciabay-page.js') }}"></script>
@endpush
