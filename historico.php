<?php

require __DIR__ . '/session.php';
require __DIR__ . '/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['limpar'])) {
    $_SESSION['transacoes'] = array();
    header('Location: historico.php');
    exit;
}

$lista = $_SESSION['transacoes'];
$tot_desp = totalDespesas($lista);

$titulo = 'Histórico - Controle Financeiro';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/menu.php';
?>

<h2 class="h4 mb-3">Histórico de transações</h2>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <?php if (count($lista) == 0) { ?>
            <p class="p-4 mb-0 text-muted">Nenhuma transação ainda. Volte ao dashboard e cadastre algumas.</p>
        <?php } else { ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>Data</th>
                            <th>Descrição</th>
                            <th>Tipo</th>
                            <th>Valor</th>
                            <th>Extra</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lista as $t) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($t['data']); ?></td>
                                <td><?php echo htmlspecialchars($t['descricao']); ?></td>
                                <td>
                                    <?php if ($t['tipo'] == 'receita') { ?>
                                        <span class="badge text-bg-success">Receita</span>
                                    <?php } else { ?>
                                        <span class="badge text-bg-danger">Despesa</span>
                                    <?php } ?>
                                </td>
                                <td><?php echo formatarReal($t['valor']); ?></td>
                                <td>
                                    <?php
                                    if ($t['tipo'] == 'despesa') {
                                        $p = percentualDespesa($t['valor'], $tot_desp);
                                        echo number_format($p, 1, ',', '.') . '% do total de despesas';
                                    } else {
                                        echo '-';
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

<div class="mt-4 d-flex flex-wrap gap-2">
    <a href="index.php" class="btn btn-secondary">Voltar</a>
    <?php if (count($lista) > 0) { ?>
        <form method="post" action="historico.php" class="d-inline" onsubmit="return confirm('Tem certeza que quer limpar todo o histórico?');">
            <input type="hidden" name="limpar" value="1">
            <button type="submit" class="btn btn-outline-danger">Limpar Histórico</button>
        </form>
    <?php } ?>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
