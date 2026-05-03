<?php

function formatarReal($valor)
{
    $valor = floatval($valor);
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

function totalReceitas($transacoes)
{
    $soma = 0;
    foreach ($transacoes as $t) {
        if ($t['tipo'] == 'receita') {
            $soma = $soma + floatval($t['valor']);
        }
    }
    return $soma;
}

function totalDespesas($transacoes)
{
    $soma = 0;
    foreach ($transacoes as $t) {
        if ($t['tipo'] == 'despesa') {
            $soma = $soma + floatval($t['valor']);
        }
    }
    return $soma;
}

function saldoAtual($transacoes)
{
    $receitas = totalReceitas($transacoes);
    $despesas = totalDespesas($transacoes);
    $saldo = $receitas - $despesas;
    return $saldo;
}

function percentualDespesa($valor, $total)
{
    if ($total == 0) {
        return 0;
    }
    $valor = floatval($valor);
    $total = floatval($total);
    $percentual = ($valor / $total) * 100;
    return $percentual;
}

function validarTexto($texto)
{
    $texto = trim($texto);
    if ($texto == '') {
        return false;
    }
    return true;
}

function validarValor($valor)
{
    if ($valor == '' || $valor == null) {
        return false;
    }
    if (is_numeric($valor) == false) {
        return false;
    }
    if (floatval($valor) <= 0) {
        return false;
    }
    return true;
}

