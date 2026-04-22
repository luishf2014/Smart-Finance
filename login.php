<?php

session_start();

if (isset($_SESSION['logado']) && $_SESSION['logado'] == true) {
    header('Location: index.php');
    exit;
}

$usuario_sistema = 'aluno';
$senha_hash = '$2y$10$FZa/wRehAUvT5xRrKJXL0.9ohae15crXOqQdnN48KTht./aeeChke';

$erro_login = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

    if ($usuario == '' || $senha == '') {
        $erro_login = 'Preencha usuário e senha.';
    } elseif ($usuario != $usuario_sistema) {
        $erro_login = 'Usuário ou senha incorretos.';
    } elseif (password_verify($senha, $senha_hash) == false) {
        $erro_login = 'Usuário ou senha incorretos.';
    } else {
        $_SESSION['logado'] = true;
        $_SESSION['nome_usuario'] = $usuario_sistema;
        if (!isset($_SESSION['transacoes'])) {
            $_SESSION['transacoes'] = array();
        }
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Controle Financeiro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow-sm mt-5">
                    <div class="card-body p-4">
                        <h4 class="card-title text-center mb-4">Controle Financeiro</h4>
                        <p class="text-muted text-center small mb-4">Entre com seu usuário e senha</p>

                        <?php if ($erro_login != '') { ?>
                            <div class="alert alert-danger py-2 small" role="alert">
                                <?php echo htmlspecialchars($erro_login); ?>
                            </div>
                        <?php } ?>

                        <form method="post" action="login.php">
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuário</label>
                                <input type="text" class="form-control" id="usuario" name="usuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="senha" name="senha" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Entrar</button>
                        </form>
                    </div>
                </div>
                <p class="text-center text-muted small mt-3">Trabalho acadêmico - PHP e Sessão</p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
