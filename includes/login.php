<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/helpers.php';

$erro = '';
$usuarioPreenchido = '';

if (empty($_SESSION['login_tentativas'])) {
    $_SESSION['login_tentativas'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
        $erro = "Sessão expirada. Recarregue a página e tente novamente.";
    } elseif ($_SESSION['login_tentativas'] >= 8) {
        $erro = "Muitas tentativas. Aguarde alguns minutos antes de tentar novamente.";
    } else {
        $nome_usuario = trim($_POST['nome_usuario'] ?? '');
        $senha = $_POST['senha'] ?? '';
        $usuarioPreenchido = $nome_usuario;

        if ($nome_usuario === '' || $senha === '') {
            $erro = "Preencha usuário e senha.";
        } else {
            try {
                $conn = criarConexaoBanco();

                $stmt = $conn->prepare(
                    "SELECT id_usuario, nivel_acesso, senha
                    FROM usuario
                    WHERE nome_usuario = ?"
                );
                $stmt->bind_param("s", $nome_usuario);
                $stmt->execute();
                $result = $stmt->get_result();
                $usuario = $result->fetch_assoc();
                $stmt->close();
                $conn->close();

                if ($usuario && password_verify($senha, $usuario['senha'])) {
                    session_regenerate_id(true);

                    $_SESSION['id_usuario'] = $usuario['id_usuario'];
                    $_SESSION['nivel_acesso'] = $usuario['nivel_acesso'];
                    $_SESSION['login_tentativas'] = 0;

                    header("Location: adm.php");
                    exit;
                }

                $_SESSION['login_tentativas']++;
                $erro = "Usuário ou senha incorretos.";
            } catch (mysqli_sql_exception $e) {
                error_log('Erro ao autenticar: ' . $e->getMessage());
                $erro = "Não foi possível autenticar agora. Tente novamente em instantes.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin - Gostinho Natural</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/home.css">
  <link rel="stylesheet" href="../assets/css/login.css">
  <link rel="icon" href="../assets/img/oven.svg">
</head>
<body class="login-body">

  <div class="login-page">

    <div class="login-brand-panel">
      <div class="login-brand-inner">
        <a href="/includes/index.php" class="login-brand-logo-link">
          <img src="../assets/img/oven.svg" alt="Logo Gostinho Natural" class="login-brand-logo">
        </a>
        <p class="hero-eyebrow">Área restrita</p>
        <h1 class="login-brand-title">Painel<br><span>Administrativo</span></h1>
        <p class="login-brand-desc">
          Gerencie o cardápio, o FAQ e as informações institucionais do site
          Gostinho Natural em um único lugar.
        </p>
      </div>
    </div>

    <div class="login-form-panel">
      <div class="login-container">
        <p class="login-eyebrow">Bem-vindo de volta</p>
        <h2>Entrar</h2>
        <p class="login-subtitle">Acesse com seu usuário e senha de administrador.</p>

        <?php if ($erro): ?>
          <p class="erro" role="alert"><i class="fas fa-circle-exclamation"></i> <?= sanitize($erro) ?></p>
        <?php endif; ?>

        <form method="POST" id="loginForm" novalidate>
          <input type="hidden" name="csrf_token" value="<?= sanitize($_SESSION['csrf_token']) ?>">

          <div class="campo">
            <label for="nome_usuario">Usuário</label>
            <div class="input-wrap">
              <i class="fas fa-user input-icon"></i>
              <input
                type="text"
                id="nome_usuario"
                name="nome_usuario"
                placeholder="Digite seu usuário"
                autocomplete="username"
                value="<?= sanitize($usuarioPreenchido) ?>"
                required
                autofocus>
            </div>
          </div>

          <div class="campo">
            <label for="senha">Senha</label>
            <div class="input-wrap">
              <i class="fas fa-lock input-icon"></i>
              <input
                type="password"
                id="senha"
                name="senha"
                placeholder="Digite sua senha"
                autocomplete="current-password"
                required>
              <button type="button" class="toggle-senha" id="toggleSenha" aria-label="Mostrar senha">
                <i class="fas fa-eye"></i>
              </button>
            </div>
          </div>

          <button type="submit" class="login-btn" id="loginBtn">
            <span class="login-btn-label">Entrar</span>
            <i class="fas fa-arrow-right login-btn-icon"></i>
          </button>
        </form>

        <a href="/includes/index.php" class="voltar-link">
          <i class="fas fa-arrow-left"></i> Voltar para o início
        </a>
      </div>
    </div>

  </div>

  <script src="../assets/js/login.js"></script>
</body>
</html>