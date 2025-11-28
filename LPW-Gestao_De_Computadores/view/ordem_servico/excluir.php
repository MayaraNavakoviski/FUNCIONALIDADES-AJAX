<?php


require_once(__DIR__ . "/../../controller/OrdemServicoController.php");

$msgErro = "";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $ordemServicoCont = new OrdemServicoController();
    $erro = $ordemServicoCont->excluir($id);

    if ($erro) {
        $msgErro = "Erro ao excluir ordem de serviço: " . $erro->getMessage();
    } else {
        header("Location: listar.php?msg=excluido");
        exit;
    }
} else {
    $msgErro = "ID da ordem de serviço não informado.";
}

include_once(__DIR__ . "/../include/header.php");
?>

<div class="alert alert-danger">
    <?= $msgErro ?>
</div>
<a href="listar.php" class="btn btn-outline-primary">Voltar</a>
