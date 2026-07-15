<?php
require_once __DIR__ . '/helpers.php';

$navLinks = [
    ['href' => '/includes/index.php', 'label' => 'Início', 'icon' => 'fa-home'],
    ['href' => '/includes/cardapio.php', 'label' => 'Cardápio', 'icon' => 'fa-utensils'],
    ['href' => '/includes/locais.php', 'label' => 'Locais', 'icon' => 'fa-map-marker-alt'],
];

$cardapio = [
    'salgados' => [
        [
            'nome' => 'Moqueca de Peixe',
            'desc' => 'Peixe fresco cozido no leite de coco, azeite de dendê, pimentão e coentro. Acompanha arroz e pirão.',
            'preco' => 52.90,
            'img' => '../assets/img/moqueca.jpg',
            'destaque' => true,
        ],
        [
            'nome' => 'Feijoada Baiana',
            'desc' => 'Feijão preto com carnes selecionadas, couve refogada, farofa e laranja. Tradição que aquece.',
            'preco' => 44.90,
            'img' => '../assets/img/feijoada.jpg',
            'destaque' => false,
        ],
        [
            'nome' => 'Vatapá',
            'desc' => 'Creme encorpado de pão, amendoim, camarão seco, leite de coco e azeite de dendê.',
            'preco' => 38.50,
            'img' => '../assets/img/vatapa.jpg',
            'destaque' => false,
        ],
        [
            'nome' => 'Caruru',
            'desc' => 'Quiabo refogado com camarão seco, amendoim, castanha de caju e azeite de dendê.',
            'preco' => 36.00,
            'img' => '../assets/img/caruru.jpg',
            'destaque' => false,
        ],
        [
            'nome' => 'Acarajé',
            'desc' => 'Bolinho de feijão-fradinho frito no dendê, recheado com vatapá, caruru e camarão.',
            'preco' => 22.00,
            'img' => '../assets/img/acaraje.jpg',
            'destaque' => true,
        ],
        [
            'nome' => 'Bobó de Camarão',
            'desc' => 'Camarão fresco em creme de mandioca com leite de coco e azeite de dendê. Servido com arroz.',
            'preco' => 58.00,
            'img' => '../assets/img/bobo_camarao.jpg',
            'destaque' => false,
        ],
        [
            'nome' => 'Galinha à Caipira',
            'desc' => 'Frango caipira ensopado com temperos baianos, servido com pirão e arroz branco.',
            'preco' => 46.00,
            'img' => '../assets/img/galinha_caipira.jpg',
            'destaque' => false,
        ],
    ],
    'sobremesas' => [
        [
            'nome' => 'Cocada de Forno',
            'desc' => 'Cocada cremosa assada com coco fresco ralado, leite condensado e gemas caramelizadas.',
            'preco' => 14.50,
            'img' => '../assets/img/cocada.jpg',
            'destaque' => true,
        ],
        [
            'nome' => 'Quindim',
            'desc' => 'Doce clássico baiano de gema de ovo, coco ralado e calda de açúcar. Textura sedosa.',
            'preco' => 12.00,
            'img' => '../assets/img/quindim.jpg',
            'destaque' => false,
        ],
        [
            'nome' => 'Manjar de Coco',
            'desc' => 'Manjar branco cremoso com calda de ameixa preta. Refrescante e delicado.',
            'preco' => 15.90,
            'img' => '../assets/img/manjar.jpg',
            'destaque' => false,
        ],
        [
            'nome' => 'Pé de Moleque',
            'desc' => 'Doce rústico de amendoim torrado com rapadura e caldo de cana. Crocante e intenso.',
            'preco' => 9.00,
            'img' => '../assets/img/pe_de_moleque.jpg',
            'destaque' => false,
        ],
    ],
    'bebidas' => [
        [
            'nome' => 'Suco de Acerola',
            'desc' => 'Acerola fresca batida na hora, rica em vitamina C. Servida gelada.',
            'preco' => 10.00,
            'img' => '../assets/img/suco_de_acerola.jpg',
            'destaque' => false,
        ],
        [
            'nome' => 'Água de Coco',
            'desc' => 'Coco verde gelado, aberto na hora. Natural, refrescante e hidratante.',
            'preco' => 8.50,
            'img' => '../assets/img/agua_de_coco.jpg',
            'destaque' => true,
        ],
        [
            'nome' => 'Suco de Cajá',
            'desc' => 'Fruta típica do Nordeste batida com água e pouco açúcar. Sabor único e tropical.',
            'preco' => 11.00,
            'img' => '../assets/img/suco_de_caja.jpg',
            'destaque' => false,
        ],
        [
            'nome' => 'Licor de Jabuticaba',
            'desc' => 'Licor artesanal feito com jabuticabas colhidas localmente. Encorpado e aromático.',
            'preco' => 16.00,
            'img' => '../assets/img/licor_de_jabuticaba.jpg',
            'destaque' => false,
        ],
    ],
];

$secoes = [
    'salgados'   => ['label' => 'Pratos Salgados', 'eyebrow' => 'Culinária Baiana', 'icon' => 'fa-bowl-food'],
    'sobremesas' => ['label' => 'Sobremesas', 'eyebrow' => 'Doce Final', 'icon' => 'fa-cake-candles'],
    'bebidas'    => ['label' => 'Bebidas', 'eyebrow' => 'Para Acompanhar', 'icon' => 'fa-glass-water'],
];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cardápio - Gostinho Natural</title>
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
                <p class="prato-card-preco">R$ <?= number_format($prato['preco'], 2, ',', '.') ?></p>
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

  <footer class="footer">
    <div class="footer-top">
      <div class="footer-brand">
        <p class="footer-brand-name">Gostinho<span>Natural</span></p>
        <p class="footer-tagline">Mais do que comida — é cuidado em cada prato, respeito à tradição e sabor que fica na memória.</p>
        <div class="footer-social">
          <a href="#" class="social-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-btn" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
          <a href="#" class="social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
        </div>
      </div>
      <div>
        <p class="footer-col-title">Páginas</p>
        <ul class="footer-links">
          <li><a href="/includes/index.php">Início</a></li>
          <li><a href="/includes/cardapio.php">Cardápio</a></li>
          <li><a href="/includes/locais.php">Locais</a></li>
        </ul>
      </div>
      <div>
        <p class="footer-col-title">Contato</p>
        <div class="footer-contact-item">
          <i class="fas fa-phone footer-contact-icon"></i>
          (71) 90000-0000
        </div>
        <div class="footer-contact-item">
          <i class="fas fa-envelope footer-contact-icon"></i>
          <a href="mailto:contato@gostinhonatural.com.br">contato@gostinhonatural.com.br</a>
        </div>
        <div class="footer-contact-item">
          <i class="fab fa-instagram footer-contact-icon"></i>
          <a href="#">@gostinhonatural</a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p class="footer-copy"><strong>Gostinho Natural</strong> &copy; 2025 — Todos os direitos reservados.</p>
      <span class="footer-oliva-pill">Sabor natural desde 2020</span>
    </div>
  </footer>

  <script src="../assets/js/cardapio.js"></script>
</body>
</html>
