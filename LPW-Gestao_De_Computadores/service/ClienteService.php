<?php
// ClienteService.php
require_once __DIR__ . '/../model/Cliente.php';

class ClienteService
{
    public function validarCliente(Cliente $cliente): array
    {
        $erros = [];

        $nome = trim($cliente->getNome());
        if (empty($nome)) {
            $erros[] = "O nome é obrigatório.";
        } else {    
            if (strlen($nome) < 2) {
                $erros[] = "O nome deve ter pelo menos 2 caracteres.";
            }
            if (strlen($nome) > 100) {
                $erros[] = "O nome deve ter no máximo 100 caracteres.";
            }
            if (!preg_match('/^[a-zA-ZÀ-ÿ\s]+$/', $nome)) {
                $erros[] = "O nome deve conter apenas letras e espaços.";
            }
        }

        // validação do tel com DDD
        $telefone = trim($cliente->getTelefone());
        if (!empty($telefone)) {
            
            $telefoneLimpo = preg_replace('/[^0-9]/', '', $telefone);
            
            if (strlen($telefoneLimpo) < 10 || strlen($telefoneLimpo) > 11) {
                $erros[] = "O telefone deve ter 10 ou 11 dígitos (com DDD).";
            }
            
            if (!preg_match('/^[0-9]{10,11}$/', $telefoneLimpo)) {
                $erros[] = "Formato de telefone inválido.";
            }
        } else {
            $erros[] = "O telefone é obrigatório.";
        }

        $email = trim($cliente->getEmail());
        if (empty($email)) {
            $erros[] = "O e-mail é obrigatório.";
        } else {
            if (strlen($email) > 100) {
                $erros[] = "O e-mail deve ter no máximo 100 caracteres.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //função do php que verifica se o email está correto
                $erros[] = "Formato de e-mail inválido.";
            }
            
            
        }

        return $erros;
    }

    public function formatarTelefone(string $telefone): string
    {
        $telefoneLimpo = preg_replace('/[^0-9]/', '', $telefone);
        
        if (strlen($telefoneLimpo) === 11) {
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefoneLimpo);
        } elseif (strlen($telefoneLimpo) === 10) {
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telefoneLimpo);
        }
        
        return $telefone; // vai retornar original se não conseguir formatar
    }
}
?>