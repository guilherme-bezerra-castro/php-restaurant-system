document.addEventListener('DOMContentLoaded', () => {
  
  const totalSlides = document.querySelectorAll('carousel-item').length;

  function inicializarCarousel() {
    const inner = document.querySelector('.carousel-inner');
    const indicators = document.querySelectorAll('.carousel-indicators button');
    const btnPrev = document.querySelector('.carousel-btn-prev');
    const btnNext = document.querySelector('.carousel-btn-next');

    if (!inner) return;

    const items = inner.querySelectorAll('.carousel-item');
    if (items.length === 0) return;

    let atual = 0;
    let timer = null;
    const total = items.length;

    function ir(n) {
      atual = (n + total) % total;
      inner.style.transform = `translateX(-${atual * 100}%)`;
      indicators.forEach((btn, i) => btn.classList.toggle('active', i === atual));
    }

    function avancar() { 
      ir(atual + 1); 
    }

    function recuar()  { 
      ir(atual - 1); 
    }

    function iniciarAuto() {
      pararAuto();
      timer = setInterval(avancar, 5000);
    }

    function pararAuto() {
      if (timer) { 
        clearInterval(timer); timer = null; 
      }
    }

    if (btnNext) btnNext.addEventListener('click', () => { avancar(); iniciarAuto(); });
    if (btnPrev) btnPrev.addEventListener('click', () => { recuar(); iniciarAuto(); });

    indicators.forEach((btn, i) => {
      btn.addEventListener('click', () => { ir(i); iniciarAuto(); });
    });

    const wrapper = document.querySelector('.carousel-section');
    if (wrapper) {
      wrapper.addEventListener('mouseenter', pararAuto);
      wrapper.addEventListener('mouseleave', iniciarAuto);
    }

    let touchStartX = 0;
    inner.addEventListener('touchstart', e => { touchStartX = e.touches[0].clientX; },
       { passive: true });
    inner.addEventListener('touchend', e => {
      const dx = e.changedTouches[0].clientX - touchStartX;
      if (Math.abs(dx) > 50) { dx < 0 ? avancar() : recuar(); iniciarAuto(); }
    });

    ir(0);
    iniciarAuto();
  }

  function inicializarSidebar() {
    const btnToggle = document.getElementById('toggleSidebar');
    const btnClose  = document.getElementById('closeSidebar');
    const overlay   = document.getElementById('sidebarOverlay');

    function abrir()  { document.body.classList.add('sidebar-open'); }
    function fechar() { document.body.classList.remove('sidebar-open'); }

    if (btnToggle) btnToggle.addEventListener('click', abrir);
    if (btnClose)  btnClose.addEventListener('click', fechar);
    if (overlay)   overlay.addEventListener('click', fechar);

    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') fechar();
    });
  }

  function inicializarBotaoLogin() {
    const loginBtn = document.getElementById('loginRedirectButton');
    if (loginBtn) {
      loginBtn.addEventListener('click', () => {
        window.location.href = '/includes/login.php';
      });
    }

    const sidebarLogin = document.getElementById('sidebarLoginButton');
    if (sidebarLogin) {
      sidebarLogin.addEventListener('click', e => {
        e.preventDefault();
        window.location.href = '/includes/login.php';
      });
    }
  }

  function inicializarReveal() {
    const elementos = document.querySelectorAll('.reveal');
    if (!elementos.length) return;

    const obs = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });

    elementos.forEach(el => obs.observe(el));
  }

  function inicializarNavAtivo() {
    const navLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('section[id]');
    if (!sections.length) return;

    const obs = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          navLinks.forEach(link => {
            const href = link.getAttribute('href') || '';
            link.classList.toggle('active', href.includes(entry.target.id));
          });
        }
      });
    }, { rootMargin: '-40% 0px -55% 0px' });

    sections.forEach(s => obs.observe(s));
  }

  inicializarCarousel();
  inicializarSidebar();
  inicializarBotaoLogin();
  inicializarReveal();
  inicializarNavAtivo();
  
});