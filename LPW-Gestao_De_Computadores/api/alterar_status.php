<?php
header('Content-Type: application/json; charset=utf-8');
require_once(__DIR__ . "/../controller/OrdemServicoController.php");

function responder($data, int $statusCode = 200)
{
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responder(["error" => "Método não permitido. Use POST."], 405);
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    responder(["error" => "JSON inválido."], 400);
}

$id = $input["id"] ?? null;
$status = $input["status"] ?? null;
$dataConclusao = $input["data_conclusao"] ?? null;

if (empty($id) || empty($status)) {
    responder(["error" => "ID e Status são obrigatórios."], 400);
}

$controller = new OrdemServicoController();
$resultado = $controller->atualizarStatus($id, $status, $dataConclusao);

if (isset($resultado["error"])) {
    responder(["success" => false, "message" => $resultado["error"]], 500);
}

$osAtualizada = $controller->buscarPorId($id);

responder([
    "success" => true,
    "message" => "Status da OS #{$id} atualizado.",
    "statusRecebido" => $status,
    "statusSalvo" => $osAtualizada?->getStatus(),
    "prazoEstimadoSalvo" => $osAtualizada?->getPrazoEstimadoSaida()
]);
