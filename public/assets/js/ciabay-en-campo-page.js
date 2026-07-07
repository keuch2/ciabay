/* Generado desde nuevo_ciabay_en_campo.html — envuelto en IIFE para no contaminar
   el scope global del sitio. */
(function () {
(function(){
  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---------- animaciones de entrada ---------- */
  var revs = document.querySelectorAll('.rev');
  if(reduced){ revs.forEach(function(el){ el.classList.add('in'); }); }
  else{
    var io = new IntersectionObserver(function(entries){
      entries.forEach(function(e){
        if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target); }
      });
    },{threshold:.12, rootMargin:'0px 0px -6% 0px'});
    revs.forEach(function(el){ io.observe(el); });
  }

  /* ---------- carrusel con riel ---------- */
  var track = document.getElementById('carTrack');
  if(!track) return;
  var cards = Array.prototype.slice.call(track.children);
  var rail  = document.getElementById('rail');
  var fill  = document.getElementById('railFill');
  var prog  = document.getElementById('carProg');
  var prev  = document.getElementById('carPrev');
  var next  = document.getElementById('carNext');

  /* nodos del riel */
  var nodes = cards.map(function(_,i){
    var n = document.createElement('div');
    n.className = 'rail-node';
    n.style.left = (cards.length>1 ? (i/(cards.length-1))*100 : 0) + '%';
    rail.appendChild(n);
    return n;
  });

  function update(){
    var max = track.scrollWidth - track.clientWidth;
    var p = max>0 ? track.scrollLeft/max : 0;
    fill.style.width = (p*100)+'%';
    prog.style.width = (p*100)+'%';
    nodes.forEach(function(n,i){
      var t = cards.length>1 ? i/(cards.length-1) : 0;
      n.classList.toggle('on', p >= t - 0.02);
    });
    /* tarjeta más cercana al centro */
    var center = track.scrollLeft + track.clientWidth/2, best=0, bd=Infinity;
    cards.forEach(function(c,i){
      var cc = c.offsetLeft + c.offsetWidth/2, d = Math.abs(cc-center);
      if(d<bd){bd=d;best=i;}
    });
    cards.forEach(function(c,i){ c.classList.toggle('active', i===best); });
  }
  track.addEventListener('scroll', update, {passive:true});
  window.addEventListener('resize', update);
  update();

  function step(dir){
    var w = cards[0].offsetWidth + 22;
    track.scrollBy({left:dir*w, behavior: reduced?'auto':'smooth'});
  }
  prev.addEventListener('click', function(){ step(-1); });
  next.addEventListener('click', function(){ step(1); });

  /* arrastre con mouse */
  var down=false, startX=0, startL=0, moved=false;
  track.addEventListener('pointerdown', function(e){
    if(e.pointerType!=='mouse') return;
    down=true; moved=false; startX=e.clientX; startL=track.scrollLeft;
    track.setPointerCapture(e.pointerId);
  });
  track.addEventListener('pointermove', function(e){
    if(!down) return;
    var dx = e.clientX-startX;
    if(Math.abs(dx)>4){ moved=true; track.classList.add('dragging'); }
    track.scrollLeft = startL - dx;
  });
  function up(e){
    if(!down) return;
    down=false; track.classList.remove('dragging');
  }
  track.addEventListener('pointerup', up);
  track.addEventListener('pointercancel', up);
  track.addEventListener('click', function(e){ if(moved){ e.preventDefault(); moved=false; } }, true);

  /* me gusta en los posts */
  document.querySelectorAll('.sm-like').forEach(function(btn){
    btn.addEventListener('click', function(){
      var on = btn.classList.toggle('on');
      var b = btn.closest('.car-card').querySelector('.sm-likes b');
      if(!b) return;
      var n = parseInt(b.textContent.replace(/\./g,''),10) || 0;
      n = on ? n+1 : n-1;
      b.textContent = n.toLocaleString('es-PY');
      btn.setAttribute('aria-pressed', on ? 'true' : 'false');
    });
  });
})();
})();
