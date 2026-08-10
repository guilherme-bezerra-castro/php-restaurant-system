document.addEventListener('DOMContentLoaded', () => {
    const carrinho = {};

    const cards = Array.from(document.querySelectorAll('.pedido-item-card'));
    const listaEl = document.getElementById('carrinhoLista');
    const vazioEl = document.getElementById('carrinhoVazio');
    const totalEl = document.getElementById('carrinhoTotal');
    const itensJsonInput = document.getElementById('itensJson');
    const finalizarBtn = document.getElementById('finalizarBtn');
    const form = document.getElementById('pedidoForm');

    function formatarMoeda(valor) {
    return 'R$ ' + valor.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function atualizarCarrinhoUI() {
    const ids = Object.keys(carrinho).filter(id => carrinho[id].quantidade > 0);

    listaEl.querySelectorAll('.pedido-carrinho-item').forEach(el => el.remove());
    vazioEl.hidden = ids.length > 0;

    let total = 0;
    ids.forEach(id => {
        const item = carrinho[id];
        const subtotal = item.preco * item.quantidade;
        total += subtotal;

        const linha = document.createElement('div');
        linha.className = 'pedido-carrinho-item';
        linha.innerHTML = `
        <span class="pedido-carrinho-item-nome">
            <span class="pedido-carrinho-item-qtd">${item.quantidade}x</span>
            ${item.nome}
        </span>
        <span class="pedido-carrinho-item-preco">${formatarMoeda(subtotal)}</span>
        <button type="button" class="pedido-carrinho-item-remover" data-id="${id}" aria-label="Remover ${item.nome}">
            <i class="fas fa-xmark"></i>
        </button>
        `;
        listaEl.appendChild(linha);
    });

    totalEl.textContent = formatarMoeda(total);

    listaEl.querySelectorAll('.pedido-carrinho-item-remover').forEach(btn => {
        btn.addEventListener('click', () => definirQuantidade(btn.dataset.id, 0));
    });

    itensJsonInput.value = JSON.stringify(
        ids.map(id => ({ id, quantidade: carrinho[id].quantidade }))
    );

    validarFinalizar();
    }

    function definirQuantidade(id, quantidade) {
    const card = cards.find(c => c.dataset.id === id);
    if (!card) return;

    quantidade = Math.max(0, Math.min(20, quantidade));

    if (!carrinho[id]) {
        carrinho[id] = {
        nome: card.dataset.nome,
        preco: parseFloat(card.dataset.preco),
        quantidade: 0,
        };
    }
    carrinho[id].quantidade = quantidade;

    const qtdEl = card.querySelector('.pedido-stepper-qtd');
    if (qtdEl) qtdEl.textContent = quantidade;
    card.classList.toggle('no-carrinho', quantidade > 0);

    atualizarCarrinhoUI();
    }

    cards.forEach(card => {
    const id = card.dataset.id;
    card.querySelectorAll('.pedido-stepper-btn').forEach(btn => {
        btn.addEventListener('click', () => {
        const atual = carrinho[id]?.quantidade || 0;
        const delta = btn.dataset.acao === 'mais' ? 1 : -1;
        definirQuantidade(id, atual + delta);
        });
    });
    });

    const paramsUrl = new URLSearchParams(window.location.search);
    const idPreSelecionado = paramsUrl.get('add');
    if (idPreSelecionado && cards.some(c => c.dataset.id === idPreSelecionado)) {
    definirQuantidade(idPreSelecionado, 1);
    const card = cards.find(c => c.dataset.id === idPreSelecionado);
    card?.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // Integra ViaCEP
    const CIDADES_ATENDIDAS = ['Salvador', 'Lauro de Freitas', 'Feira de Santana'];

    const cepInput = document.getElementById('cep');
    const buscarCepBtn = document.getElementById('buscarCepBtn');
    const cepStatus = document.getElementById('cepStatus');
    const enderecoInput = document.getElementById('endereco');
    const bairroInput = document.getElementById('bairro');
    const cidadeSelect = document.getElementById('cidade');

    function normalizar(texto) {
    return texto
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLowerCase()
        .trim();
    }

    cepInput?.addEventListener('input', () => {
    let v = cepInput.value.replace(/\D/g, '').slice(0, 8);
    if (v.length > 5) v = v.slice(0, 5) + '-' + v.slice(5);
    cepInput.value = v;
    });

    async function buscarCep() {
    const cep = cepInput.value.replace(/\D/g, '');

    if (cep.length !== 8) {
        cepStatus.textContent = 'Informe um CEP válido com 8 dígitos.';
        cepStatus.className = 'campo-ajuda campo-ajuda-erro';
        return;
    }

    cepStatus.textContent = 'Buscando endereço...';
    cepStatus.className = 'campo-ajuda';
    buscarCepBtn.disabled = true;

    try {
        const resposta = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const dados = await resposta.json();

        if (dados.erro) {
        cepStatus.textContent = 'CEP não encontrado. Preencha o endereço manualmente.';
        cepStatus.className = 'campo-ajuda campo-ajuda-erro';
        return;
        }

        if (dados.logradouro) enderecoInput.value = dados.logradouro;
        if (dados.bairro) bairroInput.value = dados.bairro;

        const cidadeEncontrada = CIDADES_ATENDIDAS.find(
        c => normalizar(c) === normalizar(dados.localidade || '')
        );

        if (cidadeEncontrada) {
        cidadeSelect.value = cidadeEncontrada;
        cepStatus.textContent = `Endereço encontrado em ${cidadeEncontrada}.`;
        cepStatus.className = 'campo-ajuda campo-ajuda-sucesso';
        } else {
        cidadeSelect.value = '';
        cepStatus.textContent =
            `Esse CEP é de ${dados.localidade || 'uma cidade não atendida'}. ` +
            `Só entregamos em ${CIDADES_ATENDIDAS.join(', ')}.`;
        cepStatus.className = 'campo-ajuda campo-ajuda-erro';
        }
    } catch (erro) {
        cepStatus.textContent = 'Não foi possível buscar o CEP agora. Preencha manualmente.';
        cepStatus.className = 'campo-ajuda campo-ajuda-erro';
    } finally {
        buscarCepBtn.disabled = false;
        validarFinalizar();
    }
    }

    buscarCepBtn?.addEventListener('click', buscarCep);
    cepInput?.addEventListener('blur', () => {
    if (cepInput.value.replace(/\D/g, '').length === 8) buscarCep();
    });


    const camposObrigatorios = ['nome', 'telefone', 'endereco', 'numero', 'bairro', 'cidade', 'forma_pagamento']
    .map(id => document.getElementById(id))
    .filter(Boolean);

    function carrinhoTemItens() {
    return Object.values(carrinho).some(item => item.quantidade > 0);
    }

    function validarFinalizar() {
    const camposPreenchidos = camposObrigatorios.every(campo => campo.value.trim() !== '');
    finalizarBtn.disabled = !(carrinhoTemItens() && camposPreenchidos);
    }

    camposObrigatorios.forEach(campo => {
    campo.addEventListener('input', validarFinalizar);
    campo.addEventListener('change', validarFinalizar);
    });

    form?.addEventListener('submit', (e) => {
    if (!carrinhoTemItens()) {
        e.preventDefault();
        alert('Adicione ao menos um item ao pedido antes de finalizar.');
        return;
    }

    if (!CIDADES_ATENDIDAS.includes(cidadeSelect.value)) {
        e.preventDefault();
        cidadeSelect.classList.add('campo-invalido');
        cidadeSelect.focus();
        return;
    }

    finalizarBtn.disabled = true;
    finalizarBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando pedido...';
    });

    validarFinalizar();
});