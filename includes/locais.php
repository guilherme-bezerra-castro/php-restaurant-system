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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/locais.css">
  <link rel="icon" href="../assets/img/oven.svg">
</head>
<body class="hold-transition layout-top-nav">

  <?php require_once __DIR__ . '/partials/navbar.php'; ?>

  <?php require_once __DIR__ . '/partials/sidebar.php'; ?>

  <div class="content-wrapper">
    <section class="content-header text-center mt-4">
      <h1>Confira Nossas Filiais</h1>
      <p>Endereços, contatos e emails das nossas unidades.</p>
    </section>

    <section class="content pb-4">
      <div class="container">
        <div class="row" id="lista-locais">
          <?php foreach ($locais as $local): ?>
            <div class="col-md-4 mb-4">
              <div class="card h-100 shadow-sm">
                <img src="<?= sanitize($local['imagem']) ?>" class="card-img-top" alt="<?= sanitize($local['nome']) ?>">
                <div class="card-body">
                  <h5 class="card-title"><?= sanitize($local['nome']) ?></h5>
                  <p class="card-text">
                    <strong>Endereço:</strong> <?= sanitize($local['endereco']) ?><br>
                    <strong>Telefone:</strong> <?= sanitize($local['telefone']) ?><br>
                    <strong>Email:</strong> 
                    <a href="mailto:<?= sanitize($local['email']) ?>"><?= sanitize($local['email']) ?></a>
                  </p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  </div>

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
