<?php

require __DIR__ . '/session.php';
require __DIR__ . '/functions.php';

$msg_ok = '';
$msg_erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
    $valor = isset($_POST['valor']) ? str_replace(',', '.', $_POST['valor']) : '';
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';

    if (validarTexto($descricao) == false) {
        $msg_erro = 'A descrição não pode ficar vazia.';
    } elseif (validarValor($valor) == false) {
        $msg_erro = 'O valor precisa ser um número maior que zero.';
    } elseif ($tipo != 'receita' && $tipo != 'despesa') {
        $msg_erro = 'Escolha se é receita ou despesa.';
    } else {
        $nova = array(
            'data' => date('d/m/Y H:i'),
            'descricao' => trim($descricao),
            'valor' => floatval($valor),
            'tipo' => $tipo
        );
        $_SESSION['transacoes'][] = $nova;
        $msg_ok = 'Transação registrada com sucesso.';
    }
}

$lista = $_SESSION['transacoes'];
$tot_rec = totalReceitas($lista);
$tot_desp = totalDespesas($lista);
$saldo = saldoAtual($lista);

$titulo = 'Dashboard - Controle Financeiro';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/menu.php';
?>

<h2 class="h4 mb-3">Resumo</h2>

<?php if ($msg_ok != '') { ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($msg_ok); ?></div>
<?php } ?>
<?php if ($msg_erro != '') { ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($msg_erro); ?></div>
<?php } ?>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 bg-success text-white">
            <div class="card-body">
                <p class="small mb-1 opacity-75">Total Receitas</p>
                <p class="h5 mb-0"><?php echo formatarReal($tot_rec); ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 bg-danger text-white">
            <div class="card-body">
                <p class="small mb-1 opacity-75">Total Despesas</p>
                <p class="h5 mb-0"><?php echo formatarReal($tot_desp); ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 <?php echo $saldo >= 0 ? 'bg-info' : 'bg-warning'; ?> text-white">
            <div class="card-body">
                <p class="small mb-1 opacity-75">Saldo Atual</p>
                <p class="h5 mb-0"><?php echo formatarReal($saldo); ?></p>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <strong>Nova transação</strong>
    </div>
    <div class="card-body">
        <form method="post" action="index.php">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Descrição</label>
                    <input type="text" name="descricao" class="form-control" maxlength="120" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Valor (R$)</label>
                    <input type="text" name="valor" class="form-control" placeholder="ex: 50 ou 12.50" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tipo</label>
                    <select name="tipo" class="form-select" required>
                        <option value="">Selecione</option>
                        <option value="receita">Receita</option>
                        <option value="despesa">Despesa</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="historico.php" class="btn btn-outline-secondary">Ver Histórico</a>
                <a href="logout.php" class="btn btn-outline-danger">Sair</a>
            </div>
        </form>
    </div>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
