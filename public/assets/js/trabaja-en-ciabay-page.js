/* Generado desde nuevo_trabaja_en_ciabay.html — envuelto en IIFE para no contaminar
   el scope global del sitio. */
(function () {
(function(){
  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---- Animaciones de entrada ---- */
  var rvs = document.querySelectorAll('.rv');
  if(reduced || !('IntersectionObserver' in window)){
    rvs.forEach(function(el){ el.classList.add('in'); });
  } else {
    var io = new IntersectionObserver(function(entries){
      entries.forEach(function(e){
        if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target); }
      });
    },{threshold:.14, rootMargin:'0px 0px -6% 0px'});
    rvs.forEach(function(el){ io.observe(el); });
  }

  /* ---- Contadores de stats ---- */
  var counters = document.querySelectorAll('[data-count]');
  function animate(el){
    var target = parseInt(el.getAttribute('data-count'),10);
    if(reduced){ el.textContent = target; return; }
    var dur = 1100, t0 = null;
    function frame(t){
      if(!t0) t0 = t;
      var p = Math.min((t - t0)/dur, 1);
      var eased = 1 - Math.pow(1 - p, 3);
      el.textContent = Math.round(target * eased);
      if(p < 1) requestAnimationFrame(frame);
    }
    requestAnimationFrame(frame);
  }
  /* ---- Tooltips al tocar (móvil) ---- */
  document.querySelectorAll('.stat').forEach(function(st){
    st.addEventListener('click', function(){
      var was = st.classList.contains('show');
      document.querySelectorAll('.stat.show').forEach(function(s){ s.classList.remove('show'); });
      if(!was) st.classList.add('show');
    });
  });
  document.addEventListener('click', function(e){
    if(!e.target.closest('.stat')){
      document.querySelectorAll('.stat.show').forEach(function(s){ s.classList.remove('show'); });
    }
  });

  if(!('IntersectionObserver' in window)){
    counters.forEach(function(el){ el.textContent = el.getAttribute('data-count'); });
  } else {
    var io2 = new IntersectionObserver(function(entries){
      entries.forEach(function(e){
        if(e.isIntersecting){ animate(e.target); io2.unobserve(e.target); }
      });
    },{threshold:.5});
    counters.forEach(function(el){ io2.observe(el); });
  }
})();
})();
