<?php
require_once __DIR__ . '/helpers.php';

$conteudo       = require __DIR__ . '/data/conteudo_home.php';
$carousel       = $conteudo['carousel'];
$pratos         = $conteudo['pratos'];
$faq            = $conteudo['faq'];
$footer_paginas = $conteudo['footer_paginas'];
$footer_contato = $conteudo['footer_contato'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gostinho Natural - Home</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/home.css">
  <link rel="icon" href="../assets/img/oven.svg">
</head>
<body>

  <?php require_once __DIR__ . '/partials/sidebar.php'; ?>
  <?php require_once __DIR__ . '/partials/navbar.php'; ?>

  <main class="content">

    <section class="hero" id="inicio">
      <div class="hero-left">
        <p class="hero-eyebrow">Comida de verdade, desde 2020</p>

        <h1 class="hero-title">
          Sabor que<br>
          <span>aquece</span>
          a alma
        </h1>

        <p class="hero-desc">
          Ingredientes frescos, receitas da tradição e o carinho de
          quem sabe que comida boa começa com respeito pela origem.
        </p>

        <div class="hero-actions">
          <a href="/includes/locais.php" class="btn-primary">
            Ver nossas filiais
            <span class="btn-arrow"><i class="fas fa-arrow-right"></i></span>
          </a>
          <a href="#informacoes" class="btn-ghost">
            <i class="fas fa-utensils"></i> Ver cardápio
          </a>
        </div>

        <div class="hero-badge">
          <img src="../assets/img/img1.jpg" alt="Prato do dia" class="hero-badge-img">
          <div class="hero-badge-content">
            <p class="hero-badge-label">Especialidades</p>
            <div class="hero-tags">
              <span class="hero-tag">Feijoada</span>
              <span class="hero-tag">Moqueca</span>
              <span class="hero-tag">Mineiro</span>
              <span class="hero-tag">Natural</span>
            </div>
          </div>
        </div>
      </div>

      <div class="hero-right">
        <img src="../assets/img/img2.jpg" alt="Prato Gostinho Natural">
      </div>
    </section>

    <section class="carousel-section" id="galeria">
      <span class="carousel-section-label">&#x2014; Nossa galeria &#x2014;</span>
      <div class="carousel">
        <div class="carousel-inner">
          <?php
          $legendas = [
            ['titulo' => 'Sabor autêntico', 'sub' => 'Pratos que contam histórias'],
            ['titulo' => 'Receitas da tradição', 'sub' => 'Do campo à sua mesa'],
            ['titulo' => 'Ingredientes frescos', 'sub' => 'Natureza em cada detalhe'],
          ];
          foreach ($carousel as $i => $img):
            $l = $legendas[$i] ?? $legendas[0];
          ?>
            <div class="carousel-item">
              <img src="<?= sanitize($img) ?>" alt="Slide <?= $i + 1 ?>">
              <div class="carousel-caption">
                <h3><?= sanitize($l['titulo']) ?></h3>
                <p><?= sanitize($l['sub']) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="carousel-controls">
          <button class="carousel-btn carousel-btn-prev" aria-label="Anterior">
            <i class="fas fa-arrow-left"></i>
          </button>
          <button class="carousel-btn carousel-btn-next" aria-label="Próximo">
            <i class="fas fa-arrow-right"></i>
          </button>
        </div>
        <div class="carousel-indicators">
          <?php foreach ($carousel as $i => $_): ?>
            <button class="<?= $i === 0 ? 'active' : '' ?>" aria-label="Slide <?= $i + 1 ?>"></button>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section id="informacoes" class="section">
      <div class="section-header reveal">
        <div>
          <p class="section-eyebrow">Cardápio</p>
          <h2 class="section-title">Nossos Pratos Típicos</h2>
        </div>
        <a href="/includes/cardapio.php" class="section-link">
          Ver cardápio completo <i class="fas fa-arrow-right"></i>
        </a>
      </div>
      <div class="pratos-container">
        <?php foreach ($pratos as $i => $prato): ?>
          <div class="prato-card reveal reveal-delay-<?= min($i + 1, 3) ?>">
            <div class="prato-card-accent"></div>
            <div class="prato-card-body">
              <h5><?= sanitize($prato['nome']) ?></h5>
              <p><?= sanitize($prato['descricao']) ?></p>
              <p class="preco">R$ <?= number_format($prato['preco'], 2, ',', '.') ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <section id="faq" class="faq-section">
      <div class="section-header reveal">
        <div>
          <p class="section-eyebrow">Dúvidas</p>
          <h2 class="section-title">Perguntas Frequentes</h2>
        </div>
      </div>
      <div class="faq-grid">
        <?php foreach ($faq as $i => $item): ?>
          <div class="faq-item reveal reveal-delay-<?= min(($i % 3) + 1, 3) ?>">
            <h5><?= sanitize($item['pergunta']) ?></h5>
            <p><?= sanitize($item['resposta']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

  </main>

  <footer class="footer">
    <div class="footer-top">
      <div class="footer-brand">
        <p class="footer-brand-name">Gostinho<span>Natural</span></p>
        <p class="footer-tagline">
          Mais do que comida — é cuidado em cada prato,
          respeito à tradição e sabor que fica na memória.
        </p>
        <div class="footer-social">
          <a href="#" class="social-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-btn" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
          <a href="#" class="social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
        </div>
      </div>
      <div>
        <p class="footer-col-title">Páginas</p>
        <ul class="footer-links">
          <?php foreach ($footer_paginas as $pagina): ?>
            <li><a href="#"><?= sanitize($pagina['conteudo']) ?></a></li>
          <?php endforeach; ?>
          <li><a href="/includes/login.php">Área Admin</a></li>
        </ul>
      </div>
      <div>
        <p class="footer-col-title">Contato</p>
        <?php foreach ($footer_contato as $contato): ?>
          <div class="footer-contact-item">
            <i class="fas fa-circle-dot footer-contact-icon"></i>
            <?= sanitize($contato['conteudo']) ?>
          </div>
        <?php endforeach; ?>
        <div class="footer-contact-item">
          <i class="fab fa-instagram footer-contact-icon"></i>
          <a href="#">@gostinhonatural</a>
        </div>
        <div class="footer-contact-item">
          <i class="fab fa-whatsapp footer-contact-icon"></i>
          <a href="#">(71) 90000-0000</a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p class="footer-copy">
        <strong>Gostinho Natural</strong> &copy; 2025 — Todos os direitos reservados.
      </p>
      <span class="footer-oliva-pill">Sabor natural desde 2020</span>
    </div>
  </footer>

  <script src="../assets/js/home.js"></script>
</body>
</html>
