<?php

require_once(__DIR__ . "/../util/Connection.php");
require_once(__DIR__ . "/../model/TipoServico.php");

class TipoServicoDAO {

    private PDO $conexao;

    public function __construct() {
        $this->conexao = Connection::getConnection();
    }

    public function listar(): array {
        $sql = "SELECT * FROM tipo_servico ORDER BY nome";
        $stm = $this->conexao->prepare($sql);
        $stm->execute();
        $resultado = $stm->fetchAll();

        return $this->map($resultado);
    }

    public function buscarPorId(int $id) {
        $sql = "SELECT * FROM tipo_servico WHERE id = ?";
        $stm = $this->conexao->prepare($sql);
        $stm->execute([$id]);
        $resultado = $stm->fetchAll();

        $tipos = $this->map($resultado);

        return count($tipos) > 0 ? $tipos[0] : null;
    }

    
    // Mapeia o resultado do banco para objetos TipoServico
    private function map(array $resultado): array {
        $tipos = [];
        foreach($resultado as $r) {
            $tipo = new TipoServico();
            $tipo->setId($r["id"]);
            $tipo->setNome($r["nome"]);
            // $tipo->setDescricao($r["descricao"]);
            $tipos[] = $tipo;
        }
        return $tipos;
    }
}