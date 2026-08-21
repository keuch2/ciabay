{{--
    Plantilla "vence-tudo" — hard-coded (origen: nuevo-vence-tudo.html).
    Se activa con template='vence-tudo' en la página (select "Template" del admin).
    CSS/JS en public/assets/ (vence-tudo-page.css / vence-tudo-page.js), scopeados
    bajo .vencetudo-v2 — mismo esquema que las plantillas anteriores.
    Las imágenes, el video del Kit Vence Fuego y el grito del águila llegan al JS
    vía window.VT_MEDIA (asset() en render time, como window.SUCURSALES_IMG).
    El modo catálogo togglea la clase view-cat en <body> (la usa el CSS scopeado).
--}}
@extends('layouts.public')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,400..900&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/vence-tudo-page.css') }}">
@endpush

@section('content')
<div class="vencetudo-v2">
<section class="panels" id="panels" aria-label="Categorías Vence Tudo">

  <!-- SEMBRADORAS -->
  <a class="panel" href="#sembradoras" data-cat="sembradoras">
    <img class="foto" data-img="sembradoras" alt="Sembradora Vence Tudo Pampeana 24000" style="object-position:42% 52%">
    <div class="luz"></div><div class="vineta"></div><span class="foco"></span>
    <div class="leyenda">
      <h2>Sembra&shy;doras</h2>
      <span class="raya"></span>
      <span class="ir">Conocé toda la línea <i>→</i></span>
    </div>
  </a>

  <!-- CABEZAL DE MAÍZ + ÁGUILA -->
  <a class="panel" href="#cabezales" data-cat="cabezal" id="panelCabezal">
    <img class="foto" data-img="cabezal" alt="Cabezal de maíz Vence Tudo Bocuda Eagle" style="object-position:60% 60%">
    <div class="luz"></div><div class="vineta"></div><span class="foco"></span>
    <div class="leyenda">
      <div class="titulo"><div class="eagle-perched" id="eaglePerched" aria-hidden="true"><img class="pl" data-asset="pleft" alt=""><img class="pr" data-asset="pright" alt=""><img class="pb" data-asset="pbody" alt=""></div><h2>Cabezal <br>de maíz</h2></div>
      <span class="raya"></span>
      <span class="ir">Conocé toda la línea <i>→</i></span>
    </div>
  </a>

  <!-- TOLVAS -->
  <a class="panel pendiente" href="#tolvas" data-cat="tolvas">
    <img class="foto" id="tolvaHeroImg" data-img="tolvas_hero" alt="Tolva granelera Vence Tudo Granos 33000 recibiendo grano de la cosechadora" style="object-position:44% 50%">
    <canvas class="granos-mini" id="granosMini" aria-hidden="true"></canvas>
    <div class="glifo" aria-hidden="true">
      <svg viewBox="0 0 80 80"><path d="M8 18h64l-9 30H17L8 18Z"/><path d="M17 48l8 16h30l8-16"/><path d="M62 28l14-14M76 14v10M76 14H66"/><circle cx="26" cy="70" r="4"/><circle cx="54" cy="70" r="4"/></svg>
    </div>
    <div class="luz"></div><div class="vineta"></div><span class="foco"></span>
    <div class="leyenda">
      <h2>Tolvas</h2>
      <span class="raya"></span>
      <span class="ir">Conocé toda la línea <i>→</i></span>
    </div>
  </a>

  <!-- CLASIFICADOR DE SEMILLA -->
  <a class="panel pendiente" href="#clasificadores" data-cat="clasificador">
    <img class="foto" data-img="clasificador" alt="Clasificador de semilla Vence Tudo C-40" style="object-position:66% 55%">
    <div class="glifo" aria-hidden="true">
      <svg viewBox="0 0 80 80"><circle cx="40" cy="34" r="24"/><path d="M16 34h48M40 10v48M23 17l34 34M57 17 23 51"/><path d="M40 58v8"/><circle cx="30" cy="72" r="2"/><circle cx="40" cy="72" r="2.8"/><circle cx="50" cy="72" r="1.6"/></svg>
    </div>
    <div class="luz"></div><div class="vineta"></div><span class="foco"></span>
    <div class="leyenda">
      <h2>Clasifi&shy;cador <br>de semilla</h2>
      <span class="raya"></span>
      <span class="ir">Conocé toda la línea <i>→</i></span>
    </div>
  </a>

</section>



<!-- ================= DETALLE: CABEZAL DE MAÍZ ================= -->
<section class="detalle" id="det-cabezal" data-cat="cabezal">
  <div class="det-bar">
    <button class="volver" type="button" data-volver><i>←</i> Volver a las categorías</button>
    <span class="eyebrow">Vence Tudo · Cabezal de maíz · Línea Bocuda</span>
  </div>
  
  <article class="mod" data-modelo="eagle">
    <div class="escena">
      <span class="escena-cap"><b>01</b> Bocuda Eagle</span>
      <div class="letras titulo" aria-hidden="true"><span class="bocuda">Bocuda</span><span class="palabra">Eagle</span></div>
      <div class="ren-wrap"><img class="render " data-asset="ren_eagle" alt="Bocuda Eagle"><div class="eagle-perched" id="eaglePerched2" aria-hidden="true"><img class="pl" data-asset="pleft" alt=""><img class="pr" data-asset="pright" alt=""><img class="pb" data-asset="pbody" alt=""></div></div>
    </div>
    <div class="mod-info">
      <div>
        <h3>Bocuda <em>Eagle</em></h3>
        <p class="mod-tag">El cabezal de las súper cosechas</p>
      </div>
      <div>
        <p class="mod-desc">La historia de Bocuda Eagle comenzó con los proyectos de Vence Tudo realizados en los Estados Unidos, con el objetivo de satisfacer las necesidades de los productores estadounidenses. Pasaron dos años, en 2017, el cabezal inició sus pruebas en territorio brasileño, demostrando ya agilidad y calidad en el trabajo realizado. En 2020 se lanzó oficialmente la Bocuda Eagle y desde entonces ha conquistado la preferencia de los productores, en especial de los que realizan súper cosechas.</p>
        <p class="mod-desc">Esta consagración se debe a los diferenciales exclusivos, entre ellos la tecnología desarrollada y patentada por Vence Tudo, el <b>Speed Roll®</b>. Este innovador sistema fue desarrollado para brindar el mejor rendimiento en un cabezal de maíz y garantizar la mejor cosecha. La tecnología Speed Roll® también cuenta con <b>16 cuchillas AFIMAXX® autoafilables</b> con tratamiento especial.</p>
        <a class="btn wa" href="https://wa.me/595983178015?text=Hola%20CIABAY%2C%20quiero%20consultar%20por%20el%20cabezal%20Bocuda%20Eagle" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 3.9A10 10 0 0 0 4.3 16.1L3 21l5-1.3A10 10 0 0 0 20 3.9ZM12 19.5a8.3 8.3 0 0 1-4.3-1.2l-.3-.2-3 .8.8-2.9-.2-.3A8.4 8.4 0 1 1 12 19.5Zm4.6-6.2c-.3-.1-1.5-.7-1.7-.8s-.4-.1-.6.1-.7.8-.8 1-.3.2-.5.1a6.9 6.9 0 0 1-3.4-3c-.3-.4.3-.4.8-1.4a.5.5 0 0 0 0-.5l-.8-1.8c-.2-.5-.4-.4-.6-.4h-.5a1 1 0 0 0-.7.3 3 3 0 0 0-.9 2.2 5.2 5.2 0 0 0 1.1 2.8 12 12 0 0 0 4.5 4c1.7.7 2.3.8 3.1.6a2.7 2.7 0 0 0 1.8-1.2 2.2 2.2 0 0 0 .1-1.2c0-.1-.2-.2-.5-.3Z"/></svg>Consultar por WhatsApp</a>
      </div>
    </div>
    <div class="mod-fotos" style="--n:3"><button type="button" class="mf" data-src="cab_eagle_2" aria-label="Ampliar foto"><img data-img="cab_eagle_2" alt="Bocuda Eagle"></button><button type="button" class="mf" data-src="cab_eagle_3" aria-label="Ampliar foto"><img data-img="cab_eagle_3" alt="Bocuda Eagle"></button><button type="button" class="mf" data-src="cab_eagle_4" aria-label="Ampliar foto"><img data-img="cab_eagle_4" alt="Bocuda Eagle"></button></div>
  </article>
  
  <article class="mod" data-modelo="hibrida">
    <div class="escena">
      <span class="escena-cap"><b>02</b> Bocuda Híbrida</span>
      <div class="letras titulo " aria-hidden="true"><span class="bocuda">Bocuda</span><span class="palabra">Híbrida</span></div>
      <img class="render foto-ren" data-img="cab_hib_1" alt="Bocuda Híbrida">
    </div>
    <div class="mod-info">
      <div>
        <h3>Bocuda <em>Híbrida</em></h3>
        <p class="mod-tag">Productividad con robustez y excelente costo/beneficio</p>
      </div>
      <div>
        <p class="mod-desc">Es reconocida por su robustez, sencillez de operación, ajuste y mantenimiento, además de ser rentable. Proporciona un alto rendimiento operativo, con pérdidas de cosecha reducidas. Su chasis es universal, robusto en acero estructural, con una mayor concentración de peso cerca de la embocadura. Cuenta con la mayor variedad de configuraciones de espaciamiento del mercado (12 a 16 líneas) y un exclusivo kit de acoplamiento/impulsión para varios modelos de cosechadoras nacionales e importadas.</p>
        <a class="btn wa" href="https://wa.me/595983178015?text=Hola%20CIABAY%2C%20quiero%20consultar%20por%20el%20cabezal%20Bocuda%20H%C3%ADbrida" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 3.9A10 10 0 0 0 4.3 16.1L3 21l5-1.3A10 10 0 0 0 20 3.9ZM12 19.5a8.3 8.3 0 0 1-4.3-1.2l-.3-.2-3 .8.8-2.9-.2-.3A8.4 8.4 0 1 1 12 19.5Zm4.6-6.2c-.3-.1-1.5-.7-1.7-.8s-.4-.1-.6.1-.7.8-.8 1-.3.2-.5.1a6.9 6.9 0 0 1-3.4-3c-.3-.4.3-.4.8-1.4a.5.5 0 0 0 0-.5l-.8-1.8c-.2-.5-.4-.4-.6-.4h-.5a1 1 0 0 0-.7.3 3 3 0 0 0-.9 2.2 5.2 5.2 0 0 0 1.1 2.8 12 12 0 0 0 4.5 4c1.7.7 2.3.8 3.1.6a2.7 2.7 0 0 0 1.8-1.2 2.2 2.2 0 0 0 .1-1.2c0-.1-.2-.2-.5-.3Z"/></svg>Consultar por WhatsApp</a>
      </div>
    </div>
    <div class="mod-fotos" style="--n:2"><button type="button" class="mf" data-src="cab_hib_2" aria-label="Ampliar foto"><img data-img="cab_hib_2" alt="Bocuda Híbrida"></button><button type="button" class="mf" data-src="cab_hib_3" aria-label="Ampliar foto"><img data-img="cab_hib_3" alt="Bocuda Híbrida"></button></div>
  </article>
  
  <article class="mod" data-modelo="serie08">
    <div class="escena">
      <span class="escena-cap"><b>03</b> Bocuda Série 08</span>
      <div class="letras titulo " aria-hidden="true"><span class="bocuda">Bocuda</span><span class="palabra">Série 08</span></div>
      <img class="render " data-asset="ren_s08" alt="Bocuda Série 08">
    </div>
    <div class="mod-info">
      <div>
        <h3>Bocuda <em>Série 08</em></h3>
        <p class="mod-tag">¡El cabezal de maíz líder del mercado por 22 años consecutivos!</p>
      </div>
      <div>
        <p class="mod-desc">Su chasis es universal, robusto en acero estructural, con una mayor concentración de peso cerca de la embocadura. Cuenta con la mayor variedad de configuraciones de espaciamiento del mercado y un exclusivo kit de acoplamiento y accionamiento para varios modelos de cosechadoras nacionales e importadas.</p>
        <a class="btn wa" href="https://wa.me/595983178015?text=Hola%20CIABAY%2C%20quiero%20consultar%20por%20el%20cabezal%20Bocuda%20S%C3%A9rie%2008" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 3.9A10 10 0 0 0 4.3 16.1L3 21l5-1.3A10 10 0 0 0 20 3.9ZM12 19.5a8.3 8.3 0 0 1-4.3-1.2l-.3-.2-3 .8.8-2.9-.2-.3A8.4 8.4 0 1 1 12 19.5Zm4.6-6.2c-.3-.1-1.5-.7-1.7-.8s-.4-.1-.6.1-.7.8-.8 1-.3.2-.5.1a6.9 6.9 0 0 1-3.4-3c-.3-.4.3-.4.8-1.4a.5.5 0 0 0 0-.5l-.8-1.8c-.2-.5-.4-.4-.6-.4h-.5a1 1 0 0 0-.7.3 3 3 0 0 0-.9 2.2 5.2 5.2 0 0 0 1.1 2.8 12 12 0 0 0 4.5 4c1.7.7 2.3.8 3.1.6a2.7 2.7 0 0 0 1.8-1.2 2.2 2.2 0 0 0 .1-1.2c0-.1-.2-.2-.5-.3Z"/></svg>Consultar por WhatsApp</a>
      </div>
    </div>
    <div class="mod-fotos" style="--n:2"><button type="button" class="mf" data-src="cab_s08_3" aria-label="Ampliar foto"><img data-img="cab_s08_3" alt="Bocuda Série 08"></button><button type="button" class="mf" data-src="cab_s08_2" aria-label="Ampliar foto"><img data-img="cab_s08_2" alt="Bocuda Série 08"></button></div>
  </article>
  <div class="det-foot"><button class="volver" type="button" data-volver><i>←</i> Volver a las categorías</button></div>
</section>

<!-- lightbox -->
<div class="lightbox" id="lightbox" hidden><img alt=""><button type="button" class="lb-close" aria-label="Cerrar">✕</button></div>

<section class="detalle" id="det-sembradoras" data-cat="sembradoras">
  <div class="det-bar">
    <button class="volver" type="button" data-volver><i>←</i> Volver a las categorías</button>
    <span class="eyebrow">Vence Tudo · Sembradoras</span>
  </div>

  <div class="semb-nav">
    <div class="grupos" id="sembGrupos" role="tablist" aria-label="Tipo de grano">
      <button type="button" data-grupo="finos" class="on">Granos finos</button>
      <button type="button" data-grupo="gruesos">Granos gruesos</button>
    </div>
    <div class="modelos-tabs" id="sembModelos" role="tablist" aria-label="Modelos"></div>
  </div>

  <div class="semb-panel" id="sembPanel"></div>

  <div class="det-foot"><button class="volver" type="button" data-volver><i>←</i> Volver a las categorías</button></div>
</section>
<section class="detalle" id="det-tolvas" data-cat="tolvas">
  <div class="det-bar">
    <button class="volver" type="button" data-volver><i>←</i> Volver a las categorías</button>
    <span class="eyebrow">Vence Tudo · Tolvas · Graneleros Granos</span>
  </div>

  <div class="tolva-escena" id="tolvaEscena">
    <img class="auger" id="augerImg" data-asset="auger" alt="Sinfín de descarga de la cosechadora">
    <img class="tolva-img" id="tolvaImg" data-asset="tolva" alt="Tolva granelera Vence Tudo Granos">
    <img class="tolva-img2" data-asset="tolva33" alt="Tolva granelera Vence Tudo Granos 33000">
    <canvas id="granosCanvas" aria-hidden="true"></canvas>
    <div class="tolva-txt">
      <span class="eyebrow">Tolvas graneleras</span>
      <h1>Que la<br>cosechadora<br><em>no pare.</em></h1>
      <p>La tolva Vence Tudo recibe el grano al lado de la cosechadora y lo lleva al camión mientras la máquina sigue cortando. Menos paradas, más hectáreas por día.</p>
    </div>
  </div>

  <div class="tolva-opciones">
    <div class="op-head">
      <span class="eyebrow">Opciones disponibles</span>
      <h2>Elegí la capacidad<br>para tu cosecha</h2>
      <p>La serie Granos viene en distintos volúmenes. Tocá una capacidad y consultá disponibilidad y configuración con un asesor CIABAY.</p>
    </div>
    <div class="caps" id="caps"><button type="button" class="cap " data-cap="10500"><small>Granos</small>10500</button><button type="button" class="cap " data-cap="12500"><small>Granos</small>12500</button><button type="button" class="cap " data-cap="14500"><small>Granos</small>14500</button><button type="button" class="cap " data-cap="16500"><small>Granos</small>16500</button><button type="button" class="cap " data-cap="21000"><small>Granos</small>21000</button><button type="button" class="cap " data-cap="25000"><small>Granos</small>25000</button><button type="button" class="cap " data-cap="27500"><small>Granos</small>27500</button><button type="button" class="cap on" data-cap="33000"><small>Granos</small>33000</button><button type="button" class="cap " data-cap="42000"><small>Granos</small>42000</button></div>
    <div class="op-cta">
      <div class="op-sel">Modelo elegido: <b id="capSel">Granos 33000</b></div>
      <a class="btn wa" id="capWa" href="https://wa.me/595983178015?text=Hola%20CIABAY%2C%20quiero%20consultar%20por%20la%20tolva%20Granos%2033000" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 3.9A10 10 0 0 0 4.3 16.1L3 21l5-1.3A10 10 0 0 0 20 3.9ZM12 19.5a8.3 8.3 0 0 1-4.3-1.2l-.3-.2-3 .8.8-2.9-.2-.3A8.4 8.4 0 1 1 12 19.5Zm4.6-6.2c-.3-.1-1.5-.7-1.7-.8s-.4-.1-.6.1-.7.8-.8 1-.3.2-.5.1a6.9 6.9 0 0 1-3.4-3c-.3-.4.3-.4.8-1.4a.5.5 0 0 0 0-.5l-.8-1.8c-.2-.5-.4-.4-.6-.4h-.5a1 1 0 0 0-.7.3 3 3 0 0 0-.9 2.2 5.2 5.2 0 0 0 1.1 2.8 12 12 0 0 0 4.5 4c1.7.7 2.3.8 3.1.6a2.7 2.7 0 0 0 1.8-1.2 2.2 2.2 0 0 0 .1-1.2c0-.1-.2-.2-.5-.3Z"/></svg>Consultar por WhatsApp</a>
    </div>
  </div>


  <div class="tolva-fuego" id="tolvaFuego">
    <div class="fuego-info">
      <span class="fuego-badge"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.2 2s.9 2.6-.9 5.2c-1.4 2-3.6 3.2-4.6 5.6-1.3 3 .1 6.6 3 8.2-.9-1.6-.9-3.6.3-5 1-1.2 2.6-1.7 3.5-3.2.4-.6.6-1.3.6-2 1.6 1.6 2.6 4 2.3 6.3-.1 1.2-.6 2.4-1.4 3.4 2.6-1 4.6-3.4 4.9-6.3.5-4.6-2.9-7.2-4.4-9.5C15.3 3.3 13.2 2 13.2 2z"/></svg>Opcional · a pedido</span>
      <h2>Kit <em>Vence Fuego</em></h2>
      <p class="fuego-tag">Tu tolva, lista para combatir el fuego en el lote</p>
      <p class="fuego-desc">En plena cosecha el calor aprieta y el rastrojo está seco: una chispa alcanza para que el fuego corra. Por eso podés pedir tu tolva con el Kit Vence Fuego, un opcional que le suma bomba y carretel con manguera para dar la primera respuesta ahí mismo, al lado de la cosechadora, sin esperar a que llegue el auxilio.</p>
      <ul class="fuego-puntos">
        <li>Bomba y carretel con manguera integrados a la tolva</li>
        <li>Se despliega en segundos y lo maneja un solo operador</li>
        <li>Alcance para regar la cosechadora, el cabezal y el rastrojo</li>
      </ul>
      <a class="btn wa" href="https://wa.me/595983178015?text=Hola%20CIABAY%2C%20quiero%20consultar%20por%20el%20Kit%20Vence%20Fuego%20opcional%20para%20tolvas" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 3.9A10 10 0 0 0 4.3 16.1L3 21l5-1.3A10 10 0 0 0 20 3.9ZM12 19.5a8.3 8.3 0 0 1-4.3-1.2l-.3-.2-3 .8.8-2.9-.2-.3A8.4 8.4 0 1 1 12 19.5Zm4.6-6.2c-.3-.1-1.5-.7-1.7-.8s-.4-.1-.6.1-.7.8-.8 1-.3.2-.5.1a6.9 6.9 0 0 1-3.4-3c-.3-.4.3-.4.8-1.4a.5.5 0 0 0 0-.5l-.8-1.8c-.2-.5-.4-.4-.6-.4h-.5a1 1 0 0 0-.7.3 3 3 0 0 0-.9 2.2 5.2 5.2 0 0 0 1.1 2.8 12 12 0 0 0 4.5 4c1.7.7 2.3.8 3.1.6a2.7 2.7 0 0 0 1.8-1.2 2.2 2.2 0 0 0 .1-1.2c0-.1-.2-.2-.5-.3Z"/></svg>Consultar por WhatsApp</a>
    </div>
    <div class="fuego-phone">
      <div class="fuego-marco">
        <i class="notch" aria-hidden="true"></i>
        <video id="kitFuegoVid" data-asset="kitfuego" muted loop playsinline preload="metadata" aria-label="Demostración del Kit Vence Fuego en el campo"></video>
        <button type="button" class="fuego-snd" id="fuegoSnd" aria-label="Activar sonido del video"></button>
      </div>
      <span class="fuego-cap">Demostración real en el campo</span>
    </div>
  </div>

  <div class="tolva-galeria" aria-label="Galería de tolvas Vence Tudo"><button type="button" class="mf" data-src="tolva_g1" aria-label="Ampliar foto"><img data-img="tolva_g1" alt="Tolva Vence Tudo Granos"></button><button type="button" class="mf" data-src="tolva_g2" aria-label="Ampliar foto"><img data-img="tolva_g2" alt="Tolva Vence Tudo Granos"></button><button type="button" class="mf" data-src="tolva_g3" aria-label="Ampliar foto"><img data-img="tolva_g3" alt="Tolva Vence Tudo Granos"></button><button type="button" class="mf" data-src="tolva_g4" aria-label="Ampliar foto"><img data-img="tolva_g4" alt="Tolva Vence Tudo Granos"></button><button type="button" class="mf" data-src="tolva_g5" aria-label="Ampliar foto"><img data-img="tolva_g5" alt="Tolva Vence Tudo Granos"></button><button type="button" class="mf" data-src="tolva_g6" aria-label="Ampliar foto"><img data-img="tolva_g6" alt="Tolva Vence Tudo Granos"></button></div>

  <div class="det-foot"><button class="volver" type="button" data-volver><i>←</i> Volver a las categorías</button></div>
</section>
<section class="detalle" id="det-clasificador" data-cat="clasificador">
  <div class="det-bar">
    <button class="volver" type="button" data-volver><i>←</i> Volver a las categorías</button>
    <span class="eyebrow">Vence Tudo · Clasificador de semilla</span>
  </div>

  <div class="claim">
    <svg class="hoja" viewBox="0 0 120 200" aria-hidden="true"><path d="M104 6C60 26 14 68 12 126c-1 32 14 56 26 68 4-32 24-58 50-84-18 30-34 60-38 92 30-6 62-32 68-80 4-36-6-82-14-116Z" fill="#F2C230"/><path d="M104 6C86 44 64 84 44 130c-4 10-8 22-10 34" fill="none" stroke="#D9A800" stroke-width="3" stroke-linecap="round"/></svg>
    <p>Aumente <em>las ganancias</em> de su propiedad produciendo su <em>propia semilla.</em></p>
  </div>

  <article class="ca-blk" data-modelo="ca25">
    <div class="ca-escena">
      <span class="escena-cap"><b>01</b> Clasificador de semilla</span>
      <div class="letras" aria-hidden="true"><span class="bocuda">Especial</span><span class="palabra">CA 25</span></div>
      <img class="ca-render" id="caRender" data-asset="ca_1" alt="Clasificador de semilla Vence Tudo CA 25 Especial">
      <div class="ca-vistas" id="caVistas"><button type="button" class="on" data-src="ca_1"><img data-asset="ca_1" alt="Perspectiva"><span>Perspectiva</span></button><button type="button" class="" data-src="ca_2"><img data-asset="ca_2" alt="Lateral"><span>Lateral</span></button><button type="button" class="" data-src="ca_3"><img data-asset="ca_3" alt="Frontal"><span>Frontal</span></button><button type="button" class="" data-src="ca_4"><img data-asset="ca_4" alt="Trasera"><span>Trasera</span></button></div>
    </div>
    <div class="ca-info">
      <h3>CA 25 <em>Especial</em></h3>
      <p class="mod-tag">Tradición premiada que agrega valor a su producción</p>
      <p class="mod-desc">Los Clasificadores de Semillas Vence Tudo, a través de sus combinaciones de cribas, realizan con precisión y practicidad su función de limpieza y clasificación en varios cultivos. El CA 25 está aprobado por los usuarios y ya recibió dos premios Gerdau Melhores da Terra (1998 y 2014).</p>
      <div class="ca-cultivos"><span class="lbl">Cultivos</span><div class="chips"><span>soya</span><span>maíz</span><span>trigo</span><span>fríjol</span><span>arroz</span><span>avena</span><span>sorgo</span><span>canola</span><span>girasol</span><span>palomitas</span><span>ajonjolí</span><span>garbanzos</span><span>alfalfa</span></div></div>
      <div class="ca-premio"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2l2.6 5.3 5.8.8-4.2 4.1 1 5.8L12 15.3 6.8 18l1-5.8L3.6 8.1l5.8-.8L12 2z"/></svg><span><b>2 premios</b> Gerdau Melhores da Terra · 1998 y 2014</span></div>
      <a class="btn wa" href="https://wa.me/595983178015?text=Hola%20CIABAY%2C%20quiero%20consultar%20por%20el%20clasificador%20de%20semilla%20CA%2025%20Especial" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 3.9A10 10 0 0 0 4.3 16.1L3 21l5-1.3A10 10 0 0 0 20 3.9ZM12 19.5a8.3 8.3 0 0 1-4.3-1.2l-.3-.2-3 .8.8-2.9-.2-.3A8.4 8.4 0 1 1 12 19.5Zm4.6-6.2c-.3-.1-1.5-.7-1.7-.8s-.4-.1-.6.1-.7.8-.8 1-.3.2-.5.1a6.9 6.9 0 0 1-3.4-3c-.3-.4.3-.4.8-1.4a.5.5 0 0 0 0-.5l-.8-1.8c-.2-.5-.4-.4-.6-.4h-.5a1 1 0 0 0-.7.3 3 3 0 0 0-.9 2.2 5.2 5.2 0 0 0 1.1 2.8 12 12 0 0 0 4.5 4c1.7.7 2.3.8 3.1.6a2.7 2.7 0 0 0 1.8-1.2 2.2 2.2 0 0 0 .1-1.2c0-.1-.2-.2-.5-.3Z"/></svg>Consultar por WhatsApp</a>
    </div>
  </article>


  <!-- C-40 -->
  <article class="ca-blk c40" data-modelo="c40">
    <figure class="c40-foto"><img data-img="clasificador" alt="Clasificador de semilla Vence Tudo C-40 Especial en el campo"></figure>
    <div class="ca-info">
      <h3>C-40 <em>Especial</em></h3>
      <p class="mod-tag">Más capacidad para producciones grandes</p>
      <p class="mod-desc">Con zarandas de 50 × 200 cm y motor de 2 HP, el C-40 clasifica 40 kg por hora y se traslada por la barra de tracción del tractor, para llevar la limpieza y clasificación de semilla directamente a donde está la producción.</p>
      <a class="btn wa" href="https://wa.me/595983178015?text=Hola%20CIABAY%2C%20quiero%20consultar%20por%20el%20clasificador%20de%20semilla%20C-40%20Especial" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 3.9A10 10 0 0 0 4.3 16.1L3 21l5-1.3A10 10 0 0 0 20 3.9ZM12 19.5a8.3 8.3 0 0 1-4.3-1.2l-.3-.2-3 .8.8-2.9-.2-.3A8.4 8.4 0 1 1 12 19.5Zm4.6-6.2c-.3-.1-1.5-.7-1.7-.8s-.4-.1-.6.1-.7.8-.8 1-.3.2-.5.1a6.9 6.9 0 0 1-3.4-3c-.3-.4.3-.4.8-1.4a.5.5 0 0 0 0-.5l-.8-1.8c-.2-.5-.4-.4-.6-.4h-.5a1 1 0 0 0-.7.3 3 3 0 0 0-.9 2.2 5.2 5.2 0 0 0 1.1 2.8 12 12 0 0 0 4.5 4c1.7.7 2.3.8 3.1.6a2.7 2.7 0 0 0 1.8-1.2 2.2 2.2 0 0 0 .1-1.2c0-.1-.2-.2-.5-.3Z"/></svg>Consultar por WhatsApp</a>
    </div>
  </article>

  <!-- ESPECIFICACIONES -->
  <div class="specs">
    <div class="specs-head"><span class="eyebrow">Especificaciones técnicas</span><h2>Los dos modelos, <em>lado a lado</em></h2></div>
    <div class="specs-tabla">
      <table>
        <thead><tr><th scope="col">Características</th><th scope="col">CA-25 Especial</th><th scope="col">C-40 Especial</th></tr></thead>
        <tbody><tr><th scope="row">Producción (kg por hora)</th><td>25</td><td>40</td></tr><tr><th scope="row">Cantidad de zarandas</th><td>10</td><td>10</td></tr><tr><th scope="row">Dimensiones de las zarandas (cm)</th><td>50 × 100</td><td>50 × 200</td></tr><tr><th scope="row">Altura total (mm)</th><td>1660</td><td>2550</td></tr><tr><th scope="row">Ancho total (mm)</th><td>1280</td><td>1750</td></tr><tr><th scope="row">Largo total (mm)</th><td>1850</td><td>3150</td></tr><tr><th scope="row">Peso con motor eléctrico (kg)</th><td>240</td><td>560</td></tr><tr><th scope="row">Motor (HP)</th><td>1/2</td><td>2</td></tr></tbody>
      </table>
    </div>
  </div>

  <!-- CARACTERÍSTICAS -->
  <div class="feats">
    <article class="feat">
      <div class="feat-fotos two"><img data-img="feat1" alt="Clasificador acoplado al tractor"><img data-img="feat2" alt="Barra de tracción del clasificador"></div>
      <h3><i></i>Transporte</h3>
      <p>Se transportan fácilmente por acople 3 puntos o manualmente (CA-25 Especial) o por la barra de tracción del tractor (C-40), permitiendo mayor agilidad en la operación, así como también utilizar el equipo en el lugar deseado.</p>
    </article>
    <article class="feat">
      <div class="feat-fotos"><img data-img="feat3" alt="Zarandas autolimpiantes con esferas de goma"></div>
      <h3><i></i>Zarandas autolimpiantes</h3>
      <p>Tienen un sistema exclusivo de esferas de goma que mantiene limpia la zaranda en todo momento, evitando paradas y posibles obstrucciones, generando mayor rendimiento y productividad en su propiedad.</p>
    </article>
  </div>
  <div class="det-foot"><button class="volver" type="button" data-volver><i>←</i> Volver a las categorías</button></div>
</section>

<!-- águila en vuelo -->
<div class="eagle-fly" id="eagleFly" aria-hidden="true"><div class="rig" id="rig"><img class="far" data-asset="far" alt=""><img class="near" data-asset="near" alt=""><img class="body" data-asset="body" alt=""></div></div>

<!-- sonido -->
<audio id="snd" preload="auto"></audio>
<button class="snd-btn" id="sndBtn" type="button" aria-label="Ver el águila con sonido">
  <svg viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3a4.5 4.5 0 0 0-2.5-4v8a4.5 4.5 0 0 0 2.5-4zM14 3.2v2.1a7 7 0 0 1 0 13.4v2.1a9 9 0 0 0 0-17.6z"/></svg>
  Ver el águila con sonido
</button>
</div>
@endsection

@push('scripts')
    <script>
        window.VT_MEDIA = {
            imgs: {
                sembradoras: "{{ asset('assets/images/vence-tudo/v2/sembradoras.jpg') }}",
                cabezal: "{{ asset('assets/images/vence-tudo/v2/cabezal.jpg') }}",
                tolvas: "{{ asset('assets/images/vence-tudo/v2/tolvas.jpg') }}",
                cab_eagle_1: "{{ asset('assets/images/vence-tudo/v2/cab_eagle_1.jpg') }}",
                cab_eagle_2: "{{ asset('assets/images/vence-tudo/v2/cab_eagle_2.jpg') }}",
                cab_eagle_3: "{{ asset('assets/images/vence-tudo/v2/cab_eagle_3.jpg') }}",
                cab_eagle_4: "{{ asset('assets/images/vence-tudo/v2/cab_eagle_4.jpg') }}",
                cab_hib_1: "{{ asset('assets/images/vence-tudo/v2/cab_hib_1.jpg') }}",
                cab_hib_2: "{{ asset('assets/images/vence-tudo/v2/cab_hib_2.jpg') }}",
                cab_hib_3: "{{ asset('assets/images/vence-tudo/v2/cab_hib_3.jpg') }}",
                cab_s08_1: "{{ asset('assets/images/vence-tudo/v2/cab_s08_1.jpg') }}",
                cab_s08_2: "{{ asset('assets/images/vence-tudo/v2/cab_s08_2.jpg') }}",
                cab_s08_3: "{{ asset('assets/images/vence-tudo/v2/cab_s08_3.jpg') }}",
                clasificador: "{{ asset('assets/images/vence-tudo/v2/clasificador.jpg') }}",
                tolva_g1: "{{ asset('assets/images/vence-tudo/v2/tolva_g1.jpg') }}",
                tolva_g2: "{{ asset('assets/images/vence-tudo/v2/tolva_g2.jpg') }}",
                tolva_g3: "{{ asset('assets/images/vence-tudo/v2/tolva_g3.jpg') }}",
                tolva_g4: "{{ asset('assets/images/vence-tudo/v2/tolva_g4.jpg') }}",
                tolva_g5: "{{ asset('assets/images/vence-tudo/v2/tolva_g5.jpg') }}",
                tolva_g6: "{{ asset('assets/images/vence-tudo/v2/tolva_g6.jpg') }}",
                feat1: "{{ asset('assets/images/vence-tudo/v2/feat1.jpg') }}",
                feat2: "{{ asset('assets/images/vence-tudo/v2/feat2.jpg') }}",
                feat3: "{{ asset('assets/images/vence-tudo/v2/feat3.jpg') }}",
                flexxa_1: "{{ asset('assets/images/vence-tudo/v2/flexxa_1.jpg') }}",
                flexxa_2: "{{ asset('assets/images/vence-tudo/v2/flexxa_2.jpg') }}",
                flexxa_3: "{{ asset('assets/images/vence-tudo/v2/flexxa_3.jpg') }}",
                flexxa_r: "{{ asset('assets/images/vence-tudo/v2/flexxa_r.webp') }}",
                panther_1: "{{ asset('assets/images/vence-tudo/v2/panther_1.jpg') }}",
                panther_2: "{{ asset('assets/images/vence-tudo/v2/panther_2.jpg') }}",
                panther_3: "{{ asset('assets/images/vence-tudo/v2/panther_3.jpg') }}",
                panther_r: "{{ asset('assets/images/vence-tudo/v2/panther_r.webp') }}",
                summer_1: "{{ asset('assets/images/vence-tudo/v2/summer_1.jpg') }}",
                summer_2: "{{ asset('assets/images/vence-tudo/v2/summer_2.jpg') }}",
                summer_r: "{{ asset('assets/images/vence-tudo/v2/summer_r.webp') }}",
                tiger_1: "{{ asset('assets/images/vence-tudo/v2/tiger_1.jpg') }}",
                tiger_2: "{{ asset('assets/images/vence-tudo/v2/tiger_2.jpg') }}",
                tiger_3: "{{ asset('assets/images/vence-tudo/v2/tiger_3.jpg') }}",
                tiger_4: "{{ asset('assets/images/vence-tudo/v2/tiger_4.jpg') }}",
                tiger_r: "{{ asset('assets/images/vence-tudo/v2/tiger_r.webp') }}",
                maca_1: "{{ asset('assets/images/vence-tudo/v2/maca_1.jpg') }}",
                maca_2: "{{ asset('assets/images/vence-tudo/v2/maca_2.jpg') }}",
                maca_3: "{{ asset('assets/images/vence-tudo/v2/maca_3.jpg') }}",
                maca_4: "{{ asset('assets/images/vence-tudo/v2/maca_4.jpg') }}",
                maca_5: "{{ asset('assets/images/vence-tudo/v2/maca_5.jpg') }}",
                maca_6: "{{ asset('assets/images/vence-tudo/v2/maca_6.jpg') }}",
                maca_7: "{{ asset('assets/images/vence-tudo/v2/maca_7.jpg') }}",
                maca_8: "{{ asset('assets/images/vence-tudo/v2/maca_8.jpg') }}",
                maca_r: "{{ asset('assets/images/vence-tudo/v2/maca_r.webp') }}",
                pamp_1: "{{ asset('assets/images/vence-tudo/v2/pamp_1.jpg') }}",
                pamp_2: "{{ asset('assets/images/vence-tudo/v2/pamp_2.jpg') }}",
                pamp_3: "{{ asset('assets/images/vence-tudo/v2/pamp_3.jpg') }}",
                pamp_4: "{{ asset('assets/images/vence-tudo/v2/pamp_4.jpg') }}",
                pamp_5: "{{ asset('assets/images/vence-tudo/v2/pamp_5.jpg') }}",
                pamp_6: "{{ asset('assets/images/vence-tudo/v2/pamp_6.jpg') }}",
                pamp_7: "{{ asset('assets/images/vence-tudo/v2/pamp_7.jpg') }}",
                pamp_r: "{{ asset('assets/images/vence-tudo/v2/pamp_r.webp') }}",
                tolvas_hero: "{{ asset('assets/images/vence-tudo/v2/tolvas_hero.jpg') }}",
            },
            assets: {
                kitfuego: "{{ asset('assets/images/vence-tudo/v2/kitfuego.mp4') }}",
                snd: "{{ asset('assets/images/vence-tudo/v2/snd.mp3') }}",
                far: "{{ asset('assets/images/vence-tudo/v2/far.webp') }}",
                near: "{{ asset('assets/images/vence-tudo/v2/near.webp') }}",
                body: "{{ asset('assets/images/vence-tudo/v2/body.webp') }}",
                pleft: "{{ asset('assets/images/vence-tudo/v2/pleft.webp') }}",
                pright: "{{ asset('assets/images/vence-tudo/v2/pright.webp') }}",
                pbody: "{{ asset('assets/images/vence-tudo/v2/pbody.webp') }}",
                perch3: "{{ asset('assets/images/vence-tudo/v2/perch3.webp') }}",
                ren_eagle: "{{ asset('assets/images/vence-tudo/v2/ren_eagle.webp') }}",
                ren_s08: "{{ asset('assets/images/vence-tudo/v2/ren_s08.webp') }}",
                auger: "{{ asset('assets/images/vence-tudo/v2/auger.webp') }}",
                tolva: "{{ asset('assets/images/vence-tudo/v2/tolva.webp') }}",
                ca_1: "{{ asset('assets/images/vence-tudo/v2/ca_1.webp') }}",
                ca_2: "{{ asset('assets/images/vence-tudo/v2/ca_2.webp') }}",
                ca_3: "{{ asset('assets/images/vence-tudo/v2/ca_3.webp') }}",
                ca_4: "{{ asset('assets/images/vence-tudo/v2/ca_4.webp') }}",
                tolva33: "{{ asset('assets/images/vence-tudo/v2/tolva33.webp') }}",
            }
        };
    </script>
    <script src="{{ asset('assets/js/vence-tudo-page.js') }}"></script>
@endpush
