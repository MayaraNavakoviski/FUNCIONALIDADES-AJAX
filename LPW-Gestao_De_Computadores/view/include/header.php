<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" 
          rel="stylesheet" crossorigin="anonymous">

    <title>Gestão de Computadores</title>
</head>

<body class="min-h-screen flex flex-col">

<?php
$isHome = basename($_SERVER['PHP_SELF']) === 'home.php';
$navbarClass = $isHome ? 'navbar-home' : '';
include(__DIR__ . "/navbar.php");
?>

<!-- WRAPPER FLEXIVEL DO CONTEÚDO -->
<div class="flex-1 flex flex-col">
    <?php if (!$isHome) {
        echo '<div class="container py-4 flex-1">';
    } ?>
