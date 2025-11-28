<?php
require_once __DIR__ . "/../../controller/OrdemServicoController.php";
require_once __DIR__ . "/../../model/OrdemServico.php";
require_once __DIR__ . "/../../model/Cliente.php";
require_once __DIR__ . "/../../model/TipoServico.php";

$ordemServicoCont = new OrdemServicoController();

$clientes = $ordemServicoCont->listarClientes();
$tiposServico = $ordemServicoCont->listarTiposServico();

$descricaoProblema = '';
$dataEntrada = '';
$prazoEstimado = '';
$status = '';
$idCliente = '';
$idTipoServico = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $descricaoProblema = $_POST['descricao_problema'] ?? '';
    $dataEntrada = $_POST['data_entrada'] ?? '';
    $prazoEstimado = $_POST['prazo_estimado_saida'] ?? '';
    $status = $_POST['status'] ?? '';
    $idCliente = $_POST['id_cliente'] ?? '';
    $idTipoServico = $_POST['id_tipo_servico'] ?? '';

    $bloqueados = ["Concluida", "Cancelada", "Concluída", "cancelada"];

    if (in_array($status, $bloqueados)) {
        echo "Não é permitido criar uma ordem Concluída ou Cancelada.";
        exit;
    }

    $ordemServico = new OrdemServico();
    $ordemServico->setDescricaoProblema($descricaoProblema);
    $ordemServico->setDataEntrada($dataEntrada);
    $ordemServico->setPrazoEstimadoSaida($prazoEstimado);
    $ordemServico->setStatus($status);

    $cliente = new Cliente();
    $cliente->setId((int)$idCliente);
    $ordemServico->setCliente($cliente);

    $tipoServico = new TipoServico();
    $tipoServico->setId((int)$idTipoServico);
    $ordemServico->setTipoServico($tipoServico);

    $resultado = $ordemServicoCont->cadastrar($ordemServico);

    if ($resultado === null) {
        echo "Ordem cadastrada com sucesso";
        exit;
    } else {
        if (is_array($resultado)) {
            echo implode("<br>", $resultado);
        } else {
            echo "Erro desconhecido";
        }
        exit;
    }
}

include_once(__DIR__ . "/form.php");