<?php

require 'session.php';
require 'functions.php';

$msg_ok = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['limpar'])) {
        $_SESSION['transacoes'] = array();
        header('Location: historico.php?limpo=1');
        exit;
    }
}

if (isset($_GET['limpo'])) {
    if ($_GET['limpo'] == '1') {
        $msg_ok = 'Histórico limpo com sucesso.';
    }
}

$lista = $_SESSION['transacoes'];
$quantidade_transacoes = count($lista);
$tot_desp = totalDespesas($lista);

$titulo = 'Histórico - Controle Financeiro';
$pagina_menu = 'historico';
include 'includes/header.php';
include 'includes/menu.php';
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
        <h1 class="h3 mb-1 fw-semibold text-dark">Histórico</h1>
        <p class="text-muted mb-0 small">Todas as transações salvas nesta sessão.</p>
    </div>
    <a href="index.php" class="btn btn-primary rounded-3 shadow-sm"><i class="bi bi-plus-lg me-1"></i> Nova transação</a>
</div>

<?php if ($msg_ok != '') { ?>
    <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center gap-2" role="alert">
        <i class="bi bi-check-circle-fill flex-shrink-0"></i>
        <span><?php echo $msg_ok; ?></span>
    </div>
<?php } ?>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-body p-0">
        <?php if ($quantidade_transacoes == 0) { ?>
            <div class="text-center py-5 px-4">
                <div class="text-primary opacity-25 mb-3"><i class="bi bi-inbox display-1"></i></div>
                <p class="text-muted mb-2 fw-medium">Nenhuma transação ainda.</p>
                <p class="small text-muted mb-0">Volte ao <a href="index.php">dashboard</a> e cadastre receitas ou despesas.</p>
            </div>
        <?php } else { ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr class="small text-uppercase text-muted">
                            <th class="ps-4 py-3">Data</th>
                            <th class="py-3">Descrição</th>
                            <th class="py-3">Tipo</th>
                            <th class="py-3">Valor</th>
                            <th class="pe-4 py-3">% despesas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lista as $t) { ?>
                            <tr>
                                <td class="ps-4 text-muted small"><?php echo $t['data']; ?></td>
                                <td class="fw-medium"><?php echo $t['descricao']; ?></td>
                                <td>
                                    <?php if ($t['tipo'] == 'receita') { ?>
                                        <span class="badge rounded-pill text-bg-success">Receita</span>
                                    <?php } else { ?>
                                        <span class="badge rounded-pill text-bg-danger">Despesa</span>
                                    <?php } ?>
                                </td>
                                <td class="fw-semibold"><?php echo formatarReal($t['valor']); ?></td>
                                <td class="pe-4 small text-muted">
                                    <?php
                                    if ($t['tipo'] == 'despesa') {
                                        $percentual = percentualDespesa($t['valor'], $tot_desp);
                                        echo number_format($percentual, 1, ',', '.') . '% do total de despesas';
                                    } else {
                                        echo '—';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
</div>

<div class="mt-2 d-flex flex-wrap gap-2 align-items-center">
    <a href="index.php" class="btn btn-outline-secondary rounded-3"><i class="bi bi-arrow-left me-1"></i> Voltar ao resumo</a>
    <?php if ($quantidade_transacoes > 0) { ?>
        <form method="post" action="historico.php" class="d-inline">
            <input type="hidden" name="limpar" value="1">
            <button type="submit" class="btn btn-outline-danger rounded-3"><i class="bi bi-trash3 me-1"></i> Limpar histórico</button>
        </form>
    <?php } ?>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
