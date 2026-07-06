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
    <div class="container-fluid">
      <div class="footer-content">
        <div class="footer-left">
          <h6>Páginas</h6>
          <ul class="list-unstyled">
            <li><a href="/includes/index.php"><i class="fas fa-home"></i> Início</a></li>
            <li><a href="/includes/locais.php"><i class="fas fa-map-marker-alt"></i> Locais</a></li>
          </ul>
        </div>
        <div class="footer-right">
          <h6>Contato</h6>
          <ul class="list-unstyled">
            <li><i class="fab fa-instagram"></i> @gostinhonatural</li>
            <li><i class="fab fa-whatsapp"></i> (71) 90000-0000</li>
            <li><a href="mailto:contato@gostinhonatural.com"><i class="fas fa-envelope"></i> gostinhonatural@email.com</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <strong>Gostinho Natural</strong> &copy; 2025
      </div>
    </div>
  </footer>

</body>
</html>
