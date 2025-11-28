<?php

require_once(__DIR__ . "/../util/Connection.php");
require_once(__DIR__ . "/../model/Cliente.php");

class ClienteDAO
{
    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = Connection::getConnection();
    }

    public function listar(): array
    {
        $sql = "SELECT * FROM cliente ORDER BY nome";
        $stm = $this->conexao->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->map($result);
    }

    public function buscarPorId(int $id): ?Cliente
    {
        $sql = "SELECT * FROM cliente WHERE id = ?";
        $stm = $this->conexao->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $clientes = $this->map($result);

        return count($clientes) > 0 ? $clientes[0] : null;
    }

    public function inserir(Cliente $cliente): ?PDOException
    {
        try {
            $sql = "INSERT INTO cliente (nome, telefone, email) VALUES (?, ?, ?)";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([
                $cliente->getNome(),
                $cliente->getTelefone(),
                $cliente->getEmail()
            ]);
            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function alterar(Cliente $cliente): ?PDOException
    {
        try {
            $sql = "UPDATE cliente SET nome = ?, telefone = ?, email = ? WHERE id = ?";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([
                $cliente->getNome(),
                $cliente->getTelefone(),
                $cliente->getEmail(),
                $cliente->getId()
            ]);
            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function excluirPorId(int $id): ?PDOException
    {
        try {
            $sql = "DELETE FROM cliente WHERE id = :id";
            $stm = $this->conexao->prepare($sql);
            $stm->bindValue(":id", $id);
            $stm->execute();
            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }

    private function map(array $result): array
    {
        $clientes = [];
        foreach ($result as $r) {
            $cliente = new Cliente();
            $cliente->setId($r["id"]);
            $cliente->setNome($r["nome"]);
            $cliente->setTelefone($r["telefone"]);
            $cliente->setEmail($r["email"]);

            $clientes[] = $cliente;
        }
        return $clientes;
    }
}