<?php

require_once(__DIR__ . "/../../model/OrdemServico.php");
require_once(__DIR__ . "/../../model/Cliente.php");
require_once(__DIR__ . "/../../model/TipoServico.php");
require_once(__DIR__ . "/../../controller/OrdemServicoController.php");
require_once(__DIR__ . "/../../controller/ClienteController.php");
require_once(__DIR__ . "/../../controller/TipoServicoController.php");

$msgErro = "";
$ordemServico = null;

// Carrega listas de clientes e tipos de serviço para o select
$clienteCont = new ClienteController();
$clientes = $clienteCont->clienteDAO->listar();

$tipoServicoCont = new TipoServicoController();
$tiposServico = $tipoServicoCont->tipoServicoDAO->listar();

$ordemServicoCont = new OrdemServicoController();

// Se for GET, carrega os dados da ordem para edição
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $ordemServico = $ordemServicoCont->buscarPorId($id);
    if (!$ordemServico) {
        $msgErro = "Ordem de Serviço não encontrada.";
    }
}

// Se for POST, processa a alteração
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $descricaoProblema = $_POST['descricao_problema'];
    $dataEntrada = $_POST['data_entrada'];
    $prazoEstimadoSaida = $_POST['prazo_estimado_saida'];
    $status = $_POST['status'];
    $idCliente = $_POST['id_cliente'];
    $idTipoServico = $_POST['id_tipo_servico'];

    $ordemServico = new OrdemServico();
    $ordemServico->setId($id);
    $ordemServico->setDescricaoProblema($descricaoProblema);
    $ordemServico->setDataEntrada($dataEntrada);
    $ordemServico->setPrazoEstimadoSaida($prazoEstimadoSaida);
    $ordemServico->setStatus($status);

    $cliente = new Cliente();
    $cliente->setId($idCliente);
    $ordemServico->setCliente($cliente);

    $tipoServico = new TipoServico();
    $tipoServico->setId($idTipoServico);
    $ordemServico->setTipoServico($tipoServico);

    $erros = $ordemServicoCont->alterar($ordemServico);

    if (empty($erros)) {
        echo "<script>
        alert('Alteração concluída com sucesso!');
        window.location.href = 'listar.php'; // ou index.php se for a página principal
    </script>";
        exit;
    } else {
        $msgErro = is_array($erros) ? implode('<br>', $erros) : $erros;
    }
}

include_once(__DIR__ . "/../include/header.php");
?>


<h3 style="color:black;padding: 40px 0 20px 0">Editar Ordem de Serviço</h3>

<?php if ($msgErro): ?>
    <div class="alert alert-danger"><?= $msgErro ?></div>
<?php endif; ?>

<?php if ($ordemServico): ?>
    <form method="POST" action="" style="color: black">  
        <input type="hidden" name="id" value="<?= htmlspecialchars($ordemServico->getId()) ?>">
        <div class="mb-3">
            <label for="descricao_problema" class="form-label">Descrição do Problema</label>
            <textarea class="form-control" id="descricao_problema" name="descricao_problema" ><?= htmlspecialchars($ordemServico->getDescricaoProblema()) ?></textarea>
        </div>
        <div class="mb-3" style="color: black">
            <label for="id_cliente" class="form-label">Cliente</label>
            <select class="form-control" id="id_cliente" name="id_cliente" >
                <option value="">Selecione o Cliente</option>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?= $cliente->getId() ?>" <?= ($ordemServico->getCliente() && $ordemServico->getCliente()->getId() == $cliente->getId()) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cliente->getNome()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3" style="color: black">
            <label for="id_tipo_servico" class="form-label">Tipo de Serviço</label>
            <select class="form-control" id="id_tipo_servico" name="id_tipo_servico" >
                <option value="">Selecione o Tipo de Serviço</option>
                <?php foreach ($tiposServico as $tipo): ?>
                    <option value="<?= $tipo->getId() ?>" <?= ($ordemServico->getTipoServico() && $ordemServico->getTipoServico()->getId() == $tipo->getId()) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($tipo->getNome()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3" style="color: whiblackte">
            <label for="data_entrada" class="form-label">Data de Entrada</label>
            <input type="date" class="form-control" id="data_entrada" name="data_entrada"
                value="<?= htmlspecialchars(substr($ordemServico->getDataEntrada(), 0, 10)) ?>" >
        </div>
        <div class="mb-3" style="color: black">
            <label for="prazo_estimado_saida" class="form-label">Prazo Estimado de Saída</label>
            <input type="date" class="form-control" id="prazo_estimado_saida" name="prazo_estimado_saida"
                value="<?= htmlspecialchars($ordemServico->getPrazoEstimadoSaida()) ?>" >
        </div>
        <div class="mb-3" style="color: black">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status" >
                <option value="">Selecione</option>
                <option value="Aberta" <?= ($ordemServico && $ordemServico->getStatus() == "Aberta") ? "selected" : "" ?>>Aberta</option>
                <option value="Em andamento" <?= ($ordemServico && $ordemServico->getStatus() == "Em andamento") ? "selected" : "" ?>>Em andamento</option>
                <option value="Concluída" <?= ($ordemServico && $ordemServico->getStatus() == "Concluída") ? "selected" : "" ?>>Concluída</option>
                <option value="Cancelada" <?= ($ordemServico && $ordemServico->getStatus() == "Cancelada") ? "selected" : "" ?>>Cancelada</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="listar.php" class="btn btn-outline-primary">Voltar</a>
    </form>
<?php endif; ?>
