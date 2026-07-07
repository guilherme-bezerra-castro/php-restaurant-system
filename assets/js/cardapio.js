document.addEventListener('DOMContentLoaded', () => {

  const btnToggle = document.getElementById('toggleSidebar');
  const btnClose  = document.getElementById('closeSidebar');
  const overlay   = document.getElementById('sidebarOverlay');

  function abrirSidebar()  { document.body.classList.add('sidebar-open'); }
  function fecharSidebar() { document.body.classList.remove('sidebar-open'); }

  if (btnToggle) btnToggle.addEventListener('click', abrirSidebar);
  if (btnClose)  btnClose.addEventListener('click', fecharSidebar);
  if (overlay)   overlay.addEventListener('click', fecharSidebar);
  document.addEventListener('keydown', e => { if (e.key === 'Escape') fecharSidebar(); });

  const loginBtn = document.getElementById('loginRedirectButton');
  if (loginBtn) loginBtn.addEventListener('click', () => {
    window.location.href = '/includes/login.php';
  });

  const sidebarLogin = document.getElementById('sidebarLoginButton');
  if (sidebarLogin) sidebarLogin.addEventListener('click', e => {
    e.preventDefault();
    window.location.href = '/includes/login.php';
  });

  const revelaveis = document.querySelectorAll('.reveal');
  if (revelaveis.length) {
    const obs = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); }
      });
    }, { threshold: 0.1 });
    revelaveis.forEach(el => obs.observe(el));
  }

  const searchInput    = document.getElementById('searchInput');
  const searchForm     = document.getElementById('searchForm');
  const dropdown       = document.getElementById('searchDropdown');
  const semResultados  = document.getElementById('semResultados');
  const limparBtn      = document.getElementById('limparBusca');
  const cards          = Array.from(document.querySelectorAll('.prato-card'));
  const secoes         = Array.from(document.querySelectorAll('.cardapio-section'));

  const nomesSecao = {
    salgados:   'Pratos Salgados',
    sobremesas: 'Sobremesas',
    bebidas:    'Bebidas',
  };

  function escaparRegex(str) {
    return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
  }

  function destacar(texto, termo) {
    if (!termo) return texto;
    const re = new RegExp(`(${escaparRegex(termo)})`, 'gi');
    return texto.replace(re, '<mark>$1</mark>');
  }

  function buscarCards(termo) {
    return cards.filter(card => {
      const nome = card.dataset.nome || '';
      const desc = card.dataset.desc || '';
      return nome.includes(termo) || desc.includes(termo);
    });
  }

  function atualizarDropdown(termo) {
    if (!termo || termo.length < 2) {
      fecharDropdown();
      return;
    }

    const encontrados = buscarCards(termo).slice(0, 6);
    dropdown.innerHTML = '';

    if (!encontrados.length) {
      dropdown.innerHTML = `<p class="search-dropdown-empty">Nenhum resultado para "<strong>${termo}</strong>"</p>`;
      dropdown.classList.add('visible');
      return;
    }

    encontrados.forEach(card => {
      const img    = card.querySelector('img');
      const nome   = card.querySelector('.prato-card-nome')?.textContent || '';
      const preco  = card.querySelector('.prato-card-preco')?.textContent || '';
      const secao  = nomesSecao[card.dataset.secao] || '';
      const secId  = card.dataset.secao;

      const item = document.createElement('div');
      item.className = 'search-result-item';
      item.setAttribute('role', 'option');
      item.innerHTML = `
        <img src="${img?.src || ''}" alt="${nome}" class="search-result-img">
        <div class="search-result-info">
          <p class="search-result-nome">${destacar(nome, termo)}</p>
          <p class="search-result-secao">${secao}</p>
        </div>
        <span class="search-result-preco">${preco}</span>
      `;

      item.addEventListener('click', () => {
        limparFiltro();
        fecharDropdown();
        searchInput.value = '';
        const alvo = document.getElementById(secId);
        if (alvo) alvo.scrollIntoView({ behavior: 'smooth', block: 'start' });
        card.style.outline = '2px solid var(--laranja)';
        card.style.outlineOffset = '4px';
        setTimeout(() => { card.style.outline = ''; card.style.outlineOffset = ''; }, 2000);
      });

      dropdown.appendChild(item);
    });

    dropdown.classList.add('visible');
  }

  function fecharDropdown() {
    dropdown.classList.remove('visible');
    dropdown.innerHTML = '';
  }

  // Filtro de página completo (ao submeter)
  function aplicarFiltro(termo) {
    if (!termo) { limparFiltro(); return; }

    const encontrados = buscarCards(termo);
    const idsEncontrados = new Set(encontrados);

    cards.forEach(card => {
      card.hidden = !idsEncontrados.has(card);
    });

    let algumVisivel = false;
    secoes.forEach(sec => {
      const cardsNaSec = sec.querySelectorAll('.prato-card');
      const temVisivel = Array.from(cardsNaSec).some(c => !c.hidden);
      sec.style.display = temVisivel ? '' : 'none';
      if (temVisivel) algumVisivel = true;
    });

    semResultados.hidden = algumVisivel;
  }

  function limparFiltro() {
    cards.forEach(card => { card.hidden = false; });
    secoes.forEach(sec => { sec.style.display = ''; });
    semResultados.hidden = true;
    searchInput.value = '';
    fecharDropdown();
  }

  searchInput?.addEventListener('input', e => {
    atualizarDropdown(e.target.value.trim().toLowerCase());
  });

  searchInput?.addEventListener('keydown', e => {
    if (e.key === 'Escape') { fecharDropdown(); searchInput.blur(); }
  });

  searchForm?.addEventListener('submit', e => {
    e.preventDefault();
    const termo = searchInput.value.trim().toLowerCase();
    fecharDropdown();
    aplicarFiltro(termo);
  });

  limparBtn?.addEventListener('click', limparFiltro);

  // Fechar dropdown ao clicar fora
  document.addEventListener('click', e => {
    if (!e.target.closest('.search-wrapper')) fecharDropdown();
  });

});
