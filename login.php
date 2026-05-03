<?php

session_start();

if (isset($_SESSION['logado'])) {
    if ($_SESSION['logado'] == true) {
        header('Location: index.php');
        exit;
    }
}

$usuario_sistema = 'aluno';
$senha_hash = '$2y$10$FZa/wRehAUvT5xRrKJXL0.9ohae15crXOqQdnN48KTht./aeeChke';

$erro_login = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['usuario'])) {
        $usuario = trim($_POST['usuario']);
    } else {
        $usuario = '';
    }

    if (isset($_POST['senha'])) {
        $senha = $_POST['senha'];
    } else {
        $senha = '';
    }

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body.login-fundo {
            min-height: 100vh;
            background: linear-gradient(145deg, #0d6efd 0%, #6ea8fe 35%, #e9ecef 35%, #f8f9fa 100%);
        }
    </style>
</head>
<body class="login-fundo">
    <div class="container py-5 min-vh-100 d-flex flex-column justify-content-center">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary p-3 mb-3">
                                <i class="bi bi-piggy-bank display-6"></i>
                            </div>
                            <h1 class="h4 fw-semibold mb-1">Controle financeiro</h1>
                            <p class="text-muted small mb-0">Entre com usuário e senha</p>
                        </div>

                        <?php if ($erro_login != '') { ?>
                            <div class="alert alert-danger border-0 rounded-3 d-flex align-items-start gap-2 small" role="alert">
                                <i class="bi bi-exclamation-circle-fill flex-shrink-0 mt-1"></i>
                                <span><?php echo $erro_login; ?></span>
                            </div>
                        <?php } ?>

                        <form method="post" action="login.php">
                            <div class="mb-3">
                                <label for="usuario" class="form-label fw-medium">Usuário</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                                    <input type="text" class="form-control border-start-0 ps-0" id="usuario" name="usuario" placeholder="Digite o usuário" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="senha" class="form-label fw-medium">Senha</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-key text-muted"></i></span>
                                    <input type="password" class="form-control border-start-0 ps-0" id="senha" name="senha" placeholder="Digite a senha" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 btn-lg rounded-3 shadow-sm"><i class="bi bi-box-arrow-in-right me-2"></i>Entrar</button>
                        </form>
                    </div>
                </div>
                <p class="text-center text-secondary small mt-4 mb-0">Trabalho acadêmico — PHP e sessão</p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
