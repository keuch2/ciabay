{{--
    Plantilla "repuestos" — hard-coded (origen: nuevo_repuestos.html).
    Se activa con template='repuestos' en la página (select "Template" del admin).
    CSS/JS en public/assets/ (repuestos-page.css / repuestos-page.js), scopeados
    bajo .repuestos-v2 — mismo esquema que la plantilla sucursales.
--}}
@extends('layouts.public')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,300..900&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/repuestos-page.css') }}">
@endpush

@section('content')
<div class="repuestos-v2">
<div class="globe tl" aria-hidden="true">
  <svg viewBox="0 0 480 480" xmlns="http://www.w3.org/2000/svg">
    <g fill="none" stroke="currentColor" stroke-width="1.4">
      <circle cx="240" cy="240" r="230"/>
      <ellipse cx="240" cy="240" rx="230" ry="95"/>
      <ellipse cx="240" cy="240" rx="230" ry="170"/>
      <ellipse cx="240" cy="240" rx="95" ry="230"/>
      <ellipse cx="240" cy="240" rx="170" ry="230"/>
      <line x1="10" y1="240" x2="470" y2="240"/>
      <line x1="240" y1="10" x2="240" y2="470"/>
    </g>
  </svg>
</div>
<div class="globe br" aria-hidden="true">
  <svg viewBox="0 0 480 480" xmlns="http://www.w3.org/2000/svg">
    <g fill="none" stroke="currentColor" stroke-width="1.4">
      <circle cx="240" cy="240" r="230"/>
      <ellipse cx="240" cy="240" rx="230" ry="95"/>
      <ellipse cx="240" cy="240" rx="230" ry="170"/>
      <ellipse cx="240" cy="240" rx="95" ry="230"/>
      <ellipse cx="240" cy="240" rx="170" ry="230"/>
      <line x1="10" y1="240" x2="470" y2="240"/>
      <line x1="240" y1="10" x2="240" y2="470"/>
    </g>
  </svg>
</div>

<main>

  <!-- ============ BUSCADOR ONLINE ============ -->
  <section class="first" id="buscador">
    <div class="wrap">
      <div class="sec-head rv">
        <div>
          <div class="kicker"><i>—</i>BUSCADOR ONLINE</div>
          <h2>BUSCÁ TU REPUESTO,<br>LAS 24 HORAS.</h2>
        </div>
        <p class="sec-sub">Escribí el código o el nombre de la pieza y consultá <strong>disponibilidad en tiempo real</strong>, desde el celular o la computadora, a cualquier hora.</p>
      </div>

      <div class="buscador rv">
        <div class="busc-photo">
          <img src="{{ asset('assets/images/repuestos/v2/deposito-de-repuestos-de.jpg') }}" alt="Depósito de repuestos de CIABAY con estanterías de piezas clasificadas">
          <div class="badges"><span class="badge">DEPÓSITO · REPUESTOS</span></div>
          <div class="floating-24h" aria-hidden="true">
            <div class="clock-spin">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="8"></circle>
                <path d="M12 7.5v5l3 2"></path>
              </svg>
            </div>
            <div class="clock-copy">
              <small>DISPONIBLE</small>
              <strong>24 HORAS</strong>
            </div>
          </div>
          <div class="ph-cap">STOCK <em>REAL</em>, TODOS LOS DÍAS</div>
        </div>
        <div class="busc-body">
          <div class="busc-top">
            <span class="micro"><i>—</i> VISTA DEMOSTRATIVA DEL BUSCADOR</span>
            <span class="micro live"><b></b>ONLINE 24/7</span>
          </div>
          <div class="busc-bar" role="presentation">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.3" y2="16.3"/></svg>
            <span class="busc-q" id="typeQ"></span><span class="caret" id="typeCaret"></span>
            <span class="busc-btn">Buscar</span>
          </div>
          <div class="busc-cta">
            <a class="btn open-iframe" href="#iframeRepuesto" data-open-iframe aria-controls="iframeRepuesto" aria-expanded="false"><span data-btn-label>Abrir el buscador online</span> <span aria-hidden="true">→</span></a>
            <span class="micro">GRUPO.CIABAY.COM <i>·</i> DISPONIBLE LAS 24 HORAS <i>·</i> RETIRO EN SUCURSAL</span>
          </div>
          <div class="busc-table" aria-live="polite">
            <div class="bt-row bt-head">
              <span>Código</span><span class="fab">Fabricante</span><span>Descripción</span><span>Disponibilidad</span>
            </div>
            <div id="btBody"></div>
          </div>
        </div>
      </div>

      <div id="iframeRepuesto" class="iframe-repuesto-panel rv" aria-hidden="true">
        <div class="iframe-repuesto-head">
          <div class="iframe-repuesto-title">
            <div class="iframe-repuesto-icon" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="7"></circle>
                <path d="M20 20l-4.5-4.5"></path>
                <path d="M8.5 11h5"></path>
                <path d="M11 8.5v5"></path>
              </svg>
            </div>
            <div>
              <strong>Buscador online de repuestos</strong>
              <span>Consulta directa en <i>grupo.ciabay.com</i></span>
            </div>
          </div>
          <div class="iframe-repuesto-actions">
            <span class="iframe-repuesto-live"><b></b>Online 24/7</span>
            <button class="iframe-close" type="button" data-close-iframe aria-label="Cerrar buscador">×</button>
          </div>
        </div>
        <div class="iframe-shell">
          <iframe src="https://grupo.ciabay.com/index.php?class=BuscaRepuesto&method=onShow" style="border:none;" title="Busque su repuesto" loading="lazy"></iframe>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ CTA ============ -->
  <section class="cont" id="contacto">
    <div class="wrap">
      <div class="cta-panel rv">
        <div class="kicker"><i>—</i>EMPEZÁ AHORA</div>
        <h2>¿NECESITÁS UN REPUESTO?</h2>
        <p>Buscalo online o pasá por tu sucursal más cercana: nuestro equipo te ayuda a encontrar el código exacto para tu máquina.</p>
        <div class="cta-btns">
          <button class="btn contact-toggle" type="button" data-contact-toggle aria-controls="contactTable" aria-expanded="false">Buscar mi vendedor <span aria-hidden="true">→</span></button>
          <a class="btn ghost" href="{{ url('sucursales') }}">Ver sucursales</a>
        </div>
        <div id="contactTable" class="contact-table-panel" aria-hidden="true">
          <div class="contact-table-head">
            <strong>Contactos de vendedores por sucursal</strong>
            <span>CIABAY · WhatsApp directo</span>
          </div>
          <table class="contact-table">
            <thead>
              <tr>
                <th>Sucursal</th>
                <th>Funcionario CIABAY</th>
                <th>Contacto</th>
              </tr>
            </thead>
            <tbody>
              <tr><td>Matriz Hernandarias</td><td>Cesar Sotelo</td><td><span class="contact-actions"><a class="contact-phone" href="tel:+595983912225">(0983) 912 225</a><a class="whatsapp-btn" href="https://wa.me/595983912225" target="_blank" rel="noopener">WhatsApp</a></span></td></tr>
              <tr><td>Sucursal San Alberto</td><td>Rafael Toguetto</td><td><span class="contact-actions"><a class="contact-phone" href="tel:+595987196005">(0987) 196 005</a><a class="whatsapp-btn" href="https://wa.me/595987196005" target="_blank" rel="noopener">WhatsApp</a></span></td></tr>
              <tr><td>Sucursal Katuete</td><td>Adenilson Dutra</td><td><span class="contact-actions"><a class="contact-phone" href="tel:+595983637194">(0983) 637 194</a><a class="whatsapp-btn" href="https://wa.me/595983637194" target="_blank" rel="noopener">WhatsApp</a></span></td></tr>
              <tr><td>Sucursal Loma Plata</td><td>Daniel Bogado</td><td><span class="contact-actions"><a class="contact-phone" href="tel:+595985708272">(0985) 708 272</a><a class="whatsapp-btn" href="https://wa.me/595985708272" target="_blank" rel="noopener">WhatsApp</a></span></td></tr>
              <tr><td>Sucursal Rio Verde</td><td>Alberto Rios</td><td><span class="contact-actions"><a class="contact-phone" href="tel:+595986421487">(0986) 421 487</a><a class="whatsapp-btn" href="https://wa.me/595986421487" target="_blank" rel="noopener">WhatsApp</a></span></td></tr>
              <tr><td>Sucursal Campo 9</td><td>Junior</td><td><span class="contact-actions"><a class="contact-phone" href="tel:+595975486902">(0975) 486 902</a><a class="whatsapp-btn" href="https://wa.me/595975486902" target="_blank" rel="noopener">WhatsApp</a></span></td></tr>
              <tr><td>Sucursal Santa Rita</td><td>Carlos Cattani</td><td><span class="contact-actions"><a class="contact-phone" href="tel:+595986164577">0986 164 577</a><a class="whatsapp-btn" href="https://wa.me/595986164577" target="_blank" rel="noopener">WhatsApp</a></span></td></tr>
              <tr><td>Sucursal Bella Vista</td><td>Romelio</td><td><span class="contact-actions"><a class="contact-phone" href="tel:+595985112520">(0985) 112 520</a><a class="whatsapp-btn" href="https://wa.me/595985112520" target="_blank" rel="noopener">WhatsApp</a></span></td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ STATS ============ -->
  <section id="respaldo">
    <div class="wrap">
      <div class="sec-head rv">
        <div>
          <div class="kicker"><i>—</i>POR QUÉ CIABAY</div>
          <h2>RESPALDO QUE<br>SE NOTA.</h2>
        </div>
        <p class="sec-sub">Detrás de cada pieza hay una <strong>red nacional</strong> de depósitos, mostradores y técnicos que conocen tu máquina. Tocá cada número para saber más.</p>
      </div>

      <div class="stats rv">
        <div class="stats-grid">
          <div class="stat" tabindex="0">
            <div class="stat-n"><span class="cnt" data-n="24">0</span><em>hs</em></div>
            <div class="stat-l">Buscador online<br>disponible</div>
            <div class="tip">Consultá códigos, descripciones y disponibilidad en cualquier momento, desde donde estés.</div>
          </div>
          <div class="stat" tabindex="0">
            <div class="stat-n"><span class="cnt" data-n="100">0</span><em>%</em></div>
            <div class="stat-l">Repuestos<br>originales</div>
            <div class="tip">Piezas con garantía de fábrica de CNH Industrial y marcas aliadas como Timken y Tatu.</div>
          </div>
          <div class="stat" tabindex="0">
            <div class="stat-n"><span class="cnt" data-n="8">0</span></div>
            <div class="stat-l">Sucursales con<br>repuestos y servicios</div>
            <div class="tip">Retirá tu pedido en la sucursal que te quede más cerca, en todo el país.</div>
          </div>
          <div class="stat" tabindex="0">
            <div class="stat-n"><em>+</em><span class="cnt" data-n="31">0</span></div>
            <div class="stat-l">Años junto<br>al productor</div>
            <div class="tip">Más de tres décadas acompañando cada etapa del cultivo en Paraguay.</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ COLLAGE ============ -->
  <section id="equipo">
    <div class="wrap">
      <div class="sec-head rv">
        <div>
          <div class="kicker"><i>—</i>EQUIPO POST VENTA</div>
          <h2>GENTE QUE CONOCE<br>TU MÁQUINA.</h2>
        </div>
        <p class="sec-sub">Del mostrador al taller: te ayudamos a encontrar el <strong>código exacto</strong> y a instalarlo bien la primera vez.</p>
      </div>

      <div class="collage" data-stagger>
        <div class="cell c-2x2 rv">
          <img src="{{ asset('assets/images/repuestos/v2/mecanico-de-ciabay-con.jpg') }}" alt="Mecánico de CIABAY con uniforme rojo sosteniendo filtros en el taller de servicios Case IH">
          <div class="badges"><span class="badge">TALLER · SERVICIOS</span></div>
          <div class="cap">ASESORAMIENTO <em>TÉCNICO</em> EN CADA SUCURSAL</div>
        </div>
        <div class="cell c-1x2 rv">
          <img src="{{ asset('assets/images/repuestos/v2/colaborador-de-repuestos-ciabay.jpg') }}" alt="Colaborador de repuestos CIABAY con un filtro CNH en la mano">
          <div class="badges"><span class="badge">FILTROS CNH</span></div>
          <div class="cap">PROTECCIÓN <em>ORIGINAL</em></div>
        </div>
        <div class="cell rv">
          <img src="{{ asset('assets/images/repuestos/v2/bidones-de-lubricante-akcela.jpg') }}" alt="Bidones de lubricante Akcela de 20 litros apilados">
          <div class="badges"><span class="badge">AKCELA</span></div>
        </div>
        <div class="cell accent rv">
          <div class="big">24<span style="font-size:.5em">HS</span></div>
          <div class="txt">Consultá stock online</div>
          <div class="mic">CÓDIGOS · PRECIOS · DISPONIBILIDAD</div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ CLAIM ============ -->
  <section id="claim">
    <div class="wrap">
      <div class="claim rv">
        <div class="kicker"><i>—</i>COMPROMISO POST VENTA</div>
        <div class="frase">SI EL CAMPO <em>NO PARA</em>, TU MÁQUINA <u>TAMPOCO</u>.</div>
        <div class="fin">ORIGINALES <i>·</i> STOCK REAL <i>·</i> EN TODO EL PAÍS</div>
      </div>
    </div>
  </section>

  <!-- ============ LÍNEAS PRINCIPALES ============ -->
  <section id="lineas">
    <div class="wrap">
      <div class="sec-head rv">
        <div>
          <div class="kicker"><i>—</i>LÍNEAS PRINCIPALES</div>
          <h2>TODO LO QUE<br>TU MÁQUINA PIDE.</h2>
        </div>
        <p class="sec-sub">Cuatro líneas con <strong>condiciones especiales</strong>, elegidas para el trabajo real del campo paraguayo. Deslizá para recorrerlas.</p>
      </div>

      <div class="car rv">
        <div class="rail" aria-hidden="true">
          <div class="rail-fill" id="railFill"></div>
        </div>
        <div class="track" id="track">

          <div class="slide">
            <div class="sl-head"><span class="sl-num">01</span><span class="sl-tagline">TIMKEN BELTS</span></div>
            <article class="card">
              <div class="card-photo">
                <img src="{{ asset('assets/images/repuestos/v2/tecnico-de-ciabay-revisando.jpg') }}" alt="Técnico de CIABAY revisando las correas de una cosechadora Case IH">
                <div class="badges"><span class="badge green">CONDICIONES ESPECIALES</span></div>
              </div>
              <div class="card-body">
                <h3>Correas Timken</h3>
                <p>Correas con condiciones especiales para mantener tu maquinaria trabajando con mayor seguridad y eficiencia, campaña tras campaña.</p>
                <div class="tags"><span class="tag">Transmisión</span><span class="tag">Cosechadoras</span><span class="tag">Tractores</span></div>
              </div>
            </article>
          </div>

          <div class="slide">
            <div class="sl-head"><span class="sl-num">02</span><span class="sl-tagline">AKCELA · 20L</span></div>
            <article class="card">
              <div class="card-photo">
                <img src="{{ asset('assets/images/repuestos/v2/bidones-de-lubricante-akcela-2.jpg') }}" alt="Bidones de lubricante Akcela de 20 litros junto a cajas CNH Genuine Parts frente a un tractor Case IH">
                <div class="badges"><span class="badge">ORIGINALES CNH</span></div>
              </div>
              <div class="card-body">
                <h3>Lubricantes Akcela</h3>
                <p>Lubricantes originales con beneficios exclusivos para cuidar el rendimiento y prolongar la vida útil de tus maquinarias.</p>
                <div class="tags"><span class="tag">Motor</span><span class="tag">Hidráulico</span><span class="tag">Transmisión</span></div>
              </div>
            </article>
          </div>

          <div class="slide">
            <div class="sl-head"><span class="sl-num">03</span><span class="sl-tagline">CNH GENUINE PARTS</span></div>
            <article class="card">
              <div class="card-photo">
                <img src="{{ asset('assets/images/repuestos/v2/colaborador-de-ciabay-mostrando.jpg') }}" alt="Colaborador de CIABAY mostrando un filtro CNH Genuine Parts frente a un tractor Case IH rojo">
                <div class="badges"><span class="badge green">PROMOCIONES</span></div>
              </div>
              <div class="card-body">
                <h3>Filtros CNH</h3>
                <p>Filtros CNH con promociones especiales para asegurar mayor protección, limpieza y desempeño en cada jornada.</p>
                <div class="tags"><span class="tag">Aceite</span><span class="tag">Combustible</span><span class="tag">Aire</span></div>
              </div>
            </article>
          </div>

          <div class="slide">
            <div class="sl-head"><span class="sl-num">04</span><span class="sl-tagline">IMPLEMENTOS</span></div>
            <article class="card">
              <div class="card-photo">
                <img src="{{ asset('assets/images/repuestos/v2/mascota-tatu-sosteniendo-un.jpg') }}" alt="Mascota Tatu sosteniendo un disco de sembradora frente a una plantadora">
                <div class="badges"><span class="badge green">CONDICIONES PROMOCIONALES</span></div>
              </div>
              <div class="card-body">
                <h3>Discos</h3>
                <p>Condiciones promocionales para mejorar el rendimiento de tus implementos en el campo, con el disco justo para cada suelo.</p>
                <div class="tags"><span class="tag">Sembradoras</span><span class="tag">Tatu</span><span class="tag">Vence Tudo</span></div>
              </div>
            </article>
          </div>

        </div>
        <div class="car-controls">
          <button class="car-arrow" id="prevBtn" aria-label="Línea anterior">←</button>
          <button class="car-arrow" id="nextBtn" aria-label="Línea siguiente">→</button>
          <div class="car-progress" aria-hidden="true"><i id="carFill"></i></div>
        </div>
      </div>
    </div>
  </section>

</main>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/repuestos-page.js') }}"></script>
@endpush
