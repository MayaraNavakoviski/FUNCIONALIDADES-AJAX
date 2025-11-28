<?php


class TipoServico {
    private $id;
    private $nome;
    private $descricao;

    public function getId()  {
        return $this->id;
    }
    public function setId($id): self {
        $this->id = $id;
        return $this;
    }

    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome): self {
        $this->nome = $nome;
        return $this;
    }

    public function getDescricao() {
        return $this->descricao;
    }
    public function setDescricao($descricao): self {
        $this->descricao = $descricao;
        return $this;
    }

}