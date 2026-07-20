document.addEventListener('DOMContentLoaded', () => {

    const titulos = {
        dashboard: 'Dashboard',
        pedidos: 'Pedidos',
        pratos: 'Pratos',
        faq: 'FAQ',
        footer: 'Footer',
    };

  const navLinks = document.querySelectorAll('.adm-nav-link');
  const secoes = document.querySelectorAll('.adm-secao');
  const tituloEl = document.getElementById('adm-titulo-aba');

  function ativarAba(aba) {
    navLinks.forEach(btn => btn.classList.toggle('ativo', btn.dataset.aba === aba));
    secoes.forEach(sec => { 
        sec.hidden = sec.dataset.secao !== aba; 
    });
    if (tituloEl && titulos[aba]) tituloEl.textContent = titulos[aba];
    if (history.replaceState) history.replaceState(null, '', '#' + aba);
  }

  navLinks.forEach(btn => {
    btn.addEventListener('click', () => ativarAba(btn.dataset.aba));
  });

  // Aba inicial: prioridade para o hash da URL, depois a aba definida pelo backend
  const abaHash = window.location.hash.replace('#', '');
  const abaBackend = document.body.dataset.abaInicial;
  const abaInicial = titulos[abaHash] ? abaHash : (titulos[abaBackend] ? abaBackend : 'dashboard');
  ativarAba(abaInicial);

  // Editores Quill (rich text)
  if (typeof Quill !== 'undefined') {
    const editores = [
        { editorId: 'editor-descricao', inputId: 'input-descricao' },
        { editorId: 'editor-resposta',  inputId: 'input-resposta'  },
        { editorId: 'editor-conteudo',  inputId: 'input-conteudo'  },
    ];

    editores.forEach(({ editorId, inputId }) => {
        const editorEl = document.getElementById(editorId);
        const input = document.getElementById(inputId);
        if (!editorEl || !input) return;

        const quill = new Quill('#' + editorId, {
        theme: 'snow',
        modules: {
            toolbar: [
            ['bold', 'italic', 'underline'],
            [{ list: 'ordered' }, { list: 'bullet' }],
            ['clean'],
            ],
        },
        });

        quill.on('text-change', () => { 
            input.value = quill.root.innerHTML; 
        });
            input.closest('form')?.addEventListener('submit', () => { 
                input.value = quill.root.innerHTML; 
        });
    });
  }
});