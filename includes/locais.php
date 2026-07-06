<?php

require_once __DIR__ . '/helpers.php';

$conteudo = require __DIR__ . '/data/conteudo_locais.php';
$locais = $conteudo['locais'];
$footer_paginas = $conteudo['footer_paginas'];
$footer_contato = $conteudo['footer_contato'];

?>

<!DOCTYPE html> 
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gostinho Natural - Locais</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/home.css">
  <link rel="stylesheet" href="../assets/css/locais.css">
  <link rel="icon" href="../assets/img/oven.svg">
</head>
<body>

  <?php require_once __DIR__ . '/partials/navbar.php'; ?>

  <?php require_once __DIR__ . '/partials/sidebar.php'; ?>

  <main class="content">
    
    <section class="locais-hero">
      <div class="locais-hero-inner">
        <p class="hero-eyebrow">Onde nos encontrar</p>
        <h1 class="locais-hero-title">Nossas<br><span>Filiais</span></h1>
        <p class="locais-hero-desc">Endereços, contatos e e-mails das nossas unidades. Escolha a mais perto de você.</p>
      </div>
      <div class="locais-hero-bg"></div>
    </section>

    <section class="locais-section">
      <div class="locais-grid" id="lista-locais">
        <?php foreach ($locais as $i => $local): ?>
          <div class="local-card reveal reveal-delay-<?= min($i + 1, 3) ?>">
            <div class="local-card-img-wrap">
              <img src="<?= sanitize($local['imagem']) ?>" alt="<?= sanitize($local['nome']) ?>">
              <div class="local-card-img-overlay"></div>
              <span class="local-card-number"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
            </div>
            <div class="local-card-body">
              <h3 class="local-card-name"><?= sanitize($local['nome']) ?></h3>
              <div class="local-card-info">
                <div class="local-info-item">
                  <i class="fas fa-map-marker-alt local-info-icon"></i>
                  <span><?= sanitize($local['endereco']) ?></span>
                </div>
                <div class="local-info-item">
                  <i class="fas fa-phone local-info-icon"></i>
                  <span><?= sanitize($local['telefone']) ?></span>
                </div>
                <div class="local-info-item">
                  <i class="fas fa-envelope local-info-icon"></i>
                  <a href="mailto:<?= sanitize($local['email']) ?>"><?= sanitize($local['email']) ?></a>
                </div>
              </div>
              <a href="https://maps.google.com/?q=<?= urlencode($local['endereco']) ?>" target="_blank" rel="noopener" class="local-card-btn">
                Ver no mapa <i class="fas fa-arrow-right"></i>
              </a>
            </div>
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
