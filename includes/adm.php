<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function validarTokenCSRF(): void {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die("Requisição inválida.");
    }
}

if(empty($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/db.php';
$conn = criarConexaoBanco();

function inserirPrato(mysqli $conn): string {
    validarTokenCSRF();
    $nome     = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco    = $_POST['preco'];

    $stmt = $conn->prepare("INSERT INTO pratos (nome, descricao, preco) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $nome, $descricao, $preco);
    $sucesso = $stmt->execute();
    $stmt->close();

    return $sucesso ? "Prato inserido com sucesso!" : "Erro ao inserir prato.";
}

$mensagem = '';
if (isset($_POST['submit_prato'])) {
    $mensagem = inserirPrato($conn);
}

if(isset($_POST['submit_faq'])){
    validarTokenCSRF();
    $pergunta = $_POST['pergunta'];
    $resposta = $_POST['resposta'];

    $stmt = $conn->prepare("INSERT INTO faq (pergunta, resposta) VALUES (?, ?)");
    $stmt->bind_param("ss", $pergunta, $resposta);

    $sucesso = $stmt->execute();
    $stmt->close();

    $mensagem = $sucesso ? "FAQ inserido com sucesso." : "Erro ao inserir FAQ.";
}

if(isset($_POST['submit_footer'])){
    validarTokenCSRF();
    $tipo = $_POST['tipo'];
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];

    $stmt = $conn->prepare("INSERT INTO footer_info (tipo, titulo, conteudo) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $tipo, $titulo, $conteudo);

    $sucesso = $stmt->execute();
    $stmt->close();

    $mensagem = $sucesso ? "Footer inserido com sucesso." : "Erro ao inserir footer.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Admin - Home</title>
    <link rel="stylesheet" href="../assets/css/adm.css">
    <link rel="icon" href="../assets/img/oven.svg">
    <link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>
</head>
<body>
    <header class="admin-header">
        <h1>CRUD Home - Admin</h1>

        <form action="logout.php" method="post">
            <button type="submit">Sair</button>
        </form>
    </header>

    <h2>Adicionar Prato</h2>

    <?php if (!empty($mensagem)): ?>
        <p><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Nome do Prato:</label><br>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
        <input type="text" name="nome" required><br><br>

        <label>Descrição:</label><br>
        <div id="editor-descricao"></div>
        <input type="hidden" name="descricao" id="input-descricao">

        <label>Preço (R$):</label><br>
        <input type="number" step="0.01" name="preco" required><br><br>

        <input type="submit" name="submit_prato" value="Adicionar Prato">
    </form>

    <hr>

    <h2>Adicionar FAQ</h2>
    <form method="post">
        <label>Pergunta:</label><br>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
        <input type="text" name="pergunta" required><br><br>

        <label>Resposta:</label><br>
        <div id="editor-resposta"></div>
        <input type="hidden" name="resposta" id="input-resposta">

        <input type="submit" name="submit_faq" value="Adicionar FAQ">
    </form>

    <hr>

    <h2>Adicionar Informação do Footer</h2>
    <form method="post">
        <label>Tipo:</label><br>
        <select name="tipo" required>
            <option value="paginas">Páginas</option>
            <option value="contato">Contato</option>
        </select><br><br>

        <label>Título:</label><br>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
        <input type="text" name="titulo" required><br><br>

        <label>Conteúdo:</label><br>
        <div id="editor-conteudo"></div>
        <input type="hidden" name="conteudo" id="input-conteudo">

        <input type="submit" name="submit_footer" value="Adicionar Footer">
    </form>
    <script>
        const editores = [
            { editorId: 'editor-descricao', inputId: 'input-descricao' },
            { editorId: 'editor-resposta',  inputId: 'input-resposta'  },
            { editorId: 'editor-conteudo',  inputId: 'input-conteudo'  },
        ];

        editores.forEach(({ editorId, inputId }) => {
            const quill = new Quill('#' + editorId, {
            theme: 'snow',
            modules: {
                toolbar: [
                ['bold', 'italic', 'underline'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['clean']
                ]
            }
            });

            const input = document.getElementById(inputId);

            quill.on('text-change', () => {
            input.value = quill.root.innerHTML;
            });

            input.closest('form').addEventListener('submit', () => {
            input.value = quill.root.innerHTML;
            });
        });
    </script>
</body>
</html>