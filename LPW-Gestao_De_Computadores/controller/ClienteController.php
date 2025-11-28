<?php
// ClienteController.php
require_once __DIR__ . '/../model/Cliente.php';
require_once __DIR__ . '/../dao/ClienteDAO.php';
require_once __DIR__ . '/../service/ClienteService.php';

class ClienteController {

    public ClienteDAO $clienteDAO;
    private ClienteService $clienteService;
    
    public function __construct() {
        $this->clienteDAO = new ClienteDAO();
        $this->clienteService = new ClienteService();
    }
    
    public function listar() {
        $clientes = $this->clienteDAO->listar();
        include __DIR__ . '/../view/cliente/listar.php';
    }
    
    public function processarCadastro(Cliente $cliente): ?array
    {
        // Validação
        $erros = $this->clienteService->validarCliente($cliente);
        
        if (!empty($erros)) {
            return $erros;
        }

        // Inserção no banco
        try {
            $erro = $this->clienteDAO->inserir($cliente);
            
            if ($erro !== null) {
                return ["Erro no banco de dados: " . $erro->getMessage()];
            }
            
            return null; 
        } catch (Exception $e) {
            return ["Erro inesperado: " . $e->getMessage()];
        }
    }

    public function alterar(Cliente $cliente): array
    {
        $erros = $this->clienteService->validarCliente($cliente);
        
        if (!empty($erros)) {
            return $erros;
        }

        $erro = $this->clienteDAO->alterar($cliente);
        if ($erro !== null) {
            $erros[] = "Erro ao atualizar: " . $erro->getMessage();
        }

        return $erros;
    }
    
    public function excluir() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $erro = $this->clienteDAO->excluirPorId($id);

            if ($erro === null) {
                header('Location: listar.php?sucesso=1');
                exit;
            } else {
                header('Location: listar.php?erro=' . urlencode($erro->getMessage()));
                exit;
            }
        }

        header('Location: listar.php?erro=ID não informado');
        exit;
    }

    public function buscarPorId($id) {
        return $this->clienteDAO->buscarPorId($id);
    }
}
?>