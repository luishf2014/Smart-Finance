<?php
if (!isset($titulo)) {
    $titulo = 'Controle Financeiro';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $titulo; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body.app-fundo {
            min-height: 100vh;
            background: linear-gradient(165deg, #e3f2fd 0%, #f8f9fa 40%, #eceff1 100%);
        }
    </style>
</head>
<body class="app-fundo">
<div class="container py-4 pb-5">
