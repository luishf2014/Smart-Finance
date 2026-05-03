<?php

require_once 'session.php';
require_once 'functions.php';

$msg_ok = '';
$msg_erro = '';

if (isset($_GET['cadastro'])) {
    if ($_GET['cadastro'] == 'ok') {
        $msg_ok = 'Transação registrada com sucesso.';
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['descricao'])) {
        $descricao = $_POST['descricao'];
    } else {
        $descricao = '';
    }

    if (isset($_POST['valor'])) {
        $valor_bruto = $_POST['valor'];
    } else {
        $valor_bruto = '';
    }
    $valor = str_replace(',', '.', $valor_bruto);

    if (isset($_POST['tipo'])) {
        $tipo = $_POST['tipo'];
    } else {
        $tipo = '';
    }

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
        header('Location: index.php?cadastro=ok');
        exit;
    }
}

$lista = $_SESSION['transacoes'];
$tot_rec = totalReceitas($lista);
$tot_desp = totalDespesas($lista);
$saldo = saldoAtual($lista);

if ($saldo >= 0) {
    $classe_cor_saldo = 'bg-primary text-white';
} else {
    $classe_cor_saldo = 'bg-danger text-white';
}

$titulo = 'Dashboard - Controle Financeiro';
$pagina_menu = 'index';

include 'includes/header.php';
include 'includes/menu.php';
?>

<div class="mb-4">
    <h1 class="h3 mb-1 fw-semibold text-dark">Resumo</h1>
    <p class="text-muted mb-0 small">Receitas, despesas e saldo com base no que você cadastrou nesta sessão.</p>
</div>

<?php if ($msg_ok != '') { ?>
    <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center gap-2" role="alert">
        <i class="bi bi-check-circle-fill flex-shrink-0"></i>
        <span><?php echo $msg_ok; ?></span>
    </div>
<?php } ?>
<?php if ($msg_erro != '') { ?>
    <div class="alert alert-danger border-0 shadow-sm rounded-3 d-flex align-items-center gap-2" role="alert">
        <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
        <span><?php echo $msg_erro; ?></span>
    </div>
<?php } ?>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden bg-success text-white">
            <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between gap-2">
                    <div>
                        <p class="small mb-1 text-white-50 text-uppercase">Receitas</p>
                        <p class="h4 mb-0 fw-semibold"><?php echo formatarReal($tot_rec); ?></p>
                    </div>
                    <span class="rounded-3 bg-white bg-opacity-25 p-2"><i class="bi bi-graph-up-arrow fs-4"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden bg-danger text-white">
            <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between gap-2">
                    <div>
                        <p class="small mb-1 text-white-50 text-uppercase">Despesas</p>
                        <p class="h4 mb-0 fw-semibold"><?php echo formatarReal($tot_desp); ?></p>
                    </div>
                    <span class="rounded-3 bg-white bg-opacity-25 p-2"><i class="bi bi-graph-down-arrow fs-4"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden <?php echo $classe_cor_saldo; ?>">
            <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between gap-2">
                    <div>
                        <p class="small mb-1 opacity-75 text-uppercase">Saldo</p>
                        <p class="h4 mb-0 fw-semibold"><?php echo formatarReal($saldo); ?></p>
                    </div>
                    <span class="rounded-3 bg-white bg-opacity-25 p-2"><i class="bi bi-wallet2 fs-4"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white border-0 py-3 px-4 rounded-top-4 d-flex align-items-center gap-2">
        <i class="bi bi-plus-circle-fill text-primary"></i>
        <strong class="mb-0">Nova transação</strong>
    </div>
    <div class="card-body p-4">
        <form method="post" action="index.php">
            <div class="row g-3">
                <div class="col-lg-6">
                    <label class="form-label fw-medium" for="campo_descricao">Descrição</label>
                    <input type="text" name="descricao" id="campo_descricao" class="form-control form-control-lg shadow-sm" maxlength="120" placeholder="Ex.: Salário, almoço, transporte..." required>
                </div>
                <div class="col-md-6 col-lg-3">
                    <label class="form-label fw-medium" for="campo_valor">Valor</label>
                    <div class="input-group input-group-lg shadow-sm">
                        <span class="input-group-text bg-light border-end-0">R$</span>
                        <input type="text" name="valor" id="campo_valor" class="form-control border-start-0 ps-0" placeholder="0,00" required>
                    </div>
                    <div class="form-text">Use ponto ou vírgula (ex.: 50 ou 12,50).</div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <label class="form-label fw-medium" for="campo_tipo">Tipo</label>
                    <select name="tipo" id="campo_tipo" class="form-select form-select-lg shadow-sm" required>
                        <option value="">Selecione</option>
                        <option value="receita">Receita</option>
                        <option value="despesa">Despesa</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 pt-2 d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-primary btn-lg px-4 rounded-3 shadow-sm"><i class="bi bi-check2 me-2"></i>Salvar</button>
                <a href="historico.php" class="btn btn-outline-secondary btn-lg rounded-3"><i class="bi bi-list-ul me-2"></i>Ver histórico</a>
                <a href="logout.php" class="btn btn-outline-danger btn-lg rounded-3 ms-md-auto"><i class="bi bi-box-arrow-right me-2"></i>Sair</a>
            </div>
        </form>
    </div>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
