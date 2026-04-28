<script>
// ===== PRELOADER =====
window.addEventListener('load', () => {
  setTimeout(() => {
    const preloader = document.getElementById('preloader');
    if (preloader) preloader.classList.add('hidden');
    // Trigger particle assembly animation
    window.dispatchEvent(new CustomEvent('startLogoAssembly'));
  }, 1500);
});

// ===== CURSOR =====
const cursor = document.getElementById('cursor');
const ring = document.getElementById('cursorRing');
let mx=0,my=0,rx=0,ry=0;
if (cursor && ring) {
  document.addEventListener('mousemove',e=>{mx=e.clientX;my=e.clientY;});
  (function animCursor(){
    cursor.style.left=mx+'px';cursor.style.top=my+'px';
    rx+=(mx-rx)*.12;ry+=(my-ry)*.12;
    ring.style.left=rx+'px';ring.style.top=ry+'px';
    requestAnimationFrame(animCursor);
  })();
  document.querySelectorAll('a,button,.about-card,.service-card').forEach(el=>{
    el.addEventListener('mouseenter',()=>{cursor.style.width='18px';cursor.style.height='18px';ring.style.width='54px';ring.style.height='54px';});
    el.addEventListener('mouseleave',()=>{cursor.style.width='10px';cursor.style.height='10px';ring.style.width='38px';ring.style.height='38px';});
  });
}

// ===== NAV SCROLL =====
const navbar = document.getElementById('navbar');
if (navbar) {
  window.addEventListener('scroll',()=>{
    navbar.classList.toggle('scrolled',window.scrollY>80);
  },{passive:true});
}

// ===== MOBILE MENU =====
const hamburger=document.getElementById('hamburger');
const mobileMenu=document.getElementById('mobileMenu');
function closeMenu(){
    if (hamburger) hamburger.classList.remove('open');
    if (mobileMenu) mobileMenu.classList.remove('open');
    document.body.style.overflow='';
}
if (hamburger && mobileMenu) {
  hamburger.addEventListener('click',()=>{
    const o=hamburger.classList.toggle('open');
    mobileMenu.classList.toggle('open',o);
    document.body.style.overflow=o?'hidden':'';
  });
}

// ===== SCROLL REVEAL =====
(function initReveal(){
  const obs=new IntersectionObserver(entries=>{
    entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('visible');obs.unobserve(e.target);}});
  },{threshold:.1,rootMargin:'0px 0px -40px 0px'});
  document.querySelectorAll('.reveal').forEach(el=>obs.observe(el));
  
  // Re-run after dynamic content might be added
  setTimeout(()=>{
    document.querySelectorAll('.reveal:not(.visible)').forEach(el=>obs.observe(el));
  },100);
})();

// Re-observe after dynamic content rendered
setTimeout(()=>{
  const obs=new IntersectionObserver(entries=>{
    entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('visible');}});
  },{threshold:.08});
  document.querySelectorAll('.reveal').forEach(el=>obs.observe(el));
},200);
</script>

@stack('page_scripts')
