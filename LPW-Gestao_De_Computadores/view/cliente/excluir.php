<?php

require_once(__DIR__ . "/../../controller/ClienteController.php");

$msgErro = "";
$id = 0;

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $clienteCont = new ClienteController();
    $erro = $clienteCont->excluir($id);

    if ($erro) {
        $msgErro = "Erro ao excluir cliente: " . $erro->getMessage();
    } else {
        header("Location: listar.php");
        exit;
    }
} else {
    $msgErro = "ID do cliente não informado.";
}

include_once(__DIR__ . "/../include/header.php");
?>

<div class="alert alert-danger">
    <?= $msgErro ?>
</div>
<a href="listar.php" class="btn btn-outline-primary">Voltar</a>
