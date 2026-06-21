<?php 
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once __DIR__ . '/db.php';
$conn = criarConexaoBanco();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die("Requisição inválida.");
    }

    $nome_usuario = trim($_POST['nome_usuario'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $stmt = $conn->prepare(
        "SELECT id_usuario, nivel_acesso, senha 
        FROM usuario
        WHERE nome_usuario = ?"
    );

    $stmt->bind_param("s", $nome_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($usuario = $result->fetch_assoc()) {
        if(password_verify($senha, $usuario['senha'])) {
            session_regenerate_id(true);

            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nivel_acesso'] = $usuario['nivel_acesso'];

            $stmt->close();
            $conn->close();

            header("Location: adm.php");
            exit;
        }
    } 

    $erro = "Usuário ou senha incorretos.";
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="icon" href="../assets/img/oven.svg">
</head>
<body>
    <div class="login-container">
        <img src="../assets/img/oven.svg" alt="Logo Gostinho Natural" class="login-logo">
        <h2>Login de Administrador</h2>
        <form method="POST">
            <input type="hidden" name="csfr_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
            <input type="text" name="nome_usuario" placeholder="Usuário" required><br>
            <input type="password" name="senha" placeholder="Senha" required><br>
            <button type="submit">Entrar</button>
        </form>
        <a href="/includes/index.php" class="voltar-link">← Voltar para o início</a>
        <?php if(isset($erro)) echo "<p class='erro'>" . htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') . "</p>"; ?>
    </div>
</body>
</html>
