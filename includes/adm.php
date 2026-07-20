<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function validarTokenCSRF(): void {
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
        die("Requisição inválida.");
    }
}

if (empty($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/helpers.php';
$conn = criarConexaoBanco();

function inserirPrato(mysqli $conn): array {
    validarTokenCSRF();
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = filter_input(INPUT_POST, 'preco', FILTER_VALIDATE_FLOAT);

    if ($nome === '') {
        return ['ok' => false, 'msg' => 'Informe o nome do prato.'];
    }
    if ($preco === false || $preco === null || $preco < 0) {
        return ['ok' => false, 'msg' => 'Preço inválido.'];
    }

    try {
        $stmt = $conn->prepare("INSERT INTO pratos (nome, descricao, preco) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $nome, $descricao, $preco);
        $stmt->execute();
        $stmt->close();
        return ['ok' => true, 'msg' => 'Prato adicionado com sucesso!'];
    } catch (mysqli_sql_exception $e) {
        error_log('Erro ao inserir prato: ' . $e->getMessage());
        return ['ok' => false, 'msg' => 'Erro ao inserir prato.'];
    }
}

function inserirFaq(mysqli $conn): array {
    validarTokenCSRF();
    $pergunta = trim($_POST['pergunta'] ?? '');
    $resposta = trim($_POST['resposta'] ?? '');

    if ($pergunta === '' || $resposta === '') {
        return ['ok' => false, 'msg' => 'Preencha pergunta e resposta.'];
    }

    try {
        $stmt = $conn->prepare("INSERT INTO faq (pergunta, resposta) VALUES (?, ?)");
        $stmt->bind_param("ss", $pergunta, $resposta);
        $stmt->execute();
        $stmt->close();
        return ['ok' => true, 'msg' => 'FAQ adicionado com sucesso!'];
    } catch (mysqli_sql_exception $e) {
        error_log('Erro ao inserir FAQ: ' . $e->getMessage());
        return ['ok' => false, 'msg' => 'Erro ao inserir FAQ.'];
    }
}

function inserirFooter(mysqli $conn): array {
    validarTokenCSRF();
    $tipo = $_POST['tipo'] ?? '';
    $titulo = trim($_POST['titulo'] ?? '');
    $conteudo = trim($_POST['conteudo'] ?? '');

    if (!in_array($tipo, ['paginas', 'contato'], true) || $titulo === '') {
        return ['ok' => false, 'msg' => 'Preencha todos os campos do footer.'];
    }

    try {
        $stmt = $conn->prepare("INSERT INTO footer_info (tipo, titulo, conteudo) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $tipo, $titulo, $conteudo);
        $stmt->execute();
        $stmt->close();
        return ['ok' => true, 'msg' => 'Informação de footer adicionada com sucesso!'];
    } catch (mysqli_sql_exception $e) {
        error_log('Erro ao inserir footer: ' . $e->getMessage());
        return ['ok' => false, 'msg' => 'Erro ao inserir footer.'];
    }
}

function atualizarStatusPedido(mysqli $conn): array {
    validarTokenCSRF();
    $pedidoId = filter_input(INPUT_POST, 'pedido_id', FILTER_VALIDATE_INT);
    $status = $_POST['status'] ?? '';
    $statusValidos = ['recebido', 'preparando', 'em_entrega', 'entregue', 'cancelado'];

    if (!$pedidoId || !in_array($status, $statusValidos, true)) {
        return ['ok' => false, 'msg' => 'Não foi possível atualizar o pedido.'];
    }

    try {
        $stmt = $conn->prepare("UPDATE pedidos SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $pedidoId);
        $stmt->execute();
        $stmt->close();
        return ['ok' => true, 'msg' => 'Status do pedido #' . $pedidoId . ' atualizado.'];
    } catch (mysqli_sql_exception $e) {
        error_log('Erro ao atualizar status do pedido: ' . $e->getMessage());
        return ['ok' => false, 'msg' => 'Erro ao atualizar status.'];
    }
}

$mensagens = [];
$abaAtiva = 'dashboard';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_prato'])) {
        $mensagens[] = inserirPrato($conn);
        $abaAtiva = 'pratos';
    } elseif (isset($_POST['submit_faq'])) {
        $mensagens[] = inserirFaq($conn);
        $abaAtiva = 'faq';
    } elseif (isset($_POST['submit_footer'])) {
        $mensagens[] = inserirFooter($conn);
        $abaAtiva = 'footer';
    } elseif (isset($_POST['submit_status_pedido'])) {
        $mensagens[] = atualizarStatusPedido($conn);
        $abaAtiva = 'pedidos';
    }
}

function contar(mysqli $conn, string $sql): int {
    try {
        $res = $conn->query($sql);
        return (int) ($res->fetch_row()[0] ?? 0);
    } catch (mysqli_sql_exception $e) {
        return 0;
    }
}

$totalPratos = contar($conn, "SELECT COUNT(*) FROM pratos");
$totalFaq = contar($conn, "SELECT COUNT(*) FROM faq");
$totalPedidos = contar($conn, "SELECT COUNT(*) FROM pedidos");
$pedidosPendentes = contar($conn, "SELECT COUNT(*) FROM pedidos WHERE status IN ('recebido','preparando')");

$pedidos = [];
try {
    $resultPedidos = $conn->query(
        "SELECT id, nome_cliente, telefone, cidade, bairro, total, status, criado_em
         FROM pedidos ORDER BY criado_em DESC LIMIT 30"
    );
    while ($linha = $resultPedidos->fetch_assoc()) {
        $pedidos[] = $linha;
    }
} catch (mysqli_sql_exception $e) {

}

$statusLabels = [
    'recebido'    => ['label' => 'Recebido',    'classe' => 'status-recebido'],
    'preparando'  => ['label' => 'Preparando',  'classe' => 'status-preparando'],
    'em_entrega'  => ['label' => 'Em entrega',  'classe' => 'status-entrega'],
    'entregue'    => ['label' => 'Entregue',    'classe' => 'status-entregue'],
    'cancelado'   => ['label' => 'Cancelado',   'classe' => 'status-cancelado'],
];

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Gostinho Natural</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/adm.css">
    <link rel="icon" href="../assets/img/oven.svg">
    <link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>
</head>
<body class="adm-body" data-aba-inicial="<?= sanitize($abaAtiva) ?>">

    <aside class="adm-sidebar">
        <div class="adm-sidebar-header">
            <img src="../assets/img/oven.svg" alt="Logo" class="adm-sidebar-logo">
            <span class="adm-sidebar-brand">Gostinho Natural</span>
        </div>

        <nav class="adm-sidebar-nav">
            <button class="adm-nav-link" data-aba="dashboard">
                <i class="fas fa-gauge-high adm-nav-icon"></i> Dashboard
            </button>
            <button class="adm-nav-link" data-aba="pedidos">
                <i class="fas fa-receipt adm-nav-icon"></i> Pedidos
                <?php if ($pedidosPendentes > 0): ?>
                    <span class="adm-nav-badge"><?= $pedidosPendentes ?></span>
                <?php endif; ?>
            </button>
            <button class="adm-nav-link" data-aba="pratos">
                <i class="fas fa-utensils adm-nav-icon"></i> Pratos
            </button>
            <button class="adm-nav-link" data-aba="faq">
                <i class="fas fa-circle-question adm-nav-icon"></i> FAQ
            </button>
            <button class="adm-nav-link" data-aba="footer">
                <i class="fas fa-shoe-prints adm-nav-icon"></i> Footer
            </button>
        </nav>

        <div class="adm-sidebar-footer">
            <a href="/includes/index.php" class="adm-sidebar-link-site" target="_blank">
                <i class="fas fa-arrow-up-right-from-square"></i> Ver site
            </a>
            <form action="logout.php" method="post">
                <button type="submit" class="adm-logout-btn">
                    <i class="fas fa-right-from-bracket"></i> Sair
                </button>
            </form>
        </div>
    </aside>

    <main class="adm-main">

        <header class="adm-topbar">
            <div>
                <p class="adm-topbar-eyebrow">Painel administrativo</p>
                <h1 class="adm-topbar-title" id="adm-titulo-aba">Dashboard</h1>
            </div>
        </header>

        <?php foreach ($mensagens as $m): ?>
            <div class="adm-alerta <?= $m['ok'] ? 'adm-alerta-sucesso' : 'adm-alerta-erro' ?>">
                <i class="fas <?= $m['ok'] ? 'fa-circle-check' : 'fa-circle-exclamation' ?>"></i>
                <?= sanitize($m['msg']) ?>
            </div>
        <?php endforeach; ?>

        <section class="adm-secao" data-secao="dashboard">
            <div class="adm-cards-resumo">
                <div class="adm-card-resumo">
                    <i class="fas fa-receipt adm-card-icon"></i>
                    <div>
                        <p class="adm-card-numero"><?= $totalPedidos ?></p>
                        <p class="adm-card-label">Pedidos recebidos</p>
                    </div>
                </div>
                <div class="adm-card-resumo adm-card-resumo--alerta">
                    <i class="fas fa-hourglass-half adm-card-icon"></i>
                    <div>
                        <p class="adm-card-numero"><?= $pedidosPendentes ?></p>
                        <p class="adm-card-label">Pedidos em aberto</p>
                    </div>
                </div>
                <div class="adm-card-resumo">
                    <i class="fas fa-utensils adm-card-icon"></i>
                    <div>
                        <p class="adm-card-numero"><?= $totalPratos ?></p>
                        <p class="adm-card-label">Pratos cadastrados</p>
                    </div>
                </div>
                <div class="adm-card-resumo">
                    <i class="fas fa-circle-question adm-card-icon"></i>
                    <div>
                        <p class="adm-card-numero"><?= $totalFaq ?></p>
                        <p class="adm-card-label">Perguntas no FAQ</p>
                    </div>
                </div>
            </div>

            <p class="adm-dica">
                <i class="fas fa-lightbulb"></i>
                Use o menu lateral para gerenciar pedidos, pratos, FAQ e as informações do rodapé do site.
            </p>
        </section>

        <section class="adm-secao" data-secao="pedidos" hidden>
            <div class="adm-painel">
                <?php if (empty($pedidos)): ?>
                    <p class="adm-vazio">Nenhum pedido recebido ainda.</p>
                <?php else: ?>
                    <div class="adm-tabela-wrap">
                        <table class="adm-tabela">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>Cidade / Bairro</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Recebido em</th>
                                    <th>Atualizar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pedidos as $p):
                                    $st = $statusLabels[$p['status']] ?? ['label' => $p['status'], 'classe' => ''];
                                ?>
                                    <tr>
                                        <td>#<?= (int) $p['id'] ?></td>
                                        <td>
                                            <?= sanitize($p['nome_cliente']) ?>
                                            <span class="adm-tabela-sub"><?= sanitize($p['telefone']) ?></span>
                                        </td>
                                        <td>
                                            <?= sanitize($p['cidade']) ?>
                                            <span class="adm-tabela-sub"><?= sanitize($p['bairro']) ?></span>
                                        </td>
                                        <td>R$ <?= number_format((float) $p['total'], 2, ',', '.') ?></td>
                                        <td><span class="adm-status <?= $st['classe'] ?>"><?= sanitize($st['label']) ?></span></td>
                                        <td><?= date('d/m/Y H:i', strtotime($p['criado_em'])) ?></td>
                                        <td>
                                            <form method="post" class="adm-form-status">
                                                <input type="hidden" name="csrf_token" value="<?= sanitize($_SESSION['csrf_token']) ?>">
                                                <input type="hidden" name="pedido_id" value="<?= (int) $p['id'] ?>">
                                                <select name="status">
                                                    <?php foreach ($statusLabels as $valor => $info): ?>
                                                        <option value="<?= $valor ?>" <?= $valor === $p['status'] ? 'selected' : '' ?>>
                                                            <?= sanitize($info['label']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <button type="submit" name="submit_status_pedido" class="adm-btn-mini">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="adm-secao" data-secao="pratos" hidden>
            <form method="post" class="adm-form">
                <h2>Adicionar Prato</h2>
                <input type="hidden" name="csrf_token" value="<?= sanitize($_SESSION['csrf_token']) ?>">

                <label for="nome">Nome do Prato</label>
                <input type="text" id="nome" name="nome" required>

                <label for="editor-descricao">Descrição</label>
                <div id="editor-descricao" class="adm-editor"></div>
                <input type="hidden" name="descricao" id="input-descricao">

                <label for="preco">Preço (R$)</label>
                <input type="number" step="0.01" min="0" id="preco" name="preco" required>

                <button type="submit" name="submit_prato" class="adm-btn-primario">
                    <i class="fas fa-plus"></i> Adicionar Prato
                </button>
            </form>
        </section>

        <section class="adm-secao" data-secao="faq" hidden>
            <form method="post" class="adm-form">
                <h2>Adicionar Pergunta ao FAQ</h2>
                <input type="hidden" name="csrf_token" value="<?= sanitize($_SESSION['csrf_token']) ?>">

                <label for="pergunta">Pergunta</label>
                <input type="text" id="pergunta" name="pergunta" required>

                <label for="editor-resposta">Resposta</label>
                <div id="editor-resposta" class="adm-editor"></div>
                <input type="hidden" name="resposta" id="input-resposta">

                <button type="submit" name="submit_faq" class="adm-btn-primario">
                    <i class="fas fa-plus"></i> Adicionar FAQ
                </button>
            </form>
        </section>

        <section class="adm-secao" data-secao="footer" hidden>
            <form method="post" class="adm-form">
                <h2>Adicionar Informação do Footer</h2>
                <input type="hidden" name="csrf_token" value="<?= sanitize($_SESSION['csrf_token']) ?>">

                <label for="tipo">Tipo</label>
                <select id="tipo" name="tipo" required>
                    <option value="paginas">Páginas</option>
                    <option value="contato">Contato</option>
                </select>

                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" required>

                <label for="editor-conteudo">Conteúdo</label>
                <div id="editor-conteudo" class="adm-editor"></div>
                <input type="hidden" name="conteudo" id="input-conteudo">

                <button type="submit" name="submit_footer" class="adm-btn-primario">
                    <i class="fas fa-plus"></i> Adicionar ao Footer
                </button>
            </form>
        </section>

    </main>

    <script src="../assets/js/adm.js"></script>
</body>
</html>