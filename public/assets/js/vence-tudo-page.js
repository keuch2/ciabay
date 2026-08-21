/* Generado desde nuevo-vence-tudo.html — envuelto en IIFE para no contaminar
   el scope global del sitio. Las imágenes/video/audio llegan vía window.VT_MEDIA
   (generado con asset() en el Blade). */
(function () {

/* La barra de categorías (sticky) arranca debajo del header del sitio. */
const __hdr = document.querySelector('.main-header');
const __setHdr = () => document.documentElement.style.setProperty('--vt-header-h', (__hdr ? __hdr.offsetHeight : 0) + 'px');
__setHdr();
window.addEventListener('resize', __setHdr, {passive: true});
/* ============================================================
   IMÁGENES de producto — claves: sembradoras, cabezal, tolvas, clasificador
   ASSETS — eagle (png/webp recortado), snd (mp3 del grito)
   ============================================================ */
const IMGS = (window.VT_MEDIA || {}).imgs || {};
const ASSETS = (window.VT_MEDIA || {}).assets || {};

document.querySelectorAll('[data-img]').forEach(img=>{
  const k=img.dataset.img;
  if(IMGS[k]){ img.src=IMGS[k]; const p=img.closest('.panel.pendiente'); if(p) p.classList.add('has'); }
  else img.remove();
});
document.querySelectorAll('[data-asset]').forEach(i=>{ if(ASSETS[i.dataset.asset]) i.src=ASSETS[i.dataset.asset]; });
const snd=document.getElementById('snd'); if(ASSETS.snd) snd.src=ASSETS.snd; snd.volume=.85;

/* ---------- Kit Vence Fuego: video ---------- */
(function(){
  const v=document.getElementById('kitFuegoVid'), btn=document.getElementById('fuegoSnd');
  if(!v||!btn) return;
  const icoOn='<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 9v6h4l5 4V5L8 9H4zm12.5 3a3.5 3.5 0 0 0-2-3.2v6.4a3.5 3.5 0 0 0 2-3.2zm-2-7v2.1A5.5 5.5 0 0 1 18.5 12a5.5 5.5 0 0 1-4 5v2a7.5 7.5 0 0 0 0-14z"/></svg>';
  const icoOff='<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 9v6h4l5 4V5L8 9H4zm14.6 3 2.1-2.1-1.4-1.4-2.1 2.1-2.1-2.1-1.4 1.4 2.1 2.1-2.1 2.1 1.4 1.4 2.1-2.1 2.1 2.1 1.4-1.4-2.1-2.1z"/></svg>';
  const paint=()=>{ btn.innerHTML=(v.muted?icoOn+'<span>Sonido</span>':icoOff+'<span>Silenciar</span>'); };
  new IntersectionObserver(es=>es.forEach(e=>{ if(e.isIntersecting){ v.play().catch(()=>{}); } else { v.pause(); } }),{threshold:.3}).observe(v);
  btn.addEventListener('click',()=>{ v.muted=!v.muted; if(!v.muted){ v.volume=.9; v.play().catch(()=>{}); } paint(); });
  v.addEventListener('click',()=>{ if(v.paused){ v.play().catch(()=>{}); } else { v.pause(); } });
  paint();
})();


/* ---------- entrada de paneles ---------- */
const panels=[...document.querySelectorAll('.panel')];
requestAnimationFrame(()=>setTimeout(()=>panels.forEach(p=>p.classList.add('in')),60));

/* ---------- águila ---------- */
const fly=document.getElementById('eagleFly');
const rig=document.getElementById('rig');
const perched=document.getElementById('eaglePerched');
const panelCab=document.getElementById('panelCabezal');
const sndBtn=document.getElementById('sndBtn');
const reduced=matchMedia('(prefers-reduced-motion: reduce)').matches;
let flying=false, landed=false, soundOK=false;

let playSound=function(){
  if(!snd.src) return Promise.resolve();
  snd.currentTime=0;
  return snd.play().then(()=>{soundOK=true;sndBtn.classList.remove('show')});
};

function land(){
  flying=false; landed=true;
  fly.classList.add('out');
  perched.classList.remove('idle');
  perched.classList.add('show');
  panelCab.classList.remove('landed'); void panelCab.offsetWidth; panelCab.classList.add('landed');
  setTimeout(()=>{fly.style.opacity=0;fly.classList.remove('out','flare','glide')},350);
  setTimeout(()=>perched.classList.add('idle'),950);
}

function flyIn(withSound){
  if(flying || document.body.classList.contains('view-cat')) return;
  flying=true; fly.classList.remove('glide','flare','out');
  perched.classList.remove('show','idle');

  const r=perched.getBoundingClientRect();
  // el cuerpo del águila en vuelo (ancla 45%/38% del rig) termina sobre el centro del águila posada
  const tx=r.left+r.width/2, ty=r.top+r.height*0.45;
  const vw=innerWidth, vh=innerHeight;
  const rr=rig.getBoundingClientRect(); const W=rr.width||300, H=rr.height||430;
  const endScale=Math.min(.95,Math.max(.32,(r.height*1.85)/H));

  const sx=vw+W*.7, sy=Math.min(vh*.42, ty);
  const c1x=vw*.68, c1y=Math.max(40, ty-vh*.45);
  const c2x=tx+vw*.24, c2y=ty-vh*.12;
  fly.style.offsetPath=`path("M ${sx} ${sy} C ${c1x} ${c1y}, ${c2x} ${c2y}, ${tx} ${ty}")`;

  const dur=4600;
  fly.style.opacity=1;
  fly.animate([{offsetDistance:'0%'},{offsetDistance:'100%'}],{duration:dur,easing:'cubic-bezier(.4,.05,.25,1)',fill:'forwards'});
  rig.animate([
    {transform:'scale(1.15) rotate(-6deg)'},
    {transform:'scale(1.05) rotate(3deg)',offset:.45},
    {transform:`scale(${endScale*1.1}) rotate(-5deg)`,offset:.86},
    {transform:`scale(${endScale}) rotate(0deg)`}
  ],{duration:dur,easing:'ease-in-out',fill:'forwards'});
  setTimeout(()=>fly.classList.add('glide'),dur*.5);
  setTimeout(()=>fly.classList.add('flare'),dur-520);
  setTimeout(land,dur-60);

  if(withSound){
    if(soundOK && !snd.paused && snd.currentTime<1.2){ /* ya está sonando desde la carga */ }
    else playSound().catch(()=>{ sndBtn.classList.add('show'); });
  }
}

/* primer gesto del usuario: si el sonido estaba bloqueado y el águila todavía vuela, lo enganchamos */
let sonoAlguna=false;
const _play=playSound;
playSound=function(){ return _play().then(r=>{sonoAlguna=true;return r;}); };
['pointerdown','keydown','touchend','click'].forEach(ev=>addEventListener(ev,()=>{
  if(soundOK && sonoAlguna) return;
  if(document.body.classList.contains('view-cat') && !flying) return; // dentro de una categoría el sonido lo maneja la propia navegación
  playSound().then(()=>{
    // si el águila ya está posada, acompaña el grito con un aleteo
    if(!flying && perched.classList.contains('show')){ perched.classList.add('grita'); setTimeout(()=>perched.classList.remove('grita'),1500); }
  }).catch(()=>{});
},{once:false,passive:true}));

sndBtn.addEventListener('click',()=>{ flyIn(true); });


/* ================= NAVEGACIÓN A CATEGORÍAS ================= */
const perched2=document.getElementById('eaglePerched2');
const detalles=[...document.querySelectorAll('.detalle')];
let catAbierta=null;

/* lightbox de fotos */
const lb=document.getElementById('lightbox'), lbImg=lb.querySelector('img');
document.querySelectorAll('.mod-fotos .mf, .tolva-galeria .mf').forEach(b=>b.addEventListener('click',()=>{lbImg.src=IMGS[b.dataset.src]||'';lb.hidden=false;}));
lb.addEventListener('click',()=>{lb.hidden=true;lbImg.src='';});
addEventListener('keydown',e=>{if(e.key==='Escape'&&!lb.hidden){lb.hidden=true;}});

/* miniaturas → foto principal */
document.querySelectorAll('.mb-thumbs').forEach(th=>{
  th.addEventListener('click',e=>{
    const b=e.target.closest('button'); if(!b) return;
    const main=th.parentElement.querySelector('.mb-main img');
    th.querySelectorAll('button').forEach(x=>x.classList.toggle('on',x===b));
    main.style.opacity=0; setTimeout(()=>{main.src=IMGS[b.dataset.src]||main.src;main.style.opacity=1;},220);
  });
});

/* vuelo genérico entre dos águilas posadas */
function flyBetween(fromEl,toEl,withSound,onDone){
  if(flying){ if(onDone) onDone(); return; }
  const a=fromEl.getBoundingClientRect(), b=toEl.getBoundingClientRect();
  const vh=innerHeight, vw=innerWidth;
  const offscreen = b.top>vh-40 || b.bottom<40 || a.width===0 || b.width===0;
  fromEl.classList.remove('show','idle');
  if(reduced || offscreen){ toEl.classList.add('show'); setTimeout(()=>toEl.classList.add('idle'),950); if(onDone) onDone(); return; }
  flying=true; fly.classList.remove('glide','flare','out');
  const rr=rig.getBoundingClientRect(); const H=rr.height||430;
  const s0=Math.min(1.1,Math.max(.32,(a.height*1.85)/H)), s1=Math.min(1.1,Math.max(.32,(b.height*1.85)/H));
  const ax=a.left+a.width/2, ay=a.top+a.height*.45, bx=b.left+b.width/2, by=b.top+b.height*.45;
  const lift=Math.max(160,Math.abs(by-ay)*.6+120);
  const c1x=ax+(bx-ax)*.25, c1y=Math.min(ay,by)-lift, c2x=ax+(bx-ax)*.75, c2y=Math.min(ay,by)-lift*.7;
  fly.style.offsetPath=`path("M ${ax} ${ay} C ${c1x} ${c1y}, ${c2x} ${c2y}, ${bx} ${by}")`;
  const dur=2600;
  fly.style.opacity=1;
  fly.animate([{offsetDistance:'0%'},{offsetDistance:'100%'}],{duration:dur,easing:'cubic-bezier(.45,.05,.3,1)',fill:'forwards'});
  rig.animate([
    {transform:`scale(${s0}) rotate(0deg)`},
    {transform:`scale(${(s0+s1)/2*1.15}) rotate(${bx<ax?4:-4}deg)`,offset:.5},
    {transform:`scale(${s1*1.08}) rotate(${bx<ax?-3:3}deg)`,offset:.86},
    {transform:`scale(${s1}) rotate(0deg)`}
  ],{duration:dur,easing:'ease-in-out',fill:'forwards'});
  setTimeout(()=>fly.classList.add('flare'),dur-480);
  setTimeout(()=>{
    flying=false; fly.classList.add('out');
    toEl.classList.add('show');
    setTimeout(()=>{fly.style.opacity=0;fly.classList.remove('out','flare')},350);
    setTimeout(()=>toEl.classList.add('idle'),950);
    if(onDone) onDone();
  },dur-60);
  if(withSound) playSound().catch(()=>{});
}

function cancelFlight(){
  if(!flying) return;
  fly.getAnimations().forEach(a=>a.cancel()); rig.getAnimations().forEach(a=>a.cancel());
  flying=false; fly.style.opacity=0; fly.classList.remove('glide','flare','out');
}
function abrirCat(cat){
  const det=document.getElementById('det-'+cat); if(!det) return;
  cancelFlight();
  const eraOtra = catAbierta && catAbierta!==cat;
  catAbierta=cat;
  detalles.forEach(d=>d.classList.toggle('abierto',d===det));
  panels.forEach(p=>p.classList.toggle('activo',p.dataset.cat===cat));
  document.body.classList.add('view-cat');
  window.scrollTo({top:0,behavior:'smooth'});
  // águila: del panel al título Bocuda Eagle
  if(cat==='cabezal'){
    if(!perched2.classList.contains('show')){
      const from = (perched.classList.contains('show') && !eraOtra) ? perched : null;
      perched.classList.remove('show','idle');
      setTimeout(()=>{ if(from){ /* el panel ya está compacto: usamos el rect del panel activo como origen */
          const pr=panelCab.getBoundingClientRect();
          const fake={getBoundingClientRect:()=>({left:pr.left,top:pr.top,width:pr.width,height:pr.height*1.6,bottom:pr.bottom}),classList:{remove(){}}};
          flyBetween(fake,perched2,true);
        } else { perched2.classList.add('show'); setTimeout(()=>perched2.classList.add('idle'),950); }
      },720);
    }
  }
}
function cerrarCat(){
  if(!catAbierta) return;
  cancelFlight();
  const era=catAbierta; catAbierta=null;
  document.body.classList.remove('view-cat');
  panels.forEach(p=>p.classList.remove('activo'));
  window.scrollTo({top:0,behavior:'smooth'});
  setTimeout(()=>detalles.forEach(d=>d.classList.remove('abierto')),120);
  // el águila vuelve al panel
  perched2.classList.remove('show','idle');
  setTimeout(()=>{
    if(era==='cabezal' && !reduced && innerWidth>820){
      const pr=panelCab.getBoundingClientRect();
      const fake={getBoundingClientRect:()=>({left:pr.left+pr.width*.7,top:pr.top+pr.height*.2,width:pr.width*.3,height:pr.height*.28,bottom:pr.top+pr.height*.48}),classList:{remove(){}}};
      flyBetween(fake,perched,true);
    } else { perched.classList.add('show'); setTimeout(()=>perched.classList.add('idle'),950); }
  },760);
}
panels.forEach(p=>p.addEventListener('click',e=>{
  e.preventDefault();
  const cat=p.dataset.cat;
  if(document.body.classList.contains('view-cat') && catAbierta===cat){ window.scrollTo({top:0,behavior:'smooth'}); return; }
  abrirCat(cat);
}));
document.querySelectorAll('[data-volver]').forEach(b=>b.addEventListener('click',cerrarCat));

// intento temprano de autoplay: si el navegador lo permite (visita repetida, sitio ya usado), suena de entrada
document.addEventListener('DOMContentLoaded',()=>{ playSound().catch(()=>{}); });
addEventListener('pageshow',e=>{ if(e.persisted) playSound().catch(()=>{}); });
/* ================= TOLVAS: granos cayendo ================= */
(function(){
  const esc=document.getElementById('tolvaEscena'); if(!esc) return;
  const cv=document.getElementById('granosCanvas'), ctx=cv.getContext('2d');
  const auger=document.getElementById('augerImg'), tolva=document.getElementById('tolvaImg');
  const COL=['#E9C46A','#DDB255','#C9973A','#F0D27F','#B98A2E','#E3B95C','#D4A64A'];
  let P=[], run=false, raf=0, W=0, H=0, dpr=1, fill=0, landX=null;
  // textura fija para el grano acumulado (no parpadea)
  const TEX=[]; for(let i=0;i<260;i++) TEX.push([Math.random(),Math.random(),Math.random()]);
  function size(){ dpr=Math.min(2,devicePixelRatio||1); const r=esc.getBoundingClientRect(); W=r.width; H=r.height; cv.width=W*dpr; cv.height=H*dpr; ctx.setTransform(dpr,0,0,dpr,0,0); }
  function geo(){
    const e=esc.getBoundingClientRect(), a=auger.getBoundingClientRect(), tt=tolva.getBoundingClientRect();
    const tx=tt.left-e.left, ty=tt.top-e.top, tw=tt.width, th=tt.height;
    return {
      sx:a.left-e.left+a.width*.045, sy:a.top-e.top+a.height*.44,   // boca del sinfín
      tw, th, tx, ty,
      L:{x:tx+tw*.02, y:ty+th*.178}, M:{x:tx+tw*.60, y:ty+th*.108}, R:{x:tx+tw*.80, y:ty+th*.176}  // borde superior de la tolva
    };
  }
  function rimY(g,x){ // borde superior (línea quebrada L→M→R)
    if(x<=g.M.x){ const k=(x-g.L.x)/(g.M.x-g.L.x); return g.L.y+(g.M.y-g.L.y)*Math.max(0,Math.min(1,k)); }
    const k=(x-g.M.x)/(g.R.x-g.M.x); return g.M.y+(g.R.y-g.M.y)*Math.max(0,Math.min(1,k));
  }
  function heapH(g,x){ // altura del grano acumulado sobre el borde
    const x0=g.L.x, x1=g.R.x; if(x<x0||x>x1) return 0;
    const u=(x-x0)/(x1-x0);
    const edge=Math.sin(Math.PI*u);                     // 0 en los extremos, 1 al medio
    const lx=landX==null?(g.L.x+g.M.x)/2:landX;
    const bump=Math.exp(-Math.pow((x-lx)/(g.tw*.16),2)); // montículo bajo el chorro
    return g.th*.075*fill*(0.35*edge+0.9*bump*edge+0.15*edge*edge);
  }
  function landY(g,x){ return rimY(g,x)-heapH(g,x); }
  function spawn(g,n){
    for(let i=0;i<n;i++){
      const s=Math.random(), o=(Math.random()+Math.random()+Math.random())/3-.5;   // más denso al centro
      P.push({x:g.sx+o*g.tw*.11+Math.random()*g.tw*.03,y:g.sy+o*g.tw*.05,
        vx:-(3.2+Math.random()*1.4)*(g.tw/520)+(s<.1?-Math.random()*1.0:0)+o*.6,
        vy:(1.3+Math.random()*1.4)*(g.tw/520),
        r:1.0+Math.random()*1.8,c:COL[(Math.random()*COL.length)|0],a:.7+Math.random()*.3,life:0});
    }
  }
  function drawHeap(g){
    if(fill<=0.01) return;
    const x0=g.L.x, x1=g.R.x, N=48;
    ctx.beginPath(); ctx.moveTo(x0,rimY(g,x0)+1);
    for(let i=1;i<=N;i++){ const x=x0+(x1-x0)*i/N; ctx.lineTo(x,rimY(g,x)+1); }
    for(let i=N;i>=0;i--){ const x=x0+(x1-x0)*i/N; ctx.lineTo(x,landY(g,x)); }
    ctx.closePath();
    const top=Math.min(g.M.y-g.th*.08, g.L.y-g.th*.08);
    const gr=ctx.createLinearGradient(0,top,0,g.L.y+2); gr.addColorStop(0,'#F0CF7A'); gr.addColorStop(.55,'#D9AB4E'); gr.addColorStop(1,'#A8761F');
    ctx.fillStyle=gr; ctx.fill();
    // sombra al borde y textura de granos
    ctx.save(); ctx.clip();
    ctx.globalAlpha=.55;
    for(const [u,v,w] of TEX){ const x=x0+(x1-x0)*u; const ry=rimY(g,x), ly=landY(g,x); const y=ly+(ry-ly)*v; if(ry-ly<3) continue;
      ctx.fillStyle=w<.5?'#8E5F14':'#F6DE96'; ctx.beginPath(); ctx.arc(x,y,.7+w*1.3,0,6.283); ctx.fill(); }
    ctx.globalAlpha=1;
    const sh=ctx.createLinearGradient(0,g.L.y-g.th*.03,0,g.L.y+2); sh.addColorStop(0,'rgba(90,50,0,0)'); sh.addColorStop(1,'rgba(90,50,0,.45)');
    ctx.fillStyle=sh; ctx.fillRect(x0,g.M.y-g.th*.1,x1-x0,g.th*.2);
    ctx.restore();
  }
  function step(){
    if(!run) return;
    const g=geo(); const grav=Math.max(.16,H*.00042);
    ctx.clearRect(0,0,W,H);
    if(fill<1) fill+=.0018;             // se va llenando (~10 s)
    drawHeap(g);
    spawn(g,34);
    const keep=[];
    for(const p of P){
      p.life++;
      if(p.spill){ p.vy+=grav*.6; p.x+=p.vx; p.y+=p.vy; if(p.y>g.ty+g.th*.62) continue; keep.push(p);
        ctx.globalAlpha=p.a*.9; ctx.fillStyle=p.c; ctx.beginPath(); ctx.arc(p.x,p.y,p.r,0,6.283); ctx.fill(); continue; }
      p.vy+=grav; p.vx*=.992; p.x+=p.vx+Math.sin((p.life+p.y)*.05)*.3; p.y+=p.vy;
      const ly=landY(g,p.x);
      if(p.y>=ly && !p.bounce){
        const inside=p.x>=g.L.x-4 && p.x<=g.R.x+4;
        if(inside){
          landX = landX==null ? p.x : landX*.985+p.x*.015;
          const rr=Math.random();
          if(rr<.28 && p.life>4){ keep.push({x:p.x,y:ly,vx:(Math.random()-.5)*2.6,vy:-(.5+Math.random()*1.5),r:p.r*.8,c:p.c,a:.9,life:0,bounce:1}); }
          else if(rr<.31 && p.x<g.L.x+g.tw*.14){ // se derrama por el frente
            keep.push({x:p.x,y:ly,vx:-(0.3+Math.random()*.6),vy:.4,r:p.r*.8,c:p.c,a:.9,life:0,spill:1}); }
        }
        continue;
      }
      if(p.bounce && p.y>ly+14) continue;
      if(p.y>H+10||p.x<-10) continue;
      keep.push(p);
      // trazo con leve estela en la dirección de caída
      ctx.globalAlpha=p.a; ctx.strokeStyle=p.c; ctx.lineWidth=p.r*1.6; ctx.lineCap='round';
      ctx.beginPath(); ctx.moveTo(p.x-p.vx*.55,p.y-p.vy*.55); ctx.lineTo(p.x,p.y); ctx.stroke();
    }
    ctx.globalAlpha=1;
    P=keep.length>2800?keep.slice(-2800):keep;
    raf=requestAnimationFrame(step);
  }
  function start(){ if(run) return; size(); run=true; raf=requestAnimationFrame(step); }
  function stop(){ run=false; cancelAnimationFrame(raf); }
  const io=new IntersectionObserver(es=>es.forEach(e=>{ if(e.isIntersecting && document.getElementById('det-tolvas').classList.contains('abierto')) start(); else stop(); }),{threshold:.05});
  io.observe(esc);
  addEventListener('resize',()=>{ if(run) size(); });
  const mo=new MutationObserver(()=>{ const ab=document.getElementById('det-tolvas').classList.contains('abierto'); if(!ab) stop(); else { P=[]; fill=0; landX=null; setTimeout(()=>{ const r=esc.getBoundingClientRect(); if(r.bottom>0 && r.top<innerHeight) start(); },80); } });
  mo.observe(document.getElementById('det-tolvas'),{attributes:true,attributeFilter:['class']});

  /* capacidades */
  const caps=document.getElementById('caps'), capSel=document.getElementById('capSel'), capWa=document.getElementById('capWa');
  caps.addEventListener('click',e=>{
    const b=e.target.closest('.cap'); if(!b) return;
    caps.querySelectorAll('.cap').forEach(x=>x.classList.toggle('on',x===b));
    capSel.textContent='Granos '+b.dataset.cap;
    capWa.href='https://wa.me/595983178015?text='+encodeURIComponent('Hola CIABAY, quiero consultar por la tolva Granos '+b.dataset.cap);
  });
})();

/* ================= CLASIFICADOR: vistas ================= */
(function(){
  const v=document.getElementById('caVistas'), r=document.getElementById('caRender'); if(!v) return;
  v.addEventListener('click',e=>{ const b=e.target.closest('button'); if(!b) return;
    v.querySelectorAll('button').forEach(x=>x.classList.toggle('on',x===b));
    r.style.opacity=0; setTimeout(()=>{ r.src=ASSETS[b.dataset.src]||r.src; r.style.opacity=1; },220);
  });
})();

/* ================= SEMBRADORAS: grupos, modelos, fichas ================= */
const SEMB={
  finos:{
    orden:['pampeana'],
    modelos:{
      pampeana:{
        nombre:'Pampeana', tag:'Uniformidad en siembra y remoción de suelo bajo',
        fotos:['pamp_3','pamp_1','pamp_2','pamp_4','pamp_5','pamp_6','pamp_7'], render:'pamp_r', renderCap:'Pampeana 28000',
        desc:'La Línea de Sembradoras Pampeana está disponible para siembra de grano fino en versiones de 17, 20, 24, 28, 30, 32 y 34 líneas, y en su versión Pampeana Super de 33, 36, 40 y 43 líneas (17 cm de distancia). Sus líneas pantográficas copian correctamente el suelo, asegurando uniformidad en la siembra y baja remoción de tierra. Tiene alto rendimiento en el corte de paja y excelente copia del terreno a sembrar. Sus depósitos de abono y semillas están fabricados 100% en polietileno, lo que se traduce en una mayor vida útil y una mayor autonomía de plantación.',
        series:[{n:'Pampeana',l:'17 · 20 · 24 · 28 · 30 · 32 · 34 líneas',t:'80 a 170 HP'},{n:'Pampeana Super',l:'33 · 36 · 40 · 43 líneas',t:'150 a 215 HP'}],
        cols:['Pampeana','Pampeana Super'], specTitulo:'Grano fino',
        specs:[
          ['est','Tipo de granos','FINOS','FINOS'],
          ['est','Líneas','17, 20, 24, 28, 30, 32, 34','33, 36, 40, 43'],
          ['est','Espaciamiento','17 cm','17 cm'],
          ['est','Articulada','Chasis fijo','Chasis fijo'],
          ['est','Autotransportable','OPCIONAL','OPCIONAL'],
          ['est','Solo semilla, caja central','NO','NO'],
          ['est','Caja central fertilizantes','NO','NO'],
          ['est','Caja central semillas','NO','NO'],
          ['opc','Disco de corte 17','NO','NO'],
          ['opc','Disco de corte 18','NO','NO'],
          ['opc','Disco de corte 20','NO','NO'],
          ['est','Surcador','NO','NO'],
          ['opc','Doble disco desfasado','DE FABRICA','DE FABRICA'],
          ['opc','Segundo disco de corte turbo','NO','NO'],
          ['est','Caja de semillas suspensa','DE FABRICA','DE FABRICA'],
          ['opc','Caja de semillas individual','NO','NO'],
          ['est','Monitor de siembra','NO','NO'],
          ['opc','Dosificador mecánico por rotor','DE FABRICA','DE FABRICA'],
          ['opc','Dosificador Titanium','NO','NO'],
          ['opc','Dosificador Selenium cabo','NO','NO'],
          ['opc','Dosificador Selenium Electric (corte línea a línea)','NO','NO'],
          ['opc','Dosificador de fertilizantes Fertisystem','DE FABRICA','DE FABRICA'],
          ['opc','Corte de sección de fertilizantes','OPCIONAL','OPCIONAL'],
          ['opc','Corte de sección de semillas','OPCIONAL','OPCIONAL'],
          ['opc','Marcador de línea hidráulico','OPCIONAL','OPCIONAL'],
          ['opc','Sistema Pula Pedra','NO','NO'],
          ['opc','Acamador de pasturas','OPCIONAL','OPCIONAL'],
          ['opc','Caja de pastura (grano fino)','OPCIONAL','OPCIONAL'],
          ['est','Catraca eléctrica','NO','NO'],
          ['dif','Principal diferencial','Es una máquina muy precisa en la distribución, con poca remoción de tierra en la siembra. Cuenta con varias configuraciones y permite agregar lo que hay de tecnología, como tasa variable y corte de sección, para suplir la necesidad del cliente. Posee un desencuentro de líneas, posibilitando mejor flujo de paja.','Es una máquina muy precisa en la distribución, con poca remoción de tierra en la siembra. Cuenta con varias configuraciones y permite agregar lo que hay de tecnología, como tasa variable y corte de sección, para suplir la necesidad del cliente. Posee un desencuentro de líneas, posibilitando mejor flujo de paja.'],
          ['est','Potencia del tractor','80 HP hasta 170 HP','150 HP hasta 215 HP'],
          ['est','Flujo de aceite','100 litros por minuto','100 litros por minuto']
        ]
      }
    }
  },
  gruesos:{
    orden:['flexxa','panther','summer','tigerflex','macanuda'],
    modelos:{
      flexxa:{
        nombre:'Flexxa', tag:'Sencilla, compacta y segura de operar',
        fotos:['flexxa_1','flexxa_2','flexxa_3'], render:'flexxa_r', renderCap:'Flexxa 20300 · Serie 300',
        dif:['Menor espacio entre tractor y sembradora de la categoría.','Menor flujo de paja.','Menor tiempo para abrir y cerrar la máquina.','Es una máquina muy sencilla que facilita la operación con seguridad.'],
        series:[{n:'Serie 200',l:'11 · 13 · 15 líneas',t:'150 a 180 HP'},{n:'Serie 300',l:'16 · 18 · 20 líneas',t:'200 a 250 HP'}],
        cols:['Serie 200','Serie 300'],
        specs:[
          ['est','Líneas','11, 13, 15','16, 18, 20'],
          ['est','Espaciamiento','45 y 50','45 y 50'],
          ['est','Articulada','SI','SI'],
          ['est','Autotransportable','SI','SI'],
          ['est','Solo semilla, caja central','NO','SI'],
          ['est','Caja central fertilizantes','NO','NO'],
          ['est','Caja central semillas','NO','SI'],
          ['opc','Disco de corte 18','OPCIONAL','NO'],
          ['opc','Disco de corte 20','NO','OPCIONAL'],
          ['est','Surcador','SI','SI'],
          ['opc','Doble disco','OPCIONAL','OPCIONAL'],
          ['opc','Segundo disco de corte','OPCIONAL','OPCIONAL'],
          ['est','Caja de semillas suspensa','SI','SI'],
          ['est','Monitor de siembra','SI','SI'],
          ['opc','Dosificador mecánico','MECANICA','MECANICA'],
          ['opc','Dosificador Titanium','TITANIUM','TITANIUM'],
          ['opc','Dosificador Selenium cabo','SELENIUM CABO','SELENIUM CABO'],
          ['opc','Dosificador Selenium Electric (corte línea a línea)','SELENIUM ELECTRIC','SELENIUM ELECTRIC'],
          ['opc','Dosificador de fertilizante','FERTISYSTEM','FERTISYSTEM'],
          ['opc','Corte de sección de fertilizante','OPCIONAL','OPCIONAL'],
          ['opc','Corte de sección de semilla','OPCIONAL','OPCIONAL'],
          ['opc','Marcador de línea hidráulico','NO','NO'],
          ['est','Catraca eléctrica','NO','NO'],
          ['dif','Principal diferencial','Menor espacio entre tractor y sembradora de la categoría. Menor flujo de paja. Menor tiempo para abrir y cerrar la máquina. Máquina muy sencilla que facilita la operación con seguridad.','Menor espacio entre tractor y sembradora de la categoría. Menor flujo de paja. Menor tiempo para abrir y cerrar la máquina. Máquina muy sencilla que facilita la operación con seguridad.'],
          ['est','Potencia del tractor','150, 170, 180 HP','200, 225, 250 HP'],
          ['est','Flujo de aceite','100 litros por minuto','100 litros por minuto']
        ]
      },
      panther:{
        nombre:'Panther', tag:'Tradición que garantiza excelentes cosechas',
        fotos:['panther_1','panther_2','panther_3'], render:'panther_r', renderCap:'Panther SM 11000',
        desc:'Para una buena cosecha, el primer paso es una siembra de calidad y las sembradoras Panther SM tienen un excelente rendimiento y una gran distribución de semillas. Su exclusivo Sistema Pula Pedra permite sembrar en los más diversos tipos de suelos, sin romper pines y surcadores. Además, sus líneas pantográficas copian el suelo y brindan una excelente siembra de granos gruesos. Tiene la mejor eficiencia en la siembra con pajas grandes debido a la capacidad de corte de la paja, la excelente altura con relación al suelo y el mayor desajuste en las líneas de fertilización, resultando en una menor remoción de tierra.',
        series:[{n:'Serie 2',l:'7 a 17 líneas',t:'75 a 220 HP'}],
        cols:['Serie 2'], specTitulo:'SM · Serie 2',
        specs:[
          ['est','Tipo de granos','GRUESOS'],
          ['est','Líneas','7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17'],
          ['est','Espaciamiento','45 hasta 90'],
          ['est','Articulada','Chasis fijo'],
          ['est','Autotransportable','NO'],
          ['est','Solo semilla, caja central','NO'],
          ['est','Caja central fertilizantes','NO'],
          ['est','Caja central semillas','NO'],
          ['opc','Disco de corte 17','NO'],
          ['opc','Disco de corte 18','DE FABRICA'],
          ['opc','Disco de corte 20','OPCIONAL'],
          ['est','Surcador','SI'],
          ['opc','Doble disco','OPCIONAL'],
          ['opc','Segundo disco de corte turbo','OPCIONAL'],
          ['est','Caja de semillas suspensa','SI'],
          ['opc','Caja de semillas individual','NO'],
          ['est','Monitor de siembra','OPCIONAL'],
          ['opc','Dosificador mecánico','MECANICA'],
          ['opc','Dosificador Titanium','TITANIUM'],
          ['opc','Dosificador Selenium cabo','SELENIUM CABO'],
          ['opc','Dosificador Selenium Electric (corte línea a línea)','SELENIUM ELECTRIC'],
          ['opc','Dosificador de fertilizantes','FERTISYSTEM'],
          ['opc','Corte de sección de fertilizantes','OPCIONAL'],
          ['opc','Corte de sección de semillas','OPCIONAL'],
          ['opc','Marcador de línea hidráulico','OPCIONAL'],
          ['opc','Sistema Pula Pedra','PRE DISPUESTA'],
          ['est','Catraca eléctrica','FABRICA'],
          ['dif','Principal diferencial','Chasis tubular, 6 tubos, es más liviana de la categoría para estirar la máquina. Mejor desempeño en cantidad de pajas, opcional con sistema pula piedra, una máquina de fácil manejo y muy fácil calibración.'],
          ['est','Potencia del tractor','75 hasta 220 HP'],
          ['est','Flujo de aceite','80 litros por minuto']
        ]
      },
      summer:{
        nombre:'Summer', tag:'La tecnología de las grandes máquinas también para la agricultura familiar',
        fotos:['summer_1','summer_2'], render:'summer_r', renderCap:'Summer 9050 Pantográfica',
        desc:'Summer reúne tecnología de grandes máquinas también para la agricultura familiar. Entre sus diferenciales están las líneas pantográficas, sin uso de corrientes, que resultan en un eficiente copiado del suelo. El Sistema Exclusivo Pula Pedra permite plantar en los más variados tipos de suelos. Posee la mayor autonomía de semillas y fertilizantes de su categoría. Además, el proyecto Summer se desarrolló con un centro de gravedad bajo y una distancia reducida entre el disco de corte y el disco de siembra (una línea más compacta), proporcionando así una excelente plantación incluso en terrenos con fuertes pendientes o curvas, condición que es común en zonas de agricultura familiar.',
        series:[{n:'Serie 1',l:'5 a 11 líneas',t:'65 a 140 HP'}],
        cols:['Serie 1'], specTitulo:'Serie 1',
        specs:[
          ['est','Líneas','5, 6, 7, 8, 9, 10, 11'],
          ['est','Espaciamiento','45 hasta 90'],
          ['est','Articulada','Chasis fijo'],
          ['est','Autotransportable','NO'],
          ['est','Solo semilla, caja central','NO'],
          ['est','Caja central fertilizantes','NO'],
          ['est','Caja central semillas','NO'],
          ['opc','Disco de corte 17','DE FABRICA'],
          ['opc','Disco de corte 18','OPCIONAL'],
          ['opc','Disco de corte 20','NO'],
          ['est','Surcador','SI'],
          ['opc','Doble disco','OPCIONAL'],
          ['opc','Segundo disco de corte turbo','OPCIONAL'],
          ['est','Caja de semillas suspensa','SI'],
          ['opc','Caja de semillas individual','NO'],
          ['est','Monitor de siembra','OPCIONAL'],
          ['opc','Dosificador mecánico','MECANICA'],
          ['opc','Dosificador Titanium','TITANIUM'],
          ['opc','Dosificador Selenium cabo','SELENIUM CABO'],
          ['opc','Dosificador Selenium Electric','NO'],
          ['opc','Dosificador de fertilizantes','FERTISYSTEM'],
          ['opc','Corte de sección de fertilizantes','NO'],
          ['opc','Corte de sección de semillas','NO'],
          ['opc','Marcador de línea hidráulico','OPCIONAL'],
          ['opc','Sistema Pula Pedra','FABRICA'],
          ['est','Catraca eléctrica','NO'],
          ['dif','Principal diferencial','Chasis tubular, es más liviana de la categoría para estirar la máquina. Mejor desempeño en cantidad de pajas, sistema pula piedra de fábrica, una máquina de fácil manejo y muy fácil calibración.'],
          ['est','Potencia del tractor','65 HP hasta 140 HP'],
          ['est','Flujo de aceite','80 litros por minuto']
        ]
      },
      tigerflex:{
        nombre:'Tiger Flex', tag:'El mejor rendimiento de plantación en terreno irregular',
        fotos:['tiger_1','tiger_2','tiger_3','tiger_4'], render:'tiger_r', renderCap:'Tiger Flex 13200 Pneumática',
        desc:'La sembradora Tiger Flex está disponible en modelos de 11, 13 y 15 líneas y presenta un gran rendimiento desde una inserción al suelo hasta la distribución de semillas. Para una plantación de calidad, sus líneas pantográficas tienen un excelente desempeño. También cuenta con el Sistema Exclusivo Pula Pedra con varias configuraciones. Entre sus diferenciales está el mejor desempeño en terrenos abruptos de la categoría. Esto se debe a que posee un chasis articulado, con movimiento tanto hacia arriba como hacia abajo, aumentando su desempeño en el monitoreo del suelo y elevando aún más la calidad de la siembra. Para la distribución de semillas, cuenta con opciones mecánicas y neumáticas de alta precisión, que pueden configurarse con cierre por sesión o línea por línea.',
        series:[{n:'Serie 200',l:'9 · 11 · 13 · 15 líneas',t:'110 a 200 HP'},{n:'Serie 300',l:'13 · 15 · 17 · 19 líneas',t:'170 a 250 HP'}],
        cols:['Serie 200','Serie 300'],
        specs:[
          ['est','Líneas','9, 11, 13, 15','13, 15, 17, 19'],
          ['est','Espaciamiento','45 y 50','45 y 50'],
          ['est','Articulada','SI','SI'],
          ['est','Autotransportable','NO','NO'],
          ['est','Solo semilla, caja central','NO','NO'],
          ['est','Caja central fertilizantes','NO','NO'],
          ['est','Caja central semillas','NO','NO'],
          ['opc','Disco de corte 18','OPCIONAL','OPCIONAL'],
          ['opc','Disco de corte 20','OPCIONAL','OPCIONAL'],
          ['est','Surcador','SI','SI'],
          ['opc','Doble disco','OPCIONAL','OPCIONAL'],
          ['opc','Segundo disco de corte','OPCIONAL','OPCIONAL'],
          ['est','Caja de semillas suspensa','SI','SI'],
          ['est','Monitor de siembra','OPCIONAL','OPCIONAL'],
          ['opc','Dosificador mecánico','MECANICA','MECANICA'],
          ['opc','Dosificador Titanium','TITANIUM','TITANIUM'],
          ['opc','Dosificador Selenium cabo','SELENIUM CABO','SELENIUM CABO'],
          ['opc','Dosificador Selenium Electric (corte línea a línea)','SELENIUM ELECTRIC','SELENIUM ELECTRIC'],
          ['opc','Dosificador de fertilizante','FERTISYSTEM','FERTISYSTEM'],
          ['opc','Corte de sección de fertilizante','OPCIONAL','OPCIONAL'],
          ['opc','Corte de sección de semilla','OPCIONAL','OPCIONAL'],
          ['opc','Marcador de línea hidráulico','OPCIONAL','OPCIONAL'],
          ['est','Catraca eléctrica','ESTANDAR','ESTANDAR'],
          ['dif','Principal diferencial','Poder de corte. Flujo de paja. Cuenta con una buena articulación para terrenos de mucho desnivel y a su vez copia excelente el mapa del terreno.','Poder de corte. Flujo de paja. Cuenta con una buena articulación para terrenos de mucho desnivel y a su vez copia excelente el mapa del terreno.'],
          ['est','Potencia del tractor','110, 140, 170, 200 HP','170, 200, 230, 250 HP'],
          ['est','Flujo de aceite','100 litros por minuto','100 litros por minuto']
        ]
      },
      macanuda:{
        nombre:'Macanuda', tag:'La sembradora perfecta para plantar con continuidad y calidad',
        fotos:['maca_3','maca_1','maca_2','maca_4','maca_5','maca_6','maca_7','maca_8'], render:'maca_r', renderCap:'Macanuda 3.0',
        desc:'La Macanuda es el avance natural de la ya eficiente y consagrada Macanuda de VENCE TUDO, que fue desarrollada para atender grandes áreas y permitir siembras rápidas y precisas, a través de una sembradora robusta con excelente costo beneficio. La Macanuda sigue esta tradición. Fue diseñada para atender a los agricultores más exigentes, preocupados por la rapidez de los procesos de abastecimiento y la continuidad de la planificación de las siembras. Siguiendo de cerca a los agricultores, hemos desarrollado un producto para que siembres sin parar, con una sola caja que garantiza un suministro más rápido, un sistema de torso dimensionado con precisión para promover una distribución homogénea y evitar atragantamiento durante la siembra y líneas ajustadas a un flujo continuo de paja. La Macanuda es en esencia la sembradora perfecta para plantar con continuidad y calidad.',
        series:[{n:'Serie 1',l:'18 a 31 líneas',t:'230 a 400 HP'}],
        cols:['Serie 1'], specTitulo:'Serie 1',
        specs:[
          ['est','Tipo de granos','GRUESOS'],
          ['est','Líneas','18, 20, 22, 24, 26, 28, 30, 31'],
          ['est','Espaciamiento','45 y 50'],
          ['est','Articulada','SI'],
          ['est','Autotransportable','SI'],
          ['est','Solo semilla, caja central','SI'],
          ['est','Caja central fertilizantes','SI'],
          ['est','Caja central semillas','SI'],
          ['opc','Disco de corte 17','NO'],
          ['opc','Disco de corte 18','OPCIONAL'],
          ['opc','Disco de corte 20','SI'],
          ['est','Surcador','SI'],
          ['opc','Doble disco','OPCIONAL'],
          ['opc','Segundo disco de corte turbo','OPCIONAL'],
          ['est','Caja de semillas suspensa','NO'],
          ['opc','Caja de semillas individual','NO'],
          ['est','Monitor de siembra','DE FABRICA'],
          ['opc','Dosificador Selenium Electric (corte línea a línea)','SELENIUM ELECTRIC'],
          ['opc','Dosificador de fertilizantes','NO'],
          ['opc','Corte de sección de fertilizantes','NO'],
          ['opc','Corte de sección de semillas','LINEA A LINEA'],
          ['opc','Marcador de línea hidráulico','NO'],
          ['opc','Sistema Pula Pedra','PRE DISPUESTA'],
          ['est','Catraca eléctrica','NO'],
          ['dif','Principal diferencial','Es la única del mercado en su categoría con ancho de transporte de 3,20 metros: sin desarmar la máquina, apretando un solo botón, la máquina pasa a estar lista para transportar. Controlador de movimiento VTECH exclusivo.'],
          ['est','Potencia del tractor','230 HP hasta 400 HP'],
          ['est','Flujo de aceite','210 litros por minuto']
        ]
      }
    }
  }
};
(function(){
  const gruposEl=document.getElementById('sembGrupos'), tabsEl=document.getElementById('sembModelos'), panel=document.getElementById('sembPanel');
  if(!gruposEl) return;
  let grupo='finos', modeloAct=null;
  const WA='https://wa.me/595983178015?text=';
  const waSvg='<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 3.9A10 10 0 0 0 4.3 16.1L3 21l5-1.3A10 10 0 0 0 20 3.9ZM12 19.5a8.3 8.3 0 0 1-4.3-1.2l-.3-.2-3 .8.8-2.9-.2-.3A8.4 8.4 0 1 1 12 19.5Zm4.6-6.2c-.3-.1-1.5-.7-1.7-.8s-.4-.1-.6.1-.7.8-.8 1-.3.2-.5.1a6.9 6.9 0 0 1-3.4-3c-.3-.4.3-.4.8-1.4a.5.5 0 0 0 0-.5l-.8-1.8c-.2-.5-.4-.4-.6-.4h-.5a1 1 0 0 0-.7.3 3 3 0 0 0-.9 2.2 5.2 5.2 0 0 0 1.1 2.8 12 12 0 0 0 4.5 4c1.7.7 2.3.8 3.1.6a2.7 2.7 0 0 0 1.8-1.2 2.2 2.2 0 0 0 .1-1.2c0-.1-.2-.2-.5-.3Z"/></svg>';
  const cell=v=>{ if(!v) return '<td class="vacio">—</td>'; const u=(v||'').toUpperCase(); if(u==='SI') return '<td class="si">Sí</td>'; if(u==='NO') return '<td class="no">No</td>'; if(u==='OPCIONAL') return '<td class="opc">Opcional</td>'; if(u==='ESTANDAR') return '<td class="si">Estándar</td>'; if(u==='DE FABRICA') return '<td class="si">De fábrica</td>'; if(u==='FABRICA') return '<td class="si">De fábrica</td>'; if(u==='CHASIS FIJO') return '<td>Chasis fijo</td>'; if(u==='PRE DISPUESTA') return '<td class="opc">Predispuesta</td>'; if(u==='LINEA A LINEA') return '<td>Línea a línea</td>'; if(v.length>40) return '<td class="txt">'+v+'</td>'; return '<td>'+v+'</td>'; };
  function renderTabs(){
    const g=SEMB[grupo]; tabsEl.innerHTML='';
    if(!g.orden.length){ tabsEl.innerHTML='<span class="semb-pend" style="padding:14px 0">Modelos en preparación</span>'; return; }
    g.orden.forEach(k=>{ const m=g.modelos[k]; const b=document.createElement('button'); b.type='button'; b.textContent=m.nombre; b.dataset.modelo=k; if(!m.fotos) b.classList.add('pend'); if(k===modeloAct) b.classList.add('on'); tabsEl.appendChild(b); });
  }
  function renderModelo(k){
    const g=SEMB[grupo], m=g.modelos[k]; modeloAct=k; renderTabs();
    if(!m||!m.fotos){ panel.innerHTML='<div class="semb-pend">'+(m?m.nombre+' · ':'')+'Fotos y ficha técnica en preparación</div>'; return; }
    const th=m.fotos.map((f,i)=>'<button type="button" data-src="'+f+'" class="'+(i===0?'on':'')+'"><img data-img="'+f+'" alt="'+m.nombre+'"></button>').join('');
    const dif=m.dif?('<span class="mb-eyebrow" style="display:block;margin-top:18px">Su principal diferencia</span><ul class="dif">'+m.dif.map(d=>'<li>'+d+'</li>').join('')+'</ul>'):(m.desc?'<p class="mod-desc" style="margin-top:14px">'+m.desc+'</p>':'');
    const ser=(m.series||[]).map(s=>'<div class="serie"><small>'+s.n+'</small><b>'+s.l+'</b><span>'+s.t+'</span></div>').join('');
    const rows=m.specs.map(r=>'<tr><td class="cat"><i class="tag-'+r[0]+'"></i></td><th scope="row">'+r[1]+'</th>'+r.slice(2).map(v=>cell(v)).join('')+'</tr>').join('');
    panel.innerHTML=
      '<article class="semb-modelo">'+
        '<div class="semb-media"><div class="letras" aria-hidden="true"><span class="palabra">'+m.nombre+'</span></div>'+
        '<figure class="semb-main"><img data-img="'+m.fotos[0]+'" alt="Sembradora Vence Tudo '+m.nombre+'"></figure><div class="semb-thumbs'+(m.fotos.length>4?' muchas':'')+'">'+th+'</div></div>'+
        '<div class="semb-info"><h3>Vence Tudo <em>'+m.nombre+'</em></h3><p class="mod-tag">'+m.tag+'</p>'+dif+
        '<div class="series">'+ser+'</div>'+
        '<a class="btn wa" href="'+WA+encodeURIComponent('Hola CIABAY, quiero consultar por la sembradora '+m.nombre)+'" target="_blank" rel="noopener">'+waSvg+'Consultar por WhatsApp</a></div>'+
      '</article>'+
      '<div class="semb-specs"><div class="specs-left"><div class="specs-head"><div><span class="eyebrow">Especificaciones técnicas</span><h2>'+m.nombre+' <em>'+(m.specTitulo||m.cols.join(' · '))+'</em></h2></div></div>'+
      '<div class="specs-tabla"><table><thead><tr><th></th><th scope="col">Especificación</th>'+m.cols.map(c=>'<th scope="col">'+c+'</th>').join('')+'</tr></thead><tbody>'+rows+'</tbody></table></div></div>'+
      (m.render?'<aside class="specs-side"><img data-img="'+m.render+'" alt="Sembradora Vence Tudo '+m.nombre+'"><span>'+(m.renderCap||'')+'</span></aside>':'')+'</div>';
    panel.querySelectorAll('[data-img]').forEach(img=>{ if(IMGS[img.dataset.img]) img.src=IMGS[img.dataset.img]; });
    const main=panel.querySelector('.semb-main img'), thumbs=panel.querySelector('.semb-thumbs');
    thumbs.addEventListener('click',e=>{ const b=e.target.closest('button'); if(!b) return; thumbs.querySelectorAll('button').forEach(x=>x.classList.toggle('on',x===b)); main.style.opacity=0; setTimeout(()=>{main.src=IMGS[b.dataset.src]||main.src; main.style.opacity=1;},220); });
    main.style.cursor='zoom-in'; main.addEventListener('click',()=>{ const lb=document.getElementById('lightbox'); lb.querySelector('img').src=main.src; lb.hidden=false; });
  }
  gruposEl.addEventListener('click',e=>{ const b=e.target.closest('button'); if(!b) return; grupo=b.dataset.grupo; gruposEl.querySelectorAll('button').forEach(x=>x.classList.toggle('on',x===b));
    const g=SEMB[grupo]; if(g.orden.length) renderModelo(g.orden[0]); else { modeloAct=null; renderTabs(); panel.innerHTML='<div class="semb-pend">Granos finos · modelos en preparación</div>'; } });
  tabsEl.addEventListener('click',e=>{ const b=e.target.closest('button'); if(!b) return; renderModelo(b.dataset.modelo); });
  renderModelo('pampeana');
})();

/* ================= PORTADA: granos cayendo en el panel de tolvas ================= */
(function(){
  const cv=document.getElementById('granosMini'), img=document.getElementById('tolvaHeroImg'); if(!cv||!img) return;
  const panel=cv.closest('.panel'), ctx=cv.getContext('2d');
  const COL=['#E9C46A','#DDB255','#C9973A','#F0D27F','#B98A2E','#E3B95C','#D4A64A'];
  let P=[], run=false, raf=0, W=0, H=0, dpr=1;
  // puntos de referencia en fracción de la imagen (cuadrada)
  const SPOUT={x:.4684,y:.2845}, LAND={cx:.466,y:.503,k:.055,x0:.30,x1:.64};
  function size(){ dpr=Math.min(2,devicePixelRatio||1); const r=panel.getBoundingClientRect(); W=r.width; H=r.height; cv.width=W*dpr; cv.height=H*dpr; ctx.setTransform(dpr,0,0,dpr,0,0); }
  function map(){ // object-fit:cover
    const n=img.naturalWidth||1400; const sc=Math.max(W/n,H/n), d=n*sc;
    const op=(getComputedStyle(img).objectPosition||'50% 50%').split(' ');
    const px=parseFloat(op[0])/100||.5, py=parseFloat(op[1]||'50%')/100||.5;
    return {ox:(W-d)*px, oy:(H-d)*py, d};
  }
  function landY(m,x){ const fx=(x-m.ox)/m.d; if(fx<LAND.x0||fx>LAND.x1) return 1e9; const dx=(fx-LAND.cx)/.16; return m.oy+(LAND.y+LAND.k*dx*dx*.18)*m.d; }
  function step(){
    if(!run) return;
    const m=map(); const u=m.d/1400; const grav=.22*u;
    ctx.clearRect(0,0,W,H);
    const sx=m.ox+SPOUT.x*m.d, sy=m.oy+SPOUT.y*m.d;
    for(let i=0;i<20*Math.max(.6,Math.min(1.4,u));i++){ const o=(Math.random()+Math.random()+Math.random())/3-.5;
      P.push({x:sx+o*18*u,y:sy+Math.random()*3*u,vx:(-.35+o*.5)*u,vy:(1.4+Math.random()*1.2)*u,r:(.8+Math.random()*1.2)*Math.max(.85,u),c:COL[(Math.random()*COL.length)|0],a:.7+Math.random()*.3,life:0}); }
    const keep=[];
    for(const p of P){
      p.life++; p.vy+=grav; p.x+=p.vx+Math.sin((p.life+p.y)*.06)*.25*u; p.y+=p.vy;
      const ly=landY(m,p.x);
      if(p.y>=ly && !p.bounce){ if(Math.random()<.25&&p.life>4){ keep.push({x:p.x,y:ly,vx:(Math.random()-.5)*1.6*u,vy:-(.4+Math.random()*1.1)*u,r:p.r*.8,c:p.c,a:.9,life:0,bounce:1}); } continue; }
      if(p.bounce && p.y>ly+8*u) continue;
      if(p.y>H+10) continue;
      keep.push(p);
      ctx.globalAlpha=p.a; ctx.strokeStyle=p.c; ctx.lineWidth=p.r*1.5; ctx.lineCap='round';
      ctx.beginPath(); ctx.moveTo(p.x-p.vx*.5,p.y-p.vy*.5); ctx.lineTo(p.x,p.y); ctx.stroke();
    }
    ctx.globalAlpha=1; P=keep.length>2600?keep.slice(-2600):keep;
    raf=requestAnimationFrame(step);
  }
  function start(){ if(run||reduced) return; size(); run=true; raf=requestAnimationFrame(step); }
  function stop(){ run=false; cancelAnimationFrame(raf); ctx&&ctx.clearRect(0,0,W,H); }
  const io=new IntersectionObserver(es=>es.forEach(e=>{ if(e.isIntersecting && !document.body.classList.contains('view-cat')) start(); else stop(); }),{threshold:.05});
  io.observe(panel);
  addEventListener('resize',()=>{ if(run) size(); });
  new MutationObserver(()=>{ if(document.body.classList.contains('view-cat')) stop(); else { const r=panel.getBoundingClientRect(); if(r.bottom>0&&r.top<innerHeight) setTimeout(start,700); } }).observe(document.body,{attributes:true,attributeFilter:['class']});
  if(img.complete) { /* ok */ }
})();

addEventListener('load',()=>{
  if(reduced){ perched.classList.add('show'); setTimeout(()=>perched.classList.add('idle'),900); return; }
  const mobile=innerWidth<=820;
  if(!mobile){ setTimeout(()=>flyIn(true),650); return; }
  // en celular: el águila vuela cuando el panel del cabezal entra en pantalla
  let done=false;
  const io=new IntersectionObserver(es=>{
    es.forEach(e=>{ if(!done && e.isIntersecting && e.intersectionRatio>=.55){ done=true; io.disconnect(); setTimeout(()=>flyIn(true),250); } });
  },{threshold:[.55,.8]});
  io.observe(panelCab);
});
})();
