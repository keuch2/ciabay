/* Generado desde nuevo_nidera.html — envuelto en IIFE para no contaminar
   el scope global del sitio. */
(function () {
(function(){
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ── Reveal ── */
  var io = new IntersectionObserver(function(es){
    es.forEach(function(e){
      if(e.isIntersecting){
        e.target.classList.add('in');
        if(e.target.closest('.hero')) document.querySelector('.hero').classList.add('in-view');
        io.unobserve(e.target);
      }
    });
  },{threshold:.14});
  document.querySelectorAll('.rv').forEach(function(el){ io.observe(el); });
  if(reduce){
    document.querySelectorAll('.rv').forEach(function(el){ el.classList.add('in'); });
    document.querySelector('.hero').classList.add('in-view');
  }

  /* ── Carrusel ── */
  var track   = document.getElementById('carTrack');
  var prev    = document.getElementById('carPrev');
  var next    = document.getElementById('carNext');
  var prog    = document.getElementById('carProgFill');
  var railFill= document.getElementById('railFill');
  var rail    = document.getElementById('rail');
  var steps   = Array.prototype.slice.call(document.querySelectorAll('.car-step'));
  var cards   = Array.prototype.slice.call(track.querySelectorAll('.car-card'));
  var n = cards.length;

  /* nodos del riel alineados a fracciones */
  var nodes = [];
  for(var i=0;i<n;i++){
    var d = document.createElement('div');
    d.className = 'rail-node' + (i===0 ? ' on' : '');
    d.style.left = (n>1 ? (i/(n-1))*100 : 0) + '%';
    rail.appendChild(d);
    nodes.push(d);
  }

  function cardW(){ return cards[0].getBoundingClientRect().width + 22; }

  function update(){
    var max = track.scrollWidth - track.clientWidth;
    var p = max > 0 ? track.scrollLeft / max : 0;
    prog.style.width = (p*100) + '%';
    railFill.style.width = (p*100) + '%';

    var active = Math.round(p * (n-1));
    steps.forEach(function(s,i){ s.classList.toggle('on', i===active); });
    nodes.forEach(function(nd,i){ nd.classList.toggle('on', i<=active); });

    /* tarjeta más cercana al centro */
    var center = track.getBoundingClientRect().left + track.clientWidth/2;
    var best=null, bd=Infinity;
    cards.forEach(function(c){
      var r=c.getBoundingClientRect();
      var d=Math.abs((r.left+r.width/2)-center);
      if(d<bd){bd=d;best=c;}
    });
    cards.forEach(function(c){ c.classList.toggle('focus', c===best); });
  }
  track.addEventListener('scroll', update, {passive:true});
  window.addEventListener('resize', update);
  update();

  function goTo(i){
    i = Math.max(0, Math.min(n-1, i));
    var max = track.scrollWidth - track.clientWidth;
    track.scrollTo({left:(n>1 ? (i/(n-1))*max : 0), behavior: reduce ? 'auto' : 'smooth'});
  }
  prev.addEventListener('click', function(){
    var max = track.scrollWidth - track.clientWidth;
    var p = max>0 ? track.scrollLeft/max : 0;
    goTo(Math.round(p*(n-1)) - 1);
  });
  next.addEventListener('click', function(){
    var max = track.scrollWidth - track.clientWidth;
    var p = max>0 ? track.scrollLeft/max : 0;
    goTo(Math.round(p*(n-1)) + 1);
  });
  steps.forEach(function(s){
    s.addEventListener('click', function(){ goTo(parseInt(s.dataset.i,10)); });
  });

  /* arrastre con mouse */
  var down=false, startX=0, startL=0, moved=false;
  track.addEventListener('pointerdown', function(e){
    if(e.pointerType!=='mouse') return;
    down=true; moved=false; startX=e.clientX; startL=track.scrollLeft;
    track.classList.add('drag');
    track.setPointerCapture(e.pointerId);
  });
  track.addEventListener('pointermove', function(e){
    if(!down) return;
    var dx = e.clientX - startX;
    if(Math.abs(dx)>4) moved=true;
    track.scrollLeft = startL - dx;
  });
  function release(e){
    if(!down) return;
    down=false; track.classList.remove('drag');
    var max = track.scrollWidth - track.clientWidth;
    var p = max>0 ? track.scrollLeft/max : 0;
    goTo(Math.round(p*(n-1)));
  }
  track.addEventListener('pointerup', release);
  track.addEventListener('pointercancel', release);
  track.addEventListener('click', function(e){ if(moved){ e.preventDefault(); e.stopPropagation(); } }, true);

  /* autoplay: avanza solo hasta que el usuario interactúa */
  var autoTimer = null, autoStopped = false;
  function autoNext(){
    var max = track.scrollWidth - track.clientWidth;
    var p = max>0 ? track.scrollLeft/max : 0;
    var idx = Math.round(p*(n-1)) + 1;
    goTo(idx > n-1 ? 0 : idx);
  }
  function startAuto(){
    if(reduce || autoStopped || autoTimer) return;
    autoTimer = setInterval(autoNext, 4500);
  }
  function stopAuto(kill){
    if(autoTimer){ clearInterval(autoTimer); autoTimer = null; }
    if(kill) autoStopped = true;
  }
  ['pointerdown','wheel','touchstart'].forEach(function(ev){
    track.addEventListener(ev, function(){ stopAuto(true); }, {passive:true});
  });
  prev.addEventListener('click', function(){ stopAuto(true); });
  next.addEventListener('click', function(){ stopAuto(true); });
  steps.forEach(function(s){ s.addEventListener('click', function(){ stopAuto(true); }); });
  var carIO = new IntersectionObserver(function(es){
    es.forEach(function(e){ e.isIntersecting ? startAuto() : stopAuto(false); });
  },{threshold:.35});
  carIO.observe(track);
  document.addEventListener('visibilitychange', function(){
    if(document.hidden){ stopAuto(false); }
    else{
      var r = track.getBoundingClientRect();
      if(r.top < window.innerHeight && r.bottom > 0) startAuto();
    }
  });
})();
(function(){
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  var PRODUCTS = [
    {
      id:'ns-66', name:'NS 66', tech:'VIP 3',
      tagline:'Elevado techo productivo con consistencia',
      seal:'Lanzamiento',
      photo:'srcManos',
      photoCap:'El grano se analiza <em>en la mano</em>',
      photoSub:'Lanzamiento · Parcela demostrativa',
      desc:[
        'El <b>lanzamiento</b> de Nidera: un precoz de grano duro que combina techo productivo, uniformidad de planta y espiga, y sanidad para planteos de <strong>alta tecnología</strong>.'
      ],
      fortalezas:[
        'Elevado <b>techo productivo</b> con consistencia.',
        'Responsivo al <b>manejo de alta tecnología</b>.',
        'Alto potencial de rendimiento en <b>diversas regiones</b>.',
        '<b>Uniformidad</b> de planta y espiga.',
        'Excelente <b>sanidad foliar</b> frente a las principales enfermedades.',
        'Óptima calidad de <b>tallo y raíz</b>.'
      ],
      specs:[
        ['Ciclo','Precoz'],
        ['Tipo de grano','Duro'],
        ['Color de grano','Amarillo anaranjado'],
        ['Exigencia en fertilidad','Media y alta'],
        ['Sanidad frente a','Mancha foliar · Cercosporiosis · Mancha blanca · Helmintosporiosis · Complejo de achaparramiento'],
        ['Tecnología','Viptera 3 (VIP 3)'],
        ['Disponibilidad','Red CIABAY · 8 sucursales']
      ],
      tags:['Lanzamiento','Precoz','Grano duro','Uniformidad']
    },
    {
      id:'ns-80', name:'NS 80', tech:'VIP 3',
      tagline:'Triple propósito más rentable',
      seal:'Aprobado para ensilaje',
      photo:'srcCosecha',
      photoCap:'El rinde se cosecha <em>a manos llenas</em>',
      photoSub:'NS 80 VIP 3 · Cosecha en campo paraguayo',
      desc:[
        '<b>NS 80</b> es el híbrido que rinde en todos los destinos: <strong>ensilaje, grano seco y grano húmedo</strong>, con la mejor relación costo-beneficio del mercado.'
      ],
      fortalezas:[
        'Excelente <b>relación costo-beneficio</b> del mercado.',
        '<b>Triple propósito</b>: ensilaje, grano seco y grano húmedo.',
        'Buen sistema de tallo, <b>resistente y firme</b>.',
        'Destacada <b>sanidad foliar</b>.',
        'Biotecnología VIP3: respaldo superior <b>contra orugas</b>.'
      ],
      specs:[
        ['Propósito','Ensilaje · grano seco · grano húmedo'],
        ['Perfil','Relación costo-beneficio'],
        ['Sistema de tallo','Resistente y firme'],
        ['Sanidad foliar','Destacada'],
        ['Tecnología','Viptera 3 (VIP 3)'],
        ['Disponibilidad','Red CIABAY · 8 sucursales']
      ],
      tags:['Triple propósito','Ensilaje','Costo-beneficio','Sanidad foliar']
    },
    {
      id:'ns-71', name:'NS 71', tech:'VIP 3',
      tagline:'Estabilidad y seguridad en todos los ambientes',
      seal:null,
      photo:'srcGrupo',
      photoCap:'El híbrido que <em>todos</em> preguntan',
      photoSub:'Día de campo · Recorrida técnica',
      desc:[
        '<b>NS 71</b> es la carta segura del portfolio: alta adaptación a diferentes ambientes sin resignar <strong>estabilidad productiva</strong>, con una arquitectura de planta pensada para aguantar todo el ciclo.'
      ],
      fortalezas:[
        'Alta adaptación en <b>diferentes ambientes</b>.',
        'Excelente padrón de espigas y <b>estabilidad productiva</b>.',
        'Gran arquitectura de tallo (<b>firme y resistente</b>) y raíz.',
        'Alta <b>tolerancia a cigarrita</b>.',
        'Biotecnología VIP3: respaldo superior <b>contra orugas</b>.'
      ],
      specs:[
        ['Cultivo','Maíz híbrido'],
        ['Perfil','Estabilidad y adaptación'],
        ['Arquitectura','Tallo y raíz firmes'],
        ['Tolerancia a cigarrita','Alta'],
        ['Tecnología','Viptera 3 (VIP 3)'],
        ['Disponibilidad','Red CIABAY · 8 sucursales']
      ],
      tags:['Adaptación','Estabilidad productiva','Tallo firme','Tolerancia a cigarrita']
    },
    {
      id:'ns-75', name:'NS 75', tech:'VIP 3',
      tagline:'Versatilidad temprana con máximo rendimiento',
      seal:'Híbrido de mayor adaptación',
      photo:'srcBolsa',
      photoCap:'La bolsa que <em>siempre</em> cumple',
      photoSub:'Nidera Maíz · Campaña tras campaña',
      desc:[
        '<b>NS 75</b> combina ciclo precoz-rápido con máximo rendimiento: versatilidad temprana, <strong>calidad superior de granos</strong> y el sello de híbrido de mayor adaptación.'
      ],
      fortalezas:[
        'Ciclo precoz-rápido, con <b>alto potencial</b> productivo.',
        'Estabilidad combinada con <b>rendimiento sobresaliente</b>.',
        'Excelente <b>estructura de tallo</b> y sanidad de hojas.',
        '<b>Calidad superior</b> de granos.',
        'Alta <b>tolerancia a cigarrita</b>.',
        'Biotecnología VIP3: respaldo superior <b>contra orugas</b>.'
      ],
      specs:[
        ['Ciclo','Precoz-rápido'],
        ['Perfil','Versátil · alto potencial'],
        ['Calidad de grano','Superior'],
        ['Tolerancia a cigarrita','Alta'],
        ['Tecnología','Viptera 3 (VIP 3)'],
        ['Disponibilidad','Red CIABAY · 8 sucursales']
      ],
      tags:['Precoz-rápido','Mayor adaptación','Calidad de grano','Rendimiento']
    }
  ];

  var pd = document.getElementById('pd');
  var lastRow = null;

  function findProduct(hash){
    for(var i=0;i<PRODUCTS.length;i++){
      if('producto-'+PRODUCTS[i].id === hash) return i;
    }
    return -1;
  }

  function render(i){
    var p = PRODUCTS[i];
    var prev = PRODUCTS[(i-1+PRODUCTS.length)%PRODUCTS.length];
    var next = PRODUCTS[(i+1)%PRODUCTS.length];
    var img = document.getElementById(p.photo);
    var descHtml = p.desc.map(function(d){ return '<p>'+d+'</p>'; }).join('');
    var specsHtml = p.specs.map(function(s){
      return '<div class="pd-spec"><div class="k">'+s[0]+'</div><div class="v">'+s[1]+'</div></div>';
    }).join('');
    var tagsHtml = p.tags.map(function(t){ return '<span class="tag">'+t+'</span>'; }).join('');
    var sealHtml = p.seal ? '<div class="pd-seal">'+p.seal+'</div>' : '';
    var fortHtml = '<div class="pd-fort"><div class="ft">→ Fortalezas del híbrido</div><ul>'+
      p.fortalezas.map(function(f){ return '<li>'+f+'</li>'; }).join('')+'</ul></div>';

    pd.innerHTML =
      '<div class="wrap pd-wrap">'+
        '<div class="pd-top pd-anim">'+
          '<button class="pd-back" id="pdBack">← Volver al portfolio</button>'+
          '<div class="pd-crumb">Nidera Maíz <i>·</i> Portfolio <i>·</i> '+p.name+'</div>'+
        '</div>'+
        '<div class="pd-grid">'+
          '<div class="pd-info pd-anim d1">'+
            '<div class="pd-eyebrow">Nidera Maíz · Híbrido '+('0'+(i+1))+'</div>'+
            '<h1><b>'+p.name+'</b><span>'+p.tech+'</span></h1>'+
            '<div class="pd-tagline">'+p.tagline+'</div>'+
            sealHtml+
            '<div class="pd-desc">'+descHtml+'</div>'+
            fortHtml+
            '<div class="tags">'+tagsHtml+'</div>'+
            '<div class="pd-specs">'+specsHtml+'</div>'+
            '<div class="pd-cta">'+
              '<a class="btn" href="https://wa.me/595983105077?text='+
                encodeURIComponent('¡Hola! Quiero consultar disponibilidad del híbrido '+p.name+' '+p.tech+' de Nidera Maíz.')+
                '" target="_blank" rel="noopener"><svg viewBox=\'0 0 24 24\' aria-hidden=\'true\'><path d=\'M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.149-.174.198-.298.297-.497.1-.198.05-.371-.025-.52-.074-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z\'/></svg>Consultar disponibilidad →</a>'+
              '<div class="note">Ficha técnica completa y densidad recomendada por zona: con tu asesor CIABAY.</div>'+
            '</div>'+
          '</div>'+
          '<div class="pd-photo pd-anim d2">'+
            '<div class="ph">'+
              '<img decoding="async" src="'+img.src+'" alt="'+p.name+' '+p.tech+' — Nidera Maíz">'+
              '<div class="badges"><span class="badge green">'+p.name+' '+p.tech+'</span><span class="badge">Nidera Maíz</span></div>'+
              '<div class="ph-cap"><b>'+p.photoCap+'</b>'+p.photoSub+'</div>'+
            '</div>'+
          '</div>'+
        '</div>'+
        '<div class="pd-nav pd-anim d2">'+
          '<a href="#producto-'+prev.id+'"><div class="dir">← Anterior</div><div class="pn">'+prev.name+' '+prev.tech+'</div></a>'+
          '<a class="nx" href="#producto-'+next.id+'"><div class="dir">Siguiente →</div><div class="pn">'+next.name+' '+next.tech+'</div></a>'+
        '</div>'+
      '</div>';

    document.getElementById('pdBack').addEventListener('click', function(){
      location.hash = 'hibridos';
    });
  }

  function openPd(i){
    render(i);
    pd.classList.add('open');
    pd.classList.remove('in');
    document.body.style.overflow = 'hidden';
    pd.scrollTop = 0;
    if(reduce){ pd.classList.add('in'); }
    else{
      requestAnimationFrame(function(){ requestAnimationFrame(function(){ pd.classList.add('in'); }); });
    }
    var back = document.getElementById('pdBack');
    if(back) back.focus({preventScroll:true});
  }

  function closePd(){
    if(!pd.classList.contains('open')) return;
    pd.classList.remove('open','in');
    document.body.style.overflow = '';
    if(lastRow){ lastRow.focus({preventScroll:true}); lastRow = null; }
  }

  function route(){
    var h = location.hash.replace('#','');
    var i = findProduct(h);
    if(i >= 0){ openPd(i); } else { closePd(); }
  }

  window.addEventListener('hashchange', route);

  document.querySelectorAll('.prod-row').forEach(function(row){
    row.addEventListener('click', function(){ lastRow = row; });
  });

  document.addEventListener('keydown', function(e){
    if(e.key === 'Escape' && pd.classList.contains('open')){
      location.hash = 'hibridos';
    }
  });

  route(); /* deep-link: #producto-ns-66 abre directo */
})();
/* ═══════════ Lluvia de granos de maíz (hero) ═══════════ */
(function(){
  var canvas = document.getElementById('kernCanvas');
  var hero = document.getElementById('hero');
  if(!canvas || !hero) return;
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var ctx = canvas.getContext('2d');
  var dpr = Math.min(2, window.devicePixelRatio || 1);
  var W = 0, H = 0, fadeEnd = 0, spawnTop = 0, parts = [], running = false, raf = null, t = 0;
  var COLORS = [
    ['#f6c445','#d99a17'], ['#f2b52a','#c98a12'],
    ['#ffd76a','#e0a51e'], ['#eda820','#b97f0e']
  ];

  function size(){
    W = hero.clientWidth; H = hero.clientHeight;
    canvas.width = W*dpr; canvas.height = H*dpr;
    canvas.style.width = W+'px'; canvas.style.height = H+'px';
    ctx.setTransform(dpr,0,0,dpr,0,0);
    var strip = hero.querySelector('.hero-strip');
    if(strip){
      var hr = hero.getBoundingClientRect(), sr = strip.getBoundingClientRect();
      spawnTop = (sr.bottom - hr.top) + 4;
    } else { spawnTop = 0; }
    fadeEnd = H - 4;
  }
  function spawn(init){
    var s = 4 + Math.random()*7;
    return {
      x: Math.random()*W,
      y: init ? spawnTop + Math.random()*Math.max(40, fadeEnd - spawnTop) : spawnTop - 18,
      s: s,
      v: .35 + Math.random()*.85,
      r: Math.random()*Math.PI*2,
      vr: (Math.random()-.5)*.03,
      ph: Math.random()*Math.PI*2,
      c: COLORS[(Math.random()*COLORS.length)|0]
    };
  }
  /* diente de maíz: redondeado arriba, punta abajo */
  function kernel(p){
    ctx.save(); ctx.translate(p.x,p.y); ctx.rotate(p.r);
    var g = ctx.createLinearGradient(0,-p.s,0,p.s);
    g.addColorStop(0,p.c[0]); g.addColorStop(1,p.c[1]);
    ctx.fillStyle = g;
    ctx.beginPath();
    ctx.moveTo(0, p.s);
    ctx.quadraticCurveTo(p.s*.95, p.s*.15, p.s*.6, -p.s*.7);
    ctx.quadraticCurveTo(0, -p.s*1.05, -p.s*.6, -p.s*.7);
    ctx.quadraticCurveTo(-p.s*.95, p.s*.15, 0, p.s);
    ctx.fill();
    ctx.restore();
  }
  function draw(step){
    ctx.clearRect(0,0,W,H);
    for(var i=0;i<parts.length;i++){
      var p = parts[i];
      if(step){
        p.y += p.v;
        p.x += Math.sin(t*.015 + p.ph)*.35;
        p.r += p.vr;
        if(p.y > fadeEnd){ parts[i] = spawn(false); continue; }
      }
      var a = 1;
      if(p.y < spawnTop + 28) a = Math.max(0, (p.y - (spawnTop - 18))/46);
      var fs = fadeEnd - 70;
      if(p.y > fs) a = Math.min(a, Math.max(0, 1-(p.y-fs)/70));
      ctx.globalAlpha = a*.85;
      kernel(p);
    }
    ctx.globalAlpha = 1;
  }
  var last = 0;
  function frame(ts){
    if(!running) return;
    raf = requestAnimationFrame(frame);
    if(ts - last < 33) return;   /* ~30fps */
    last = ts;
    t++;
    draw(true);
  }
  function start(){ if(running || reduce) return; running = true; raf = requestAnimationFrame(frame); }
  function stop(){ running = false; if(raf) cancelAnimationFrame(raf); }
  function init(){
    size();
    var count = Math.min(56, Math.max(20, Math.round(W/26)));
    parts = [];
    for(var i=0;i<count;i++) parts.push(spawn(true));
    if(reduce) draw(false); /* siembra estática, sin animación */
  }
  init();
  window.addEventListener('resize', init);
  if(!reduce){
    var io = new IntersectionObserver(function(es){
      es.forEach(function(e){ e.isIntersecting ? start() : stop(); });
    });
    io.observe(hero);
    document.addEventListener('visibilitychange', function(){
      if(document.hidden){ stop(); }
      else{
        var r = hero.getBoundingClientRect();
        if(r.bottom > 0 && r.top < window.innerHeight) start();
      }
    });
  }
})();
/* ═══════════ Progreso de lectura + parallax del hero ═══════════ */
(function(){
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var fill = document.getElementById('spFill');
  var wrap = null, img = null; /* parallax retirado junto con la foto panorámica */
  var ticking = false;
  function update(){
    ticking = false;
    if(fill){
      var max = document.documentElement.scrollHeight - window.innerHeight;
      var p = max>0 ? (window.scrollY || document.documentElement.scrollTop)/max : 0;
      fill.style.transform = 'scaleX(' + Math.min(1, Math.max(0, p)) + ')';
    }
    if(img && !reduce){
      var r = wrap.getBoundingClientRect();
      if(r.bottom > 0 && r.top < window.innerHeight){
        var c = (r.top + r.height/2 - window.innerHeight/2) / (window.innerHeight/2);
        var ty = Math.max(-1, Math.min(1, c)) * -16;
        img.style.transform = 'translateY(' + ty.toFixed(1) + 'px) scale(1.08)';
      }
    }
  }
  function onScroll(){ if(!ticking){ ticking = true; requestAnimationFrame(update); } }
  window.addEventListener('scroll', onScroll, {passive:true});
  window.addEventListener('resize', onScroll, {passive:true});
  update();
})();
})();
