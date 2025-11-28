<?php


class OrdemServico {
    private $id;
    private $descricao_problema;
    private $data_entrada;
    private $prazo_estimado_saida;
    private $status;
    private ?Cliente $cliente;           
    private ?TipoServico $tipoServico; 
   

    public function getId() {
        return $this->id;
    }
    public function setId($id): self  {
        $this->id = $id;
        return $this;
    }

    public function getDescricaoProblema()  {
        return $this->descricao_problema;
    }
    public function setDescricaoProblema($descricao_problema): self {
        $this->descricao_problema = $descricao_problema;
        return $this;
    }

    public function getDataEntrada() {
        return $this->data_entrada;
    }
    public function setDataEntrada($data_entrada): self {
        $this->data_entrada = $data_entrada;
        return $this;
    }

    public function getPrazoEstimadoSaida() {
        return $this->prazo_estimado_saida;
    }
    public function setPrazoEstimadoSaida($prazo_estimado_saida): self {
        $this->prazo_estimado_saida = $prazo_estimado_saida;
        return $this;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status): self {
        $this->status = $status;
        return $this;
    }

    public function getCliente(): ?Cliente {
        return $this->cliente;
    }
    public function setCliente(?Cliente $cliente): self {
        $this->cliente = $cliente;
        return $this;
    }

    public function getTipoServico(): ?TipoServico {
        return $this->tipoServico;
    }
    public function setTipoServico(?TipoServico $tipoServico): self {
        $this->tipoServico = $tipoServico;
        return $this;
    }
}