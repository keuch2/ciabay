/* Generado desde nuevo_repuestos.html — envuelto en IIFE para no contaminar
   el scope global del sitio. */
(function () {
(function(){
  "use strict";
  var RM = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---------- animaciones de entrada con escalonado ---------- */
  var rvEls = Array.prototype.slice.call(document.querySelectorAll('.rv'));
  document.querySelectorAll('[data-stagger]').forEach(function(group){
    Array.prototype.forEach.call(group.querySelectorAll('.rv'), function(el, i){
      el.style.transitionDelay = (i * 85) + 'ms';
    });
  });
  if (RM || !('IntersectionObserver' in window)) {
    rvEls.forEach(function(el){ el.classList.add('in'); });
  } else {
    var io = new IntersectionObserver(function(entries){
      entries.forEach(function(en){
        if (en.isIntersecting){ en.target.classList.add('in'); io.unobserve(en.target); }
      });
    }, {threshold:.15, rootMargin:'0px 0px -6% 0px'});
    rvEls.forEach(function(el){ io.observe(el); });
  }

  /* ---------- contadores ---------- */
  function easeOutCubic(t){ return 1 - Math.pow(1 - t, 3); }
  function runCounter(el){
    var target = parseInt(el.getAttribute('data-n'), 10);
    if (RM){ el.textContent = target; return; }
    var t0 = null, DUR = 1100;
    function step(ts){
      if (!t0) t0 = ts;
      var p = Math.min((ts - t0) / DUR, 1);
      el.textContent = Math.round(easeOutCubic(p) * target);
      if (p < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }
  var cnts = document.querySelectorAll('.cnt');
  if (RM || !('IntersectionObserver' in window)) {
    cnts.forEach(runCounter);
  } else {
    var ioC = new IntersectionObserver(function(entries){
      entries.forEach(function(en){
        if (en.isIntersecting){ runCounter(en.target); ioC.unobserve(en.target); }
      });
    }, {threshold:.4});
    cnts.forEach(function(el){ ioC.observe(el); });
  }

  /* ---------- tooltips (hover + focus + tap) ---------- */
  var stats = Array.prototype.slice.call(document.querySelectorAll('.stat'));
  stats.forEach(function(st){
    st.addEventListener('click', function(e){
      var open = st.classList.contains('open');
      stats.forEach(function(s){ s.classList.remove('open'); });
      if (!open) st.classList.add('open');
      e.stopPropagation();
    });
  });
  document.addEventListener('click', function(){
    stats.forEach(function(s){ s.classList.remove('open'); });
  });



  /* ---------- apertura del buscador real integrado ---------- */
  var iframePanel = document.getElementById('iframeRepuesto');
  var iframeButton = document.querySelector('[data-open-iframe]');
  var iframeClose = document.querySelector('[data-close-iframe]');
  var iframeBtnLabel = iframeButton ? iframeButton.querySelector('[data-btn-label]') : null;
  var buscadorBox = document.querySelector('.buscador');

  function openIframePanel(e){
    if (e) e.preventDefault();
    if (!iframePanel || !iframeButton) return;
    if (buscadorBox) buscadorBox.classList.add('iframe-active');
    iframePanel.classList.add('open');
    iframePanel.setAttribute('aria-hidden','false');
    iframeButton.setAttribute('aria-expanded','true');
    iframeButton.classList.add('is-open');
    if (iframeBtnLabel) iframeBtnLabel.textContent = 'Buscador online abierto';
    /* Mantiene la posición actual: no forzamos scroll al abrir el iframe. */
  }

  function closeIframePanel(){
    if (!iframePanel || !iframeButton) return;
    iframePanel.classList.remove('open');
    iframePanel.setAttribute('aria-hidden','true');
    iframeButton.setAttribute('aria-expanded','false');
    iframeButton.classList.remove('is-open');
    if (buscadorBox) buscadorBox.classList.remove('iframe-active');
    if (iframeBtnLabel) iframeBtnLabel.textContent = 'Abrir el buscador online';
    iframeButton.focus({preventScroll:true});
  }

  if (iframeButton && iframePanel){
    iframeButton.addEventListener('click', openIframePanel);
  }
  if (iframeClose){
    iframeClose.addEventListener('click', closeIframePanel);
  }

  /* ---------- tabla de contactos de vendedores ---------- */
  var contactToggle = document.querySelector('[data-contact-toggle]');
  var contactTable = document.getElementById('contactTable');
  if (contactToggle && contactTable){
    contactToggle.addEventListener('click', function(e){
      e.preventDefault();
      var isOpen = contactTable.classList.toggle('open');
      contactTable.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
      contactToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
  }

  /* ---------- carrusel ---------- */
  var track = document.getElementById('track');
  var slides = Array.prototype.slice.call(track.querySelectorAll('.slide'));
  var railFill = document.getElementById('railFill');
  var carFill = document.getElementById('carFill');
  var rail = document.querySelector('.rail');
  var N = slides.length;

  // nodos del riel
  var nodes = [];
  for (var i = 0; i < N; i++){
    var nd = document.createElement('div');
    nd.className = 'rail-node';
    nd.style.left = (N > 1 ? (i / (N - 1)) * 100 : 0) + '%';
    rail.appendChild(nd);
    nodes.push(nd);
  }

  function updateCar(){
    var max = track.scrollWidth - track.clientWidth;
    var p = max > 0 ? track.scrollLeft / max : 0;
    railFill.style.width = (p * 100) + '%';
    carFill.style.width = (p * 100) + '%';
    nodes.forEach(function(nd, i){
      var pos = N > 1 ? i / (N - 1) : 0;
      nd.classList.toggle('on', p >= pos - 0.03);
    });
    // tarjeta más cercana al centro
    var center = track.scrollLeft + track.clientWidth / 2;
    var best = null, bestD = Infinity;
    slides.forEach(function(sl){
      var c = sl.offsetLeft + sl.offsetWidth / 2;
      var d = Math.abs(c - center);
      if (d < bestD){ bestD = d; best = sl; }
    });
    slides.forEach(function(sl){ sl.classList.toggle('is-center', sl === best); });
  }
  var ticking = false;
  track.addEventListener('scroll', function(){
    if (!ticking){
      requestAnimationFrame(function(){ updateCar(); ticking = false; });
      ticking = true;
    }
  });
  window.addEventListener('resize', updateCar);
  updateCar();

  function stepSize(){
    return slides[0].offsetWidth + 26;
  }
  document.getElementById('prevBtn').addEventListener('click', function(){
    track.scrollBy({left: -stepSize(), behavior: RM ? 'auto' : 'smooth'});
  });
  document.getElementById('nextBtn').addEventListener('click', function(){
    track.scrollBy({left: stepSize(), behavior: RM ? 'auto' : 'smooth'});
  });

  // arrastre con mouse
  var isDown = false, startX = 0, startSL = 0, moved = false;
  track.addEventListener('pointerdown', function(e){
    if (e.pointerType !== 'mouse') return;
    isDown = true; moved = false;
    startX = e.clientX; startSL = track.scrollLeft;
    track.classList.add('dragging');
  });
  window.addEventListener('pointermove', function(e){
    if (!isDown) return;
    var dx = e.clientX - startX;
    if (Math.abs(dx) > 4) moved = true;
    track.scrollLeft = startSL - dx;
  });
  window.addEventListener('pointerup', function(){
    if (!isDown) return;
    isDown = false;
    track.classList.remove('dragging');
  });
  track.addEventListener('click', function(e){
    if (moved){ e.preventDefault(); e.stopPropagation(); moved = false; }
  }, true);

  /* ---------- buscador demostrativo ---------- */
  var DEMO = [
    { q:'FILTRO DE ACEITE CASE IH', rows:[
      ['84228510','CNH','Filtro de aceite motor — Puma / Magnum','ok'],
      ['84475542','CNH','Filtro de combustible — Axial-Flow','ok'],
      ['47131194','CNH','Filtro hidráulico — Farmall / Puma','ped']
    ]},
    { q:'ACEITE AKCELA HY-TRAN 20L', rows:[
      ['73344282','AKCELA','Hy-Tran Ultraction 20L — multifuncional','ok'],
      ['73344283','AKCELA','No.1 Engine Oil SAE 15W-40 · 20L','ok'],
      ['73344309','AKCELA','Nexplore MAT 3525 · 20L','ok']
    ]},
    { q:'CORREA TIMKEN COSECHADORA', rows:[
      ['TB-4L480','TIMKEN','Correa de transmisión — cosechadoras','ok'],
      ['TB-5V850','TIMKEN','Correa industrial 5V — alta carga','ok'],
      ['TB-BX62','TIMKEN','Correa dentada BX — tractores','ped']
    ]},
    { q:'DISCO 22" SEMBRADORA', rows:[
      ['DT-2226','TATU','Disco liso 22" × 6 mm — sembradoras','ok'],
      ['DT-2026','TATU','Disco desencontrado 20"','ok'],
      ['VT-1804','VENCE TUDO','Disco de corte 18" — plantadoras','ok']
    ]}
  ];
  var qEl = document.getElementById('typeQ');
  var body = document.getElementById('btBody');

  function rowHTML(r){
    var disp = r[3] === 'ok'
      ? '<span class="disp ok"><b></b>En stock</span>'
      : '<span class="disp ped"><b></b>A pedido</span>';
    return '<div class="bt-row bt-r">' +
      '<span class="cod">' + r[0] + '</span>' +
      '<span class="fab">' + r[1] + '</span>' +
      '<span class="des">' + r[2] + '</span>' + disp + '</div>';
  }
  function renderRows(rows, animate){
    body.innerHTML = rows.map(rowHTML).join('');
    var rEls = body.querySelectorAll('.bt-r');
    if (!animate){
      rEls.forEach(function(el){ el.classList.add('show'); });
      return;
    }
    rEls.forEach(function(el, i){
      setTimeout(function(){ el.classList.add('show'); }, 120 + i * 90);
    });
  }

  if (RM) {
    qEl.textContent = DEMO[0].q;
    renderRows(DEMO[0].rows, false);
    document.getElementById('typeCaret').style.display = 'none';
  } else {
    var di = 0;
    function cycle(){
      var d = DEMO[di];
      var txt = d.q, ci = 0;
      qEl.textContent = '';
      body.querySelectorAll('.bt-r').forEach(function(el){ el.classList.remove('show'); });
      setTimeout(function(){ body.innerHTML = ''; }, 300);
      function typeCh(){
        if (ci <= txt.length){
          qEl.textContent = txt.slice(0, ci);
          ci++;
          setTimeout(typeCh, 46 + Math.random() * 40);
        } else {
          setTimeout(function(){ renderRows(d.rows, true); }, 260);
          setTimeout(function(){
            di = (di + 1) % DEMO.length;
            cycle();
          }, 4600);
        }
      }
      setTimeout(typeCh, 420);
    }
    cycle();
  }
})();
})();
