<?php

if (isset($_SESSION['nome_usuario'])) {
    $nome = $_SESSION['nome_usuario'];
} else {
    $nome = 'Usuário';
}

$menu_dashboard_ativo = '';
$menu_historico_ativo = '';
if (isset($pagina_menu)) {
    if ($pagina_menu == 'index') {
        $menu_dashboard_ativo = 'active fw-semibold';
    }
    if ($pagina_menu == 'historico') {
        $menu_historico_ativo = 'active fw-semibold';
    }
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary rounded-4 shadow-sm mb-4 px-3 py-2">
    <a class="navbar-brand d-flex align-items-center gap-2 mb-0" href="index.php">
        <span class="rounded-3 bg-white bg-opacity-25 p-2 d-inline-flex"><i class="bi bi-piggy-bank fs-5"></i></span>
        <span class="fw-semibold">Controle financeiro</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Abrir menu">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="menuPrincipal">
        <ul class="navbar-nav ms-lg-4 me-auto mb-2 mb-lg-0 gap-lg-1">
            <li class="nav-item">
                <a class="nav-link rounded-3 px-3 <?php echo $menu_dashboard_ativo; ?>" href="index.php"><i class="bi bi-speedometer2 me-1"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-3 px-3 <?php echo $menu_historico_ativo; ?>" href="historico.php"><i class="bi bi-table me-1"></i> Histórico</a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-3 px-3 text-white-50" href="logout.php"><i class="bi bi-box-arrow-right me-1"></i> Sair</a>
            </li>
        </ul>
        <span class="navbar-text text-white small d-flex align-items-center gap-2 mt-2 mt-lg-0 py-2 py-lg-0 border-top border-lg-0 border-white border-opacity-25">
            <i class="bi bi-person-circle fs-5 opacity-75"></i>
            <span>Olá, <strong><?php echo $nome; ?></strong></span>
        </span>
    </div>
</nav>
