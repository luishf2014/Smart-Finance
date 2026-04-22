<?php
$nome = isset($_SESSION['nome_usuario']) ? $_SESSION['nome_usuario'] : 'Usuário';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary rounded mb-4 px-3">
    <span class="navbar-brand mb-0 h1 small">Finanças</span>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="menuPrincipal">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="historico.php">Histórico</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Sair</a>
            </li>
        </ul>
        <span class="navbar-text text-white small">
            Olá, <?php echo htmlspecialchars($nome); ?>
        </span>
    </div>
</nav>
