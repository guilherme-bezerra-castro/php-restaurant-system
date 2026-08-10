<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/db.php';

const CIDADES_ATENDIDAS = ['Salvador', 'Lauro de Freitas', 'Feira de Santana'];

$dadosCardapio = require __DIR__ . '/data/conteudo_cardapio.php';
$cardapio = $dadosCardapio['cardapio'];
$secoes   = $dadosCardapio['secoes'];

$pratosPorId = [];
foreach ($cardapio as $itens) {
  foreach ($itens as $prato) {
    $pratosPorId[$prato['id']] = $prato;
  }
}

$erro = '';
$pedidoConfirmado = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
      $erro = "Sessão expirada. Recarregue a página e tente novamente.";
    } else {
      $itensBrutos = json_decode($_POST['itens_json'] ?? '[]', true);
      $nome = trim($_POST['nome'] ?? '');
      $telefone = trim($_POST['telefone'] ?? '');
      $cep = trim($_POST['cep'] ?? '');
      $endereco = trim($_POST['endereco'] ?? '');
      $numero = trim($_POST['numero'] ?? '');
      $complemento = trim($_POST['complemento'] ?? '');
      $bairro = trim($_POST['bairro'] ?? '');
      $cidade = trim($_POST['cidade'] ?? '');
      $formaPagamento = $_POST['forma_pagamento'] ?? '';
      $observacoes = trim($_POST['observacoes'] ?? '');

        $itensValidos = [];
        if (is_array($itensBrutos)) {
          foreach ($itensBrutos as $item) {
            $id = $item['id'] ?? '';
            $qtd = (int) ($item['quantidade'] ?? 0);
            if (isset($pratosPorId[$id]) && $qtd > 0 && $qtd <= 20) {
              $itensValidos[] = [
                'id' => $id,
                'nome' => $pratosPorId[$id]['nome'],
                'preco' => (float) $pratosPorId[$id]['preco'],
                'quantidade' => $qtd,
              ];
            }
          }
        }

        $formasPagamentoValidas = ['pix', 'dinheiro', 'cartao'];

        if (empty($itensValidos)) {
          $erro = "Seu carrinho está vazio. Adicione ao menos um item ao pedido.";
        } elseif ($nome === '' || mb_strlen($nome) < 3) {
          $erro = "Informe seu nome completo.";
        } elseif (!preg_match('/^[\d\s()+-]{8,20}$/', $telefone)) {
          $erro = "Informe um telefone válido para contato.";
        } elseif ($endereco === '' || $numero === '' || $bairro === '') {
          $erro = "Preencha endereço, número e bairro para a entrega.";
        } elseif (!in_array($cidade, CIDADES_ATENDIDAS, true)) {
          $erro = "No momento só entregamos em " . implode(', ', CIDADES_ATENDIDAS) . ".";
        } elseif (!in_array($formaPagamento, $formasPagamentoValidas, true)) {
          $erro = "Selecione uma forma de pagamento.";
        } else {
          $total = 0.0;
          foreach ($itensValidos as $item) {
            $total += $item['preco'] * $item['quantidade'];
          }

          $conn = criarConexaoBanco();
          $conn->begin_transaction();

          try {
            $stmt = $conn->prepare(
              "INSERT INTO pedidos(nome_cliente, telefone, cep, endereco, numero, complemento, bairro, cidade, forma_pagamento, observacoes, total)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );

            $stmt->bind_param("ssssssssssd", $nome, $telefone, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $formaPagamento, $observacoes, $total);
            $stmt->execute();
            $pedidoId = $stmt->insert_id;
            $stmt->close();

            $stmtItem = $conn->prepare(
              "INSERT INTO pedido_itens (pedido_id, prato_codigo, nome_prato, quantidade, preco_unitario)
              VALUES (?, ?, ?, ?, ?)"
            );
            foreach ($itensValidos as $item) {
                $stmtItem->bind_param(
                  "issid",
                  $pedidoId, $item['id'], $item['nome'], $item['quantidade'], $item['preco']
                );
                $stmtItem->execute();
            }
            $stmtItem->close();

            $conn->commit();
            $conn->close();

            $pedidoConfirmado = [
              'id' => $pedidoId,
              'total' => $total,
              'itens' => $itensValidos,
              'cidade' => $cidade,
            ];
          } catch (mysqli_sql_exception $e) {
            $conn->rollback();
            $conn->close();
            error_log("Erro ao registrar pedido: " . $e->getMessage());
            $erro = "Não foi possível registrar seu pedido agora. Tente novamente em instantes.";
          }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fazer Pedido - Gostinho Natural</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/home.css">
  <link rel="stylesheet" href="../assets/css/cardapio.css">
  <link rel="stylesheet" href="../assets/css/pedido.css">
  <link rel="icon" href="../assets/img/oven.svg">
</head>
<body>

  <?php require_once __DIR__ . '/partials/sidebar.php'; ?>
  <?php require_once __DIR__ . '/partials/navbar.php'; ?>

  <main class="content" id="top">

    <?php if ($pedidoConfirmado): ?>

      <section class="pedido-confirmacao">
        <div class="pedido-confirmacao-card">
          <div class="pedido-confirmacao-icone"><i class="fas fa-circle-check"></i></div>
          <p class="hero-eyebrow">Pedido recebido</p>
          <h1 class="pedido-confirmacao-titulo">Obrigado! Seu pedido<br><span>#<?= (int) $pedidoConfirmado['id'] ?></span> foi confirmado</h1>
          <p class="pedido-confirmacao-desc">
            Vamos preparar tudo com carinho para entrega em
            <strong><?= sanitize($pedidoConfirmado['cidade']) ?></strong>.
            Em breve entraremos em contato para confirmar os detalhes.
          </p>

          <div class="pedido-confirmacao-resumo">
            <?php foreach ($pedidoConfirmado['itens'] as $item): ?>
              <div class="pedido-confirmacao-item">
                <span><?= sanitize($item['quantidade']) ?>x <?= sanitize($item['nome']) ?></span>
                <span>R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?></span>
              </div>
            <?php endforeach; ?>
            <div class="pedido-confirmacao-total">
              <span>Total</span>
              <span>R$ <?= number_format($pedidoConfirmado['total'], 2, ',', '.') ?></span>
            </div>
          </div>

          <div class="pedido-confirmacao-acoes">
            <a href="/includes/index.php" class="btn-primary">Voltar ao início</a>
            <a href="/includes/pedido.php" class="btn-ghost">Fazer outro pedido</a>
          </div>
        </div>
      </section>

    <?php else: ?>

      <section class="pedido-hero">
        <div class="pedido-hero-inner">
          <p class="hero-eyebrow">Peça sem sair de casa</p>
          <h1 class="pedido-hero-title">Monte seu<br><span>Pedido</span></h1>
          <p class="pedido-hero-desc">
            Escolha os pratos, informe o endereço e finalize. Por enquanto,
            entregamos em <strong><?= implode(', ', CIDADES_ATENDIDAS) ?></strong>.
          </p>
        </div>
        <div class="pedido-hero-bg" style="background-image: url('../assets/img/acaraje.jpg');"></div>
      </section>

      <?php if ($erro): ?>
        <div class="pedido-erro-global" role="alert">
          <i class="fas fa-circle-exclamation"></i> <?= sanitize($erro) ?>
        </div>
      <?php endif; ?>

      <form method="POST" id="pedidoForm" class="pedido-layout" novalidate>
        <input type="hidden" name="csrf_token" value="<?= sanitize($_SESSION['csrf_token']) ?>">
        <input type="hidden" name="itens_json" id="itensJson" value="[]">

        <div class="pedido-menu">
          <?php foreach ($cardapio as $secId => $pratos): $sec = $secoes[$secId]; ?>
            <section class="pedido-menu-secao" id="<?= $secId ?>">
              <div class="cardapio-section-header reveal">
                <div>
                  <p class="section-eyebrow"><?= sanitize($sec['eyebrow']) ?></p>
                  <h2 class="section-title"><?= sanitize($sec['label']) ?></h2>
                </div>
              </div>

              <div class="pedido-grid">
                <?php foreach ($pratos as $prato): ?>
                  <article class="pedido-item-card" data-id="<?= sanitize($prato['id']) ?>" data-nome="<?= sanitize($prato['nome']) ?>" data-preco="<?= $prato['preco'] ?>">
                    <img src="<?= sanitize($prato['img']) ?>" alt="<?= sanitize($prato['nome']) ?>" class="pedido-item-img" loading="lazy">
                    <div class="pedido-item-body">
                      <h3 class="pedido-item-nome"><?= sanitize($prato['nome']) ?></h3>
                      <p class="pedido-item-preco">R$ <?= number_format($prato['preco'], 2, ',', '.') ?></p>
                      <div class="pedido-item-stepper">
                        <button type="button" class="pedido-stepper-btn" data-acao="menos" aria-label="Diminuir quantidade">−</button>
                        <span class="pedido-stepper-qtd">0</span>
                        <button type="button" class="pedido-stepper-btn" data-acao="mais" aria-label="Aumentar quantidade">+</button>
                      </div>
                    </div>
                  </article>
                <?php endforeach; ?>
              </div>
            </section>
          <?php endforeach; ?>
        </div>

        <aside class="pedido-resumo" id="pedidoResumo">
          <div class="pedido-resumo-inner">

            <h2 class="pedido-resumo-titulo"><i class="fas fa-cart-shopping"></i> Seu pedido</h2>

            <div class="pedido-carrinho-lista" id="carrinhoLista">
              <p class="pedido-carrinho-vazio" id="carrinhoVazio">Seu carrinho está vazio. Adicione pratos ao lado.</p>
            </div>

            <div class="pedido-carrinho-total">
              <span>Total</span>
              <span id="carrinhoTotal">R$ 0,00</span>
            </div>

            <hr class="pedido-divisor">

            <h3 class="pedido-secao-titulo">Dados para entrega</h3>

            <div class="campo">
              <label for="nome">Nome completo</label>
              <input type="text" id="nome" name="nome" placeholder="Seu nome" required>
            </div>

            <div class="campo">
              <label for="telefone">Telefone / WhatsApp</label>
              <input type="tel" id="telefone" name="telefone" placeholder="(71) 90000-0000" required>
            </div>

            <div class="campo campo-cep">
              <label for="cep">CEP</label>
              <div class="campo-cep-wrap">
                <input type="text" id="cep" name="cep" placeholder="00000-000" inputmode="numeric" maxlength="9">
                <button type="button" id="buscarCepBtn" class="pedido-btn-cep">
                  <i class="fas fa-magnifying-glass-location"></i>
                </button>
              </div>
              <span class="campo-ajuda" id="cepStatus">Preencha o CEP para localizarmos seu endereço automaticamente.</span>
            </div>

            <div class="campo-linha">
              <div class="campo campo-endereco">
                <label for="endereco">Endereço</label>
                <input type="text" id="endereco" name="endereco" placeholder="Rua, Av..." required>
              </div>
              <div class="campo campo-numero">
                <label for="numero">Nº</label>
                <input type="text" id="numero" name="numero" placeholder="123" required>
              </div>
            </div>

            <div class="campo">
              <label for="complemento">Complemento (opcional)</label>
              <input type="text" id="complemento" name="complemento" placeholder="Apto, bloco, referência...">
            </div>

            <div class="campo">
              <label for="bairro">Bairro</label>
              <input type="text" id="bairro" name="bairro" placeholder="Seu bairro" required>
            </div>

            <div class="campo">
              <label for="cidade">Cidade</label>
              <select id="cidade" name="cidade" required>
                <option value="">Selecione a cidade</option>
                <?php foreach (CIDADES_ATENDIDAS as $c): ?>
                  <option value="<?= sanitize($c) ?>"><?= sanitize($c) ?></option>
                <?php endforeach; ?>
              </select>
              <span class="campo-ajuda">Entregamos apenas nestas 3 cidades por enquanto.</span>
            </div>

            <div class="campo">
              <label for="forma_pagamento">Forma de pagamento</label>
              <select id="forma_pagamento" name="forma_pagamento" required>
                <option value="">Selecione</option>
                <option value="pix">Pix</option>
                <option value="cartao">Cartão (na entrega)</option>
                <option value="dinheiro">Dinheiro</option>
              </select>
            </div>

            <div class="campo">
              <label for="observacoes">Observações (opcional)</label>
              <textarea id="observacoes" name="observacoes" rows="2" placeholder="Ponto de referência, restrições, etc."></textarea>
            </div>

            <button type="submit" class="adm-btn-primario pedido-btn-finalizar" id="finalizarBtn" disabled>
              <i class="fas fa-check"></i> Finalizar Pedido
            </button>
          </div>
        </aside>

      </form>

    <?php endif; ?>

  </main>

  <?php require_once __DIR__ . '/partials/footer.php'; ?>

  <script src="../assets/js/pedido.js"></script>
</body>
</html>