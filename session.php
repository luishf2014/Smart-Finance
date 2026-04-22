<?php

session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] != true) {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['transacoes'])) {
    $_SESSION['transacoes'] = array();
}
