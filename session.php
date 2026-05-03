<?php

session_start();

$usuario_esta_logado = false;
if (isset($_SESSION['logado'])) {
    if ($_SESSION['logado'] == true) {
        $usuario_esta_logado = true;
    }
}

if ($usuario_esta_logado == false) {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['transacoes'])) {
    $_SESSION['transacoes'] = array();
}
