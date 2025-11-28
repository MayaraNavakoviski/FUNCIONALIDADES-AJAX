<?php
// cadastrar.php (CORRIGIDO - sem loop)
require_once(__DIR__ . "/../../controller/ClienteController.php");
require_once(__DIR__ . "/../../model/Cliente.php");

$msgErro = '';
$nome = '';
$telefone = '';
$email = '';

$controller = new ClienteController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $nome = $_POST['nome'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $email = $_POST['email'] ?? '';
    
    $cliente = new Cliente();
    $cliente->setNome($nome);
    $cliente->setTelefone($telefone);
    $cliente->setEmail($email);
    
    $erros = $controller->processarCadastro($cliente);
    
    if ($erros === null) {
        header('Location: listar.php?msg=Cliente cadastrado com sucesso!');
        exit;
    } else {
       
        $msgErro = implode('<br>', $erros);
    }
}

include_once(__DIR__ . "/form.php");
?>