<nav class="navbar">
  <button class="menu-button" id="toggleSidebar" aria-label="Abrir menu">
    <span class="hamburger-line"></span>
    <span class="hamburger-line"></span>
    <span class="hamburger-line"></span>
  </button>

  <a href="/includes/index.php" class="navbar-brand">
    <img src="../assets/img/oven.svg" alt="Logo Gostinho Natural" class="navbar-logo">
    <span class="navbar-brand-name">Gostinho Natural</span>
  </a>

  <div class="nav-links">
    <a href="/includes/index.php" class="nav-link">Início</a>
    <a href="/includes/locais.php" class="nav-link">Locais</a>
    <a href="/includes/cardapio.php" class="nav-link">Cardápio</a>
  </div>

  <div class="navbar-actions">
    <form class="search-form" role="search">
      <input type="search" class="search-input" placeholder="Pesquisar..." aria-label="Pesquisar">
      <button type="submit" class="search-button" aria-label="Buscar">
        <i class="fas fa-search"></i>
      </button>
    </form>
    <button class="usuario-button" id="loginRedirectButton" aria-label="Login">
      <i class="fas fa-user"></i>
    </button>
  </div>
</nav>

<script src="/assets/js/navbar.js"></script>
