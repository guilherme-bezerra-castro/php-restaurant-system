<?php
// Função de escape para segurança
function sanitize($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$conteudo = require __DIR__ . '/data/conteudo_home.php';
$carousel = $conteudo['carousel'];
$pratos = $conteudo['pratos'];
$faq = $conteudo['faq'];
$footer_paginas = $conteudo['footer_paginas'];
$footer_contato = $conteudo['footer_contato'];

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gostinho Natural - Home</title>
  <link rel="stylesheet" href="../assets/css/home.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">  
  <link rel="icon" href="../assets/img/oven.svg">
</head>
<body>

  <?php require_once __DIR__ . '/partials/navbar.php'; ?>

  <?php require_once __DIR__ . '/partials/sidebar.php'; ?>

  <main class="content">
    <div id="meuCarousel" class="carousel">
      <div class="carousel-inner">
        <?php foreach($carousel as $indiceImagem => $caminhoImagem): ?>
          <div class="carousel-item <?= $indiceImagem === 0 ? 'active' : '' ?>">
            <img src="<?= sanitize($caminhoImagem) ?>" alt="Imagem <?= $indiceImagem+1 ?>">
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="carousel-indicators">
      <?php foreach($carousel as $indiceImagem => $caminhoImagem): ?>
        <button class="<?= $indiceImagem===0?'active':'' ?>" data-slide-to="<?= $indiceImagem ?>"></button>
      <?php endforeach; ?>
    </div>

    <section id="informacoes" class="info-section">
      <div class="container">
        <h2 class="text-center mb-4">Nossos Pratos Típicos</h2>
        <div class="pratos-container">
          <?php foreach($pratos as $prato): ?>
            <div class="prato-card">
              <h5><?= sanitize($prato['nome']) ?></h5>
              <p><?= sanitize($prato['descricao']) ?></p>
              <p class="preco">Preço: R$ <?= number_format($prato['preco'],2,",",".") ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section id="faq" class="faq-section">
      <div class="container">
        <h2 class="text-center mb-4">Perguntas Frequentes</h2>
        <?php foreach($faq as $i => $itemFaq): ?>
          <div class="faq-item">
            <h5><?= ($i+1) ?>. <?= sanitize($itemFaq['pergunta']) ?></h5>
            <p><?= sanitize($itemFaq['resposta']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  </main>

  <footer class="footer">
    <div class="container-fluid">
      <div class="footer-content">
        <div class="footer-left">
          <h6>Páginas</h6>
          <ul class="list-unstyled">
            <?php foreach($footer_paginas as $pagina): ?>
              <li><a href="#"><?= sanitize($pagina['conteudo']) ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="footer-right">
          <h6>Contato</h6>
          <ul class="list-unstyled">
            <?php foreach($footer_contato as $contato): ?>
              <li><?= sanitize($contato['conteudo']) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <strong>Gostinho Natural</strong> &copy; 2025
      </div>
    </div>
  </footer>

  <script src="../assets/js/home.js"></script>
</body>
</html>