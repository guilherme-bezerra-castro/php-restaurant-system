document.addEventListener('DOMContentLoaded', () => {
  function inicializarToggleSidebar() {
    const toggleBtn = document.getElementById('toggleSidebar');
    if (toggleBtn) {
      toggleBtn.addEventListener('click', () => {
        document.body.classList.toggle('sidebar-collapsed');
      });
    }
  }

  function inicializarBotaoLogin() {
    const loginBtn = document.getElementById('loginRedirectButton');
    if (loginBtn) {
      loginBtn.addEventListener('click', () => {
        window.location.href = '/includes/login.php';
      });
    }
  }

  inicializarToggleSidebar();
  inicializarBotaoLogin();
});