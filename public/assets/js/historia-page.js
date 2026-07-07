/* Generado desde nuevo_historia.html — envuelto en IIFE para no contaminar
   el scope global del sitio. */
(function () {
/* ============================================================
   JS vanilla — comparador AYER/HOY, línea de tiempo horizontal,
   filtros por era, animaciones de entrada
   ============================================================ */
(function(){
  "use strict";
  var reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  var track = document.getElementById("timeline");
  var milestones = Array.prototype.slice.call(track.querySelectorAll(".milestone"));

  /* ---------- Entrada escalonada ---------- */
  var revealables = milestones.concat(Array.prototype.slice.call(document.querySelectorAll(".vcard")));
  if (reduceMotion || !("IntersectionObserver" in window)){
    revealables.forEach(function(el){ el.classList.add("in"); });
  } else {
    var io = new IntersectionObserver(function(entries){
      entries.forEach(function(entry){
        if (entry.isIntersecting){
          var el = entry.target;
          var siblings = Array.prototype.slice.call(el.parentNode.children)
            .filter(function(s){ return !s.classList.contains("hidden-era"); });
          var idx = siblings.indexOf(el);
          el.style.transitionDelay = Math.min(idx % 4, 3) * 80 + "ms";
          el.classList.add("in");
          io.unobserve(el);
        }
      });
    },{ threshold: .15, rootMargin: "0px 0px -5% 0px" });
    revealables.forEach(function(el){ io.observe(el); });
  }

  /* ---------- Línea de tiempo horizontal ---------- */
  var prevBtn = document.getElementById("tlPrev");
  var nextBtn = document.getElementById("tlNext");
  var bar = document.getElementById("tlBar");

  function cardStep(){
    var first = milestones.filter(function(m){ return !m.classList.contains("hidden-era"); })[0];
    return first ? first.getBoundingClientRect().width + 22 : 360;
  }
  var railFill = document.getElementById("railFill");
  var tlRaf = null;
  function updateTl(){
    if (tlRaf) return;
    tlRaf = requestAnimationFrame(function(){
      tlRaf = null;
      var max = track.scrollWidth - track.clientWidth;
      var x = track.scrollLeft;
      prevBtn.disabled = x <= 4;
      nextBtn.disabled = x >= max - 4;
      var pct = max > 0 ? Math.min(100, Math.max(0, x / max * 100)) : 100;
      bar.style.width = pct + "%";

      /* nodos encendidos + riel pintado hasta el último nodo pasado + tarjeta en foco */
      var visibles = milestones.filter(function(m){ return !m.classList.contains("hidden-era"); });
      var frente = x + track.clientWidth * 0.5;
      if (max <= 4 || x >= max - 4) frente = Infinity;   /* al final, todo encendido */
      var centro = x + track.clientWidth * 0.5;
      var mejor = null, mejorDist = Infinity, ultimoNodo = 0;
      visibles.forEach(function(m){
        var nodo = m.offsetLeft + 8;
        var pasado = nodo <= frente;
        m.classList.toggle("passed", pasado);
        if (pasado && nodo > ultimoNodo) ultimoNodo = nodo;
        var d = Math.abs(m.offsetLeft + m.offsetWidth / 2 - centro);
        if (d < mejorDist){ mejorDist = d; mejor = m; }
      });
      if (railFill) railFill.style.width = Math.max(0, Math.min(track.scrollWidth, ultimoNodo) - x) > 0
        ? Math.min(track.clientWidth, ultimoNodo - x) + "px" : "0px";
      visibles.forEach(function(m){ m.classList.toggle("focus", m === mejor); });
    });
  }
  prevBtn.addEventListener("click", function(){ track.scrollBy({ left: -cardStep(), behavior: reduceMotion ? "auto" : "smooth" }); });
  nextBtn.addEventListener("click", function(){ track.scrollBy({ left: cardStep(), behavior: reduceMotion ? "auto" : "smooth" }); });
  track.addEventListener("scroll", updateTl, { passive: true });
  window.addEventListener("resize", updateTl);
  track.addEventListener("keydown", function(e){
    if (e.key === "ArrowRight"){ e.preventDefault(); nextBtn.click(); }
    if (e.key === "ArrowLeft"){ e.preventDefault(); prevBtn.click(); }
  });

  /* Arrastre con mouse (touch usa scroll nativo) */
  var dragging = false, wasDrag = false, startX = 0, startScroll = 0;
  track.addEventListener("pointerdown", function(e){
    if (e.pointerType !== "mouse" || e.button !== 0) return;
    dragging = true; wasDrag = false;
    startX = e.clientX; startScroll = track.scrollLeft;
  });
  window.addEventListener("pointermove", function(e){
    if (!dragging) return;
    var dx = e.clientX - startX;
    if (Math.abs(dx) > 6){ wasDrag = true; track.classList.add("dragging"); }
    if (wasDrag) track.scrollLeft = startScroll - dx;
  });
  window.addEventListener("pointerup", function(){
    if (!dragging) return;
    dragging = false;
    setTimeout(function(){ track.classList.remove("dragging"); wasDrag = false; }, 0);
  });
  track.addEventListener("click", function(e){
    if (wasDrag){ e.preventDefault(); e.stopPropagation(); }
  }, true);

  /* ---------- Chips: filtro por era ---------- */
  var chips = document.querySelectorAll("#chips .chip");
  chips.forEach(function(chip){
    chip.addEventListener("click", function(){
      chips.forEach(function(c){ c.classList.remove("active"); });
      chip.classList.add("active");
      var era = chip.getAttribute("data-era");
      milestones.forEach(function(m){
        var show = (era === "all") || (m.getAttribute("data-era") === era);
        m.classList.toggle("hidden-era", !show);
        if (show) m.classList.add("in");
      });
      track.scrollTo({ left: 0, behavior: "auto" });
      updateTl();
    });
  });

  /* ---------- Botón → : expandir detalle ---------- */
  document.querySelectorAll(".more").forEach(function(btn){
    btn.addEventListener("click", function(){
      var card = btn.closest(".card");
      var open = card.classList.toggle("open");
      btn.setAttribute("aria-expanded", open ? "true" : "false");
    });
  });

  updateTl();

  /* ============================================================
     COMPARADOR AYER / HOY
     ============================================================ */
  var cmp = document.getElementById("compare");
  var handle = document.getElementById("cmpHandle");
  if (cmp && handle){
    var pos = 90;
    function setPos(p){
      pos = Math.max(4, Math.min(96, p));
      cmp.style.setProperty("--pos", pos + "%");
      handle.setAttribute("aria-valuenow", Math.round(pos));
    }
    function posFromEvent(e){
      var r = cmp.getBoundingClientRect();
      setPos((e.clientX - r.left) / r.width * 100);
    }
    var cmpDown = false;
    cmp.addEventListener("pointerdown", function(e){
      cmpDown = true;
      cmp.setPointerCapture(e.pointerId);
      posFromEvent(e);
    });
    cmp.addEventListener("pointermove", function(e){ if (cmpDown) posFromEvent(e); });
    cmp.addEventListener("pointerup", function(){ cmpDown = false; });
    cmp.addEventListener("pointercancel", function(){ cmpDown = false; });
    handle.addEventListener("keydown", function(e){
      if (e.key === "ArrowLeft"){ e.preventDefault(); setPos(pos - 4); }
      if (e.key === "ArrowRight"){ e.preventDefault(); setPos(pos + 4); }
      if (e.key === "Home"){ e.preventDefault(); setPos(4); }
      if (e.key === "End"){ e.preventDefault(); setPos(96); }
    });

    /* Barrido de presentación al entrar en pantalla */
    if (reduceMotion){
      setPos(50);
    } else if ("IntersectionObserver" in window){
      var swept = false;
      var cio = new IntersectionObserver(function(entries){
        entries.forEach(function(entry){
          if (entry.isIntersecting && !swept){
            swept = true; cio.disconnect();
            var t0 = null, from = 90, to = 50, dur = 1300;
            function ease(t){ return t < .5 ? 4*t*t*t : 1 - Math.pow(-2*t + 2, 3) / 2; }
            function step(ts){
              if (cmpDown) return;               /* el usuario tomó el control */
              if (!t0) t0 = ts;
              var k = Math.min(1, (ts - t0) / dur);
              setPos(from + (to - from) * ease(k));
              if (k < 1) requestAnimationFrame(step);
            }
            setTimeout(function(){ requestAnimationFrame(step); }, 350);
          }
        });
      },{ threshold: .45 });
      cio.observe(cmp);
    } else {
      setPos(50);
    }
  }
})();
})();
