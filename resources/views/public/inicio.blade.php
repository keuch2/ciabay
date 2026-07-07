{{--
    Plantilla "inicio" — hard-coded (origen: nuevo_home.html).
    Se activa con template='inicio' en la página (select "Template" del admin).
    CSS/JS en public/assets/ (inicio-page.css / inicio-page.js), scopeados
    bajo .inicio-v2 — mismo esquema que la plantilla sucursales.
--}}
@extends('layouts.public')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,300..900&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/inicio-page.css') }}">
@endpush

@section('content')
<div class="inicio-v2">
<svg class="globe g-tl" viewBox="0 0 480 480" aria-hidden="true">
  <g fill="none" stroke="currentColor" stroke-width="1.6">
    <circle cx="240" cy="240" r="230"/>
    <ellipse cx="240" cy="240" rx="230" ry="95"/>
    <ellipse cx="240" cy="240" rx="230" ry="170"/>
    <ellipse cx="240" cy="240" rx="95" ry="230"/>
    <ellipse cx="240" cy="240" rx="170" ry="230"/>
    <line x1="10" y1="240" x2="470" y2="240"/>
    <line x1="240" y1="10" x2="240" y2="470"/>
  </g>
</svg>
<svg class="globe g-br" viewBox="0 0 480 480" aria-hidden="true">
  <g fill="none" stroke="currentColor" stroke-width="1.6">
    <circle cx="240" cy="240" r="230"/>
    <ellipse cx="240" cy="240" rx="230" ry="95"/>
    <ellipse cx="240" cy="240" rx="230" ry="170"/>
    <ellipse cx="240" cy="240" rx="95" ry="230"/>
    <ellipse cx="240" cy="240" rx="170" ry="230"/>
    <line x1="10" y1="240" x2="470" y2="240"/>
    <line x1="240" y1="10" x2="240" y2="470"/>
  </g>
</svg>


<main>

  <h1 class="sr-only">CIABAY — Agricultura en buenas manos</h1>

  <!-- ===== VITRINA DE PREMIOS ===== -->
  <section class="vitrina" id="premios" aria-label="Premios y reconocimientos">
    <div class="vitrina-grid">
      <figure class="rev" style="transition-delay:.0s">
        <div class="v-photo"><img src="{{ asset('assets/images/inicio/v2/trofeo-world-class-dealer.jpg') }}" alt="Trofeo World Class Dealer 2025 de Case IH otorgado a CIABAY"></div>
        <figcaption>Importadores de clase Mundial WCD 2025.</figcaption>
      </figure>
      <figure class="rev" style="transition-delay:.08s">
        <div class="v-photo"><img src="{{ asset('assets/images/inicio/v2/trofeo-performance-nps-2025.jpg') }}" alt="Trofeo Performance NPS 2025 de Case IH otorgado a CIABAY"></div>
        <figcaption>Líder entre importadores Latinoamérica de Case IH en Performance NPS.</figcaption>
      </figure>
      <figure class="rev" style="transition-delay:.16s">
        <div class="v-photo"><img src="{{ asset('assets/images/inicio/v2/trofeo-performance-pulverizadores-2025.jpg') }}" alt="Trofeo Performance Pulverizadores 2025 de Case IH otorgado a CIABAY"></div>
        <figcaption>Líder entre importadores Latinoamérica de Case IH en Pulverizadores.</figcaption>
      </figure>
      <figure class="rev" style="transition-delay:.24s">
        <div class="v-photo"><img src="{{ asset('assets/images/inicio/v2/trofeo-petronas-experience-2025.jpg') }}" alt="Trofeo Petronas Experience 2025 otorgado a CIABAY"></div>
        <figcaption>Líder entre importadores Latinoamérica de Case IH en Lubricantes.</figcaption>
      </figure>
    </div>
  </section>

  <!-- ===== UNIDADES DE NEGOCIO ===== -->
  <section class="sec" id="unidades">
    <div class="wrap">
      <div class="sec-head rev">
        <div>
          <div class="kicker">Unidades de negocio</div>
          <h2>Una empresa, cuatro unidades</h2>
        </div>
        <p>Del insumo que arranca la zafra al repuesto que la mantiene en marcha: todo el ciclo productivo en un solo lugar.</p>
      </div>
      <div class="swipe-hint" aria-hidden="true">Deslizá para ver las unidades <em>→</em></div>
      <div class="units rev">
        <article class="unit" tabindex="0">
          <img src="{{ asset('assets/images/inicio/v2/espigas-de-maiz-maduras.jpg') }}" alt="Espigas de maíz maduras en el campo" loading="lazy">
          <div class="u-body">
            <span class="u-num">01 / 04</span>
            <h3>Insumos</h3>
            <div class="u-desc">
              <p>Semillas, protección y nutrición de cultivos: el punto de partida de cada zafra.</p>
              <div class="u-tags"><span class="badge">Semillas</span><span class="badge">Protección</span><span class="badge">Nutrición</span></div>
            </div>
          </div>
        </article>
        <article class="unit" tabindex="0">
          <img src="{{ asset('assets/images/inicio/v2/linea-de-tractores-case.jpg') }}" alt="Línea de tractores Case IH Puma en la sucursal CIABAY" loading="lazy">
          <div class="u-body">
            <span class="u-num">02 / 04</span>
            <h3>Máquinas</h3>
            <div class="u-desc">
              <p>La línea completa de Case IH: tractores, cosechadoras, pulverizadores y agricultura de precisión.</p>
              <div class="u-tags"><span class="badge">Case IH</span><span class="badge">Tractores</span><span class="badge">Cosechadoras</span></div>
            </div>
          </div>
        </article>
        <article class="unit" tabindex="0">
          <img src="{{ asset('assets/images/inicio/v2/sembradora-vence-tudo-pampeana.jpg') }}" alt="Sembradora Vence Tudo Pampeana 24000 trabajando en el campo" loading="lazy">
          <div class="u-body">
            <span class="u-num">03 / 04</span>
            <h3>Implementos</h3>
            <div class="u-desc">
              <p>Sembradoras y equipos Vence Tudo para una siembra precisa en cualquier condición de suelo.</p>
              <div class="u-tags"><span class="badge">Vence Tudo</span><span class="badge">Sembradoras</span><span class="badge">Plantío</span></div>
            </div>
          </div>
        </article>
        <article class="unit" tabindex="0">
          <img src="{{ asset('assets/images/inicio/v2/tecnico-de-post-venta.jpg') }}" alt="Técnico de post venta CIABAY con repuesto original CNH frente a un tractor Case IH" loading="lazy" style="object-position:50% 20%">
          <div class="u-body">
            <span class="u-num">04 / 04</span>
            <h3>Post Ventas</h3>
            <div class="u-desc">
              <p>Repuestos originales, lubricantes y un equipo técnico que llega hasta donde está el productor.</p>
              <div class="u-tags"><span class="badge">Repuestos</span><span class="badge">Servicio técnico</span><span class="badge">Lubricantes</span></div>
            </div>
          </div>
        </article>
      </div>
    </div>
  </section>


  <!-- ===== SUCURSALES / MAPA ===== -->
  <section class="sec" id="sucursales">
    <div class="wrap">
      <div class="sec-head rev">
        <div>
          <div class="kicker">Sucursales</div>
          <h2>Cada vez más cerca tuyo</h2>
        </div>
        <p>Nuestras 8 sucursales estratégicamente distribuidas para brindarte toda la asistencia al campo.</p>
      </div>
      <div class="map-panel panel-tex rev">
        <div class="map-left">
          <svg id="mapa" viewBox="0 0 620 680" role="group" aria-label="Mapa de Paraguay con las sucursales CIABAY"></svg>
          <div class="map-legend">
            <span><i class="c1"></i> Departamento con sucursal</span>
            <span><i class="c2"></i> Sucursal</span>
            <span><i class="c3"></i> Casa Matriz</span>
          </div>
        </div>
        <div class="map-right">
          <div class="map-k" id="mapk">Red CIABAY · 8 puntos</div>
          <div class="map-t">De punta a punta del Paraguay</div>
          <div class="suc-list" id="suclist" aria-live="polite"></div>
          <button class="suc-reset" id="sucreset" type="button">✕ Mostrar las 8 sucursales</button>
          <br>
          <a class="map-cta" href="{{ url('sucursales') }}">Ver todas las sucursales <span aria-hidden="true">→</span></a>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== REDES SOCIALES ===== -->
  <section class="social" id="redes" aria-label="Redes sociales de CIABAY">
    <div class="social-big" aria-hidden="true">&#64;ciabaysa</div>
    <div class="wrap">
      <div class="sec-head rev">
        <div>
          <div class="kicker">Redes sociales</div>
          <h2>Seguinos donde está el campo</h2>
        </div>
        <p>Días de campo, entregas, tecnología y el detrás de escena de CIABAY, todos los días en nuestras redes.</p>
      </div>
      <div class="swipe-hint" aria-hidden="true">Deslizá para ver las redes <em>→</em></div>
      <div class="phones">
        <a class="phone rev" style="transition-delay:.0s" href="https://www.instagram.com/ciabaysa/" target="_blank" rel="noopener" aria-label="Instagram de CIABAY — &#64;ciabaysa">
          <span class="pframe"><span class="pscreen scr-ig">
            <span class="ig-top">
              <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2"><rect x="2.5" y="2.5" width="19" height="19" rx="5.5"/><circle cx="12" cy="12" r="4.4"/><circle cx="17.6" cy="6.4" r="1.3" fill="currentColor" stroke="none"/></svg>
              <b>Instagram</b>
            </span>
            <span class="ig-head">
              <span class="ig-ring"><span class="p-ava"><img src="{{ asset('assets/images/inicio/v2/img-09.png') }}" alt=""></span></span>
              <span class="ig-id"><b>ciabaysa</b><small>Fram, Itapúa</small></span>
            </span>
            <img class="ig-img" src="{{ asset('assets/images/inicio/v2/post-de-instagram-dia.jpg') }}" alt="Post de Instagram: día de campo de la nueva Patriot Serie S50 en Fram, Itapúa">
            <span class="ig-acts">
              <svg class="hrt" viewBox="0 0 24 24"><path d="M12 21s-7-4.6-9.5-8.8C.6 8.6 2.6 4.9 6.3 4.9c2.2 0 3.8 1.2 4.7 2.6.4.6 1.6.6 2 0 .9-1.4 2.5-2.6 4.7-2.6 3.7 0 5.7 3.7 3.8 7.3C19 16.4 12 21 12 21z"/></svg>
              <svg viewBox="0 0 24 24"><path d="M21 11.5c0 4.4-4 8-9 8-1.1 0-2.2-.2-3.2-.5L3 21l1.6-4.3C3.6 15.3 3 13.5 3 11.5c0-4.4 4-8 9-8s9 3.6 9 8z"/></svg>
              <svg viewBox="0 0 24 24"><path d="M22 2 11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
              <svg class="right" viewBox="0 0 24 24"><path d="M19 21l-7-5-7 5V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v17z"/></svg>
            </span>
            <span class="ig-likes">1.284 Me gusta</span>
          </span></span>
          <span class="plabel">Instagram ↗</span>
        </a>
        <a class="phone rev" style="transition-delay:.08s" href="https://www.facebook.com/ciabaysa" target="_blank" rel="noopener" aria-label="Facebook de CIABAY">
          <span class="pframe"><span class="pscreen scr-fb">
            <span class="fb-top"><b>facebook</b></span>
            <span class="fb-card">
              <span class="fb-head">
                <span class="p-ava"><img src="{{ asset('assets/images/inicio/v2/img-09.png') }}" alt=""></span>
                <span class="fb-id"><b>CIABAY S.A.</b><small>Día de campo · Santa Fé, Alto Paraná</small></span>
              </span>
              <img class="fb-img" src="{{ asset('assets/images/inicio/v2/publicacion-de-facebook-dia.jpg') }}" alt="Publicación de Facebook: día de campo Familia Teixeira en Santa Fé, Alto Paraná">
              <span class="fb-acts">
                <span><svg viewBox="0 0 24 24"><path d="M7 22V11L12 2c1.5 0 2.5 1.2 2.5 2.7V9H20c1.3 0 2.3 1.2 2 2.5l-1.6 8A2.5 2.5 0 0 1 18 22H7zM3 11h4v11H3z"/></svg> Me gusta</span>
                <span><svg viewBox="0 0 24 24"><path d="M21 11.5c0 4.4-4 8-9 8-1.1 0-2.2-.2-3.2-.5L3 21l1.6-4.3C3.6 15.3 3 13.5 3 11.5c0-4.4 4-8 9-8s9 3.6 9 8z"/></svg> Comentar</span>
                <span><svg viewBox="0 0 24 24"><path d="M22 2 11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg> Compartir</span>
              </span>
              <span class="fb-follow">Seguir página</span>
            </span>
          </span></span>
          <span class="plabel">Facebook ↗</span>
        </a>
        <a class="phone rev" style="transition-delay:.16s" href="https://www.youtube.com/&#64;ciabay756" target="_blank" rel="noopener" aria-label="YouTube de CIABAY">
          <span class="pframe"><span class="pscreen scr-ys">
            <img class="ys-img" src="{{ asset('assets/images/inicio/v2/youtube-shorts-dia-de.jpg') }}" alt="YouTube Shorts: día de campo Estancia Monte Alegre en Capitán Bado, Amambay, con la bandera paraguaya">
            <span class="ys-top"><span class="yt-glyph"></span><b>Shorts</b></span>
            <span class="tt-side">
              <span><svg viewBox="0 0 24 24"><path d="M12 21s-7-4.6-9.5-8.8C.6 8.6 2.6 4.9 6.3 4.9c2.2 0 3.8 1.2 4.7 2.6.4.6 1.6.6 2 0 .9-1.4 2.5-2.6 4.7-2.6 3.7 0 5.7 3.7 3.8 7.3C19 16.4 12 21 12 21z"/></svg>8,7K</span>
              <span><svg viewBox="0 0 24 24"><path d="M21 11.5c0 4.4-4 8-9 8-1.1 0-2.2-.2-3.2-.5L3 21l1.6-4.3C3.6 15.3 3 13.5 3 11.5c0-4.4 4-8 9-8s9 3.6 9 8z"/></svg>96</span>
              <span><svg viewBox="0 0 24 24"><path d="M13 5.5 21 12l-8 6.5v-4C7 14.5 4.5 16.5 3 19.5c0-6 3-10 10-10.5v-3.5z"/></svg>58</span>
            </span>
            <span class="ys-cap">
              <b>Día de campo Estancia Monte Alegre 🇵🇾</b>
              <small>Capitán Bado · Amambay</small>
              <span class="ys-ch"><span class="p-ava"><img src="{{ asset('assets/images/inicio/v2/img-09.png') }}" alt=""></span><b>&#64;ciabaysa</b><span class="yt-sub">Suscribirse</span></span>
            </span>
          </span></span>
          <span class="plabel">YouTube ↗</span>
        </a>
        <a class="phone rev" style="transition-delay:.24s" href="https://www.tiktok.com/&#64;ciabaysa?_r=1&amp;_t=ZS-97l1SZxlfwC" target="_blank" rel="noopener" aria-label="TikTok de CIABAY — &#64;ciabaysa">
          <span class="pframe"><span class="pscreen scr-tt">
            <img class="tt-img" src="{{ asset('assets/images/inicio/v2/tiktok-espigas-de-maiz.jpg') }}" alt="TikTok: espigas de maíz en una parcela demostrativa">
            <span class="tt-tabs">Siguiendo <b>Para ti</b></span>
            <span class="tt-side">
              <span><svg viewBox="0 0 24 24"><path d="M12 21s-7-4.6-9.5-8.8C.6 8.6 2.6 4.9 6.3 4.9c2.2 0 3.8 1.2 4.7 2.6.4.6 1.6.6 2 0 .9-1.4 2.5-2.6 4.7-2.6 3.7 0 5.7 3.7 3.8 7.3C19 16.4 12 21 12 21z"/></svg>12,4K</span>
              <span><svg viewBox="0 0 24 24"><path d="M21 11.5c0 4.4-4 8-9 8-1.1 0-2.2-.2-3.2-.5L3 21l1.6-4.3C3.6 15.3 3 13.5 3 11.5c0-4.4 4-8 9-8s9 3.6 9 8z"/></svg>214</span>
              <span><svg viewBox="0 0 24 24"><path d="M13 5.5 21 12l-8 6.5v-4C7 14.5 4.5 16.5 3 19.5c0-6 3-10 10-10.5v-3.5z"/></svg>96</span>
            </span>
            <span class="tt-cap">
              <b>&#64;ciabaysa</b>
              <small>Zafra de maíz con tecnología Case IH 🌽 #agro #paraguay</small>
              <span class="tt-music">♫ CIABAY en Campo · Audio original</span>
            </span>
          </span></span>
          <span class="plabel">TikTok ↗</span>
        </a>
      </div>
    </div>
  </section>

  <!-- ===== CONFIANZA / STATS ===== -->
  <section class="sec" id="confianza">
    <div class="wrap">
      <div class="sec-head rev">
        <div>
          <div class="kicker">Por qué CIABAY</div>
          <h2>Confianza respaldada por resultados</h2>
        </div>
        <p>Números que se construyen zafra tras zafra, al lado del productor paraguayo.</p>
      </div>
      <div class="stats panel-tex rev">
        <div class="stat" tabindex="0">
          <div class="stat-n">+31</div>
          <div class="stat-l">Años</div>
          <div class="stat-tip">Más de tres décadas acompañando la evolución del agro paraguayo.</div>
        </div>
        <div class="stat" tabindex="0">
          <div class="stat-n">+300</div>
          <div class="stat-l">Colaboradores</div>
          <div class="stat-tip">Un equipo humano distribuido en las sucursales de todo el país.</div>
        </div>
        <div class="stat" tabindex="0">
          <div class="stat-n">8</div>
          <div class="stat-l">Sucursales</div>
          <div class="stat-tip">Red propia de punta a punta del Paraguay. Conocé el mapa interactivo en la página Sucursales.</div>
        </div>
        <div class="stat" tabindex="0">
          <div class="stat-n">+120</div>
          <div class="stat-l">Técnicos de post venta</div>
          <div class="stat-tip">Técnicos capacitados que mantienen las máquinas trabajando en el campo.</div>
        </div>
        <div class="stat" tabindex="0">
          <div class="stat-n">1</div>
          <div class="stat-l">Única en ofrecer el portafolio completo</div>
          <div class="stat-tip">Insumos, máquinas, implementos y post venta: nadie más cubre todo el ciclo en un solo lugar.</div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== PÁGINAS DEL SITIO ===== -->
  <section class="sec" id="explora">
    <div class="wrap">
      <div class="sec-head rev">
        <div>
          <div class="kicker">Más de CIABAY</div>
          <h2>Explorá el sitio</h2>
        </div>
        <p>Tres páginas para conocer de dónde venimos, dónde estamos y qué hacemos en el campo.</p>
      </div>
      <div class="pages">
        <a class="page-card panel-tex rev" href="{{ url('historia') }}" style="transition-delay:.0s">
          <span class="page-k">Timeline interactivo</span>
          <h3>Historia de CIABAY</h3>
          <p>Más de 31 años de evolución, era por era, con las fotos y los logos de cada época.</p>
          <span class="page-foot"><span class="page-go">Ver página</span><span class="circle-btn" aria-hidden="true">→</span></span>
        </a>
        <a class="page-card panel-tex rev" href="{{ url('sucursales') }}" style="transition-delay:.08s">
          <span class="page-k">Mapa del Paraguay</span>
          <h3>Sucursales</h3>
          <p>Encontrá tu sucursal más cercana en el mapa interactivo por departamentos.</p>
          <span class="page-foot"><span class="page-go">Ver página</span><span class="circle-btn" aria-hidden="true">→</span></span>
        </a>
        <a class="page-card panel-tex rev" href="{{ url('ciabay-en-campo') }}" style="transition-delay:.16s">
          <span class="page-k">Días de campo · Demos</span>
          <h3>CIABAY en Campo</h3>
          <p>Demostraciones, capacitaciones y el día a día junto al productor, contados desde el lote.</p>
          <span class="page-foot"><span class="page-go">Ver página</span><span class="circle-btn" aria-hidden="true">→</span></span>
        </a>
      </div>
    </div>
  </section>

  <!-- ===== CLAIM ===== -->
  <section class="sec">
    <div class="wrap">
      <div class="claim panel-tex rev">
        <div class="kicker">Nuestro compromiso</div>
        <div class="claim-t">Del <em>insumo</em> al <em>repuesto</em>, <u>todo el ciclo</u> en buenas manos.</div>
        <div class="claim-foot">Case IH · Vence Tudo · 8 sucursales · +31 años</div>
      </div>
    </div>
  </section>

</main>

<div id="tipmap" role="tooltip" aria-hidden="true"></div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/inicio-page.js') }}"></script>
@endpush
