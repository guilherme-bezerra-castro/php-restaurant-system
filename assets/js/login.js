document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('loginForm');
  const btn = document.getElementById('loginBtn');
  const senha = document.getElementById('senha');
  const usuario = document.getElementById('nome_usuario');
  const toggleBtn = document.getElementById('toggleSenha');

  if (toggleBtn && senha) {
    toggleBtn.addEventListener('click', () => {
      const visivel = senha.type === 'text';
      senha.type = visivel ? 'password' : 'text';
      toggleBtn.innerHTML = visivel
        ? '<i class="fas fa-eye"></i>'
        : '<i class="fas fa-eye-slash"></i>';
      toggleBtn.setAttribute('aria-label', visivel ? 'Mostrar senha' : 'Ocultar senha');
    });
  }

  function limparErro(campo) {
    campo.classList.remove('campo-invalido');
    const msg = campo.closest('.campo')?.querySelector('.campo-erro-msg');
    if (msg) msg.remove();
  }

  function marcarErro(campo, texto) {
    campo.classList.add('campo-invalido');
    const container = campo.closest('.campo');
    if (container && !container.querySelector('.campo-erro-msg')) {
      const span = document.createElement('span');
      span.className = 'campo-erro-msg';
      span.textContent = texto;
      container.appendChild(span);
    }
  }

  [usuario, senha].forEach(campo => {
    campo?.addEventListener('input', () => limparErro(campo));
  });

  form?.addEventListener('submit', (e) => {
    let valido = true;

    if (!usuario.value.trim()) {
      marcarErro(usuario, 'Informe o usuário.');
      valido = false;
    }
    if (!senha.value) {
      marcarErro(senha, 'Informe a senha.');
      valido = false;
    }
    if (!valido) { 
        e.preventDefault(); 
        return; 
    }

    btn.disabled = true;
    btn.classList.add('is-loading');
  });
});