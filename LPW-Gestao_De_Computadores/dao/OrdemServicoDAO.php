<?php

require_once(__DIR__ . "/../util/Connection.php");
require_once(__DIR__ . "/../model/OrdemServico.php");
require_once(__DIR__ . "/../model/Cliente.php");
require_once(__DIR__ . "/../model/TipoServico.php");

class OrdemServicoDAO
{

    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = Connection::getConnection();
    }

    public function listar(): array
    {
        $sql = "SELECT os.*, 
                       cl.id AS cl_id, cl.nome AS cl_nome, cl.telefone, cl.email,
                       ts.id AS ts_id, ts.nome AS ts_nome
                  FROM ordem_servico os
                  LEFT JOIN cliente cl ON os.id_cliente = cl.id
                  LEFT JOIN tipo_servico ts ON os.id_tipo_servico = ts.id
                 ORDER BY os.data_abertura";
        $stm = $this->conexao->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->map($result);
    }



    public function buscarPorId(int $id)
    {
        $sql = "SELECT os.*, 
                       cl.id AS cl_id, cl.nome AS cl_nome, cl.telefone, cl.email,
                       ts.id AS ts_id, ts.nome AS ts_nome
                  FROM ordem_servico os
                  LEFT JOIN cliente cl ON os.id_cliente = cl.id
                  LEFT JOIN tipo_servico ts ON os.id_tipo_servico = ts.id
                 WHERE os.id = ?";
        $stm = $this->conexao->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $ordens = $this->map($result);

        return count($ordens) > 0 ? $ordens[0] : null;
    }

    public function inserir(OrdemServico $ordem): ?PDOException
    {
        try {
            $sql = "INSERT INTO ordem_servico 
                        (descricao_problema, data_abertura, prazo_estimado, status, id_cliente, id_tipo_servico)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([
                $ordem->getDescricaoProblema(),
                $ordem->getDataEntrada(),
                $ordem->getPrazoEstimadoSaida(),
                $ordem->getStatus(),
                $ordem->getCliente()->getId(),
                $ordem->getTipoServico()->getId()
            ]);
            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function alterar(OrdemServico $ordem): ?PDOException
    {
        try {
            $sql = "UPDATE ordem_servico
                       SET descricao_problema = ?, data_abertura = ?, prazo_estimado = ?, 
                           status = ?, id_cliente = ?, id_tipo_servico = ?
                     WHERE id = ?";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([
                $ordem->getDescricaoProblema(),
                $ordem->getDataEntrada(),
                $ordem->getPrazoEstimadoSaida(),
                $ordem->getStatus(),
                $ordem->getCliente()?->getId(),
                $ordem->getTipoServico()?->getId(),
                $ordem->getId()
            ]);
            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function excluirPorId($id): ?\PDOException
    {
        try {
            $sql = "DELETE FROM ordem_servico WHERE id = :id";
            $stm = $this->conexao->prepare($sql);
            $stm->bindValue(":id", $id);
            $stm->execute();
            return null;
        } catch (\PDOException $e) {
            return $e;
        }
    }

    private function map(array $result): array
    {
        $ordens = [];
        foreach ($result as $r) {
            $ordem = new OrdemServico();
            $ordem->setId($r["id"]);
            $ordem->setDescricaoProblema($r["descricao_problema"]);
            $ordem->setDataEntrada($r["data_abertura"]);
            $ordem->setPrazoEstimadoSaida($r["prazo_estimado"]);
            $ordem->setStatus($r["status"]);

            // Instanciar Cliente
            $cliente = new Cliente();
            $cliente->setId($r["cl_id"]);
            $cliente->setNome($r["cl_nome"]);
            $cliente->setTelefone($r["telefone"]);
            $cliente->setEmail($r["email"]);
            $ordem->setCliente($cliente);

            // Instanciar TipoServico 
            $tipoServico = new TipoServico();
            $tipoServico->setId($r["ts_id"]);
            $tipoServico->setNome($r["ts_nome"]);
            $ordem->setTipoServico($tipoServico);

            $ordens[] = $ordem;
        }
        return $ordens;
    }

    public function alterarStatus(OrdemServico $ordem): ?PDOException
    {
        try {
            $sql = "UPDATE ordem_servico
                    SET status = ?, prazo_estimado = ?
                    WHERE id = ?";

            $stm = $this->conexao->prepare($sql);

            $prazo = $ordem->getPrazoEstimadoSaida();

            $stm->bindValue(1, $ordem->getStatus(), PDO::PARAM_STR);

            if ($prazo === null || $prazo === "") {
                $stm->bindValue(2, null, PDO::PARAM_NULL);
            } else {
                $stm->bindValue(2, $prazo, PDO::PARAM_STR);
            }

            $stm->bindValue(3, $ordem->getId(), PDO::PARAM_INT);
            $stm->execute();

            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }
}
