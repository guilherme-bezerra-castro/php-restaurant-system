<?php
require_once __DIR__ . '/helpers.php';

$navLinks = [
    ['href' => '/includes/index.php', 'label' => 'Início', 'icon' => 'fa-home'],
    ['href' => '/includes/cardapio.php', 'label' => 'Cardápio', 'icon' => 'fa-utensils'],
    ['href' => '/includes/locais.php', 'label' => 'Locais', 'icon' => 'fa-map-marker-alt'],
];

$dadosCardapio = require __DIR__ . '/data/conteudo_cardapio.php';
$cardapio = $dadosCardapio['cardapio'];
$secoes = $dadosCardapio['secoes'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gostinho Natural - Cardápio</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/home.css">
  <link rel="stylesheet" href="../assets/css/cardapio.css">
  <link rel="icon" href="../assets/img/oven.svg">
</head>
<body>

  <?php require_once __DIR__ . '/partials/sidebar.php'; ?>
  <?php require_once __DIR__ . '/partials/navbar.php'; ?>

  <main class="content" id="top">

    <section class="cardapio-hero">
      <div class="cardapio-hero-inner">
        <p class="hero-eyebrow">Culinária Baiana</p>
        <h1 class="cardapio-hero-title">Nosso<br><span>Cardápio</span></h1>
        <p class="cardapio-hero-desc">
          Pratos preparados com ingredientes frescos e receitas que respeitam
          a tradição da cozinha baiana. Do acarajé ao bobó, tudo com dendê de verdade.
        </p>
        <div class="cardapio-hero-nav">
          <?php foreach ($secoes as $id => $sec): ?>
            <a href="#<?= $id ?>" class="cardapio-hero-navlink">
              <i class="fas <?= $sec['icon'] ?>"></i>
              <?= $sec['label'] ?>
            </a>
          <?php endforeach; ?>
        </div>
        <a href="/includes/pedido.php" class="btn-primary cardapio-hero-cta">
          Fazer pedido
          <span class="btn-arrow"><i class="fas fa-arrow-right"></i></span>
        </a>
      </div>
      <div class="cardapio-hero-bg" style="background-image: url('../assets/img/bobo_camarao.jpg');"></div>
    </section>

    <?php foreach ($cardapio as $secId => $pratos):
      $sec = $secoes[$secId];
    ?>
      <section class="cardapio-section" id="<?= $secId ?>">
        <div class="cardapio-section-header reveal">
          <div>
            <p class="section-eyebrow"><?= $sec['eyebrow'] ?></p>
            <h2 class="section-title"><?= $sec['label'] ?></h2>
          </div>
          <span class="cardapio-section-count"><?= count($pratos) ?> itens</span>
        </div>

        <div class="cardapio-grid">
          <?php foreach ($pratos as $i => $prato): ?>
            <article class="prato-card reveal reveal-delay-<?= min(($i % 3) + 1, 3) ?>"
              data-nome="<?= strtolower(htmlspecialchars($prato['nome'])) ?>"
              data-desc="<?= strtolower(htmlspecialchars($prato['desc'])) ?>"
              data-secao="<?= $secId ?>">
              <div class="prato-card-img-wrap">
                <img src="<?= htmlspecialchars($prato['img']) ?>" alt="<?= htmlspecialchars($prato['nome']) ?>" loading="lazy">
                <?php if ($prato['destaque']): ?>
                  <span class="prato-badge">Destaque</span>
                <?php endif; ?>
              </div>
              <div class="prato-card-accent"></div>
                <div class="prato-card-body">
                  <h3 class="prato-card-nome"><?= htmlspecialchars($prato['nome']) ?></h3>
                  <p class="prato-card-desc"><?= htmlspecialchars($prato['desc']) ?></p>
                  <div class="prato-card-footer">
                    <p class="prato-card-preco">R$ <?= number_format($prato['preco'], 2, ',', '.') ?></p>
                    <a href="/includes/pedido.php?add=<?= urlencode($prato['id']) ?>" class="prato-card-pedir" title="Adicionar ao pedido">
                      <i class="fas fa-cart-plus"></i>
                    </a>
                  </div>
                </div>
            </article>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endforeach; ?>

    <div class="sem-resultados" id="semResultados" hidden>
      <i class="fas fa-search sem-resultados-icon"></i>
      <p class="sem-resultados-titulo">Nenhum prato encontrado</p>
      <p class="sem-resultados-sub">Tente outro termo ou <button class="sem-resultados-limpar" id="limparBusca">limpe a busca</button>.</p>
    </div>

  </main>

  <?php require_once __DIR__ . '/partials/footer.php'; ?>

  <script src="../assets/js/cardapio.js"></script>
</body>
</html>
