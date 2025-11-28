<?php

require_once(__DIR__ . "/../dao/TipoServicoDAO.php");

class TipoServicoController {

    public TipoServicoDAO $tipoServicoDAO;

    public function __construct() {
        $this->tipoServicoDAO = new TipoServicoDAO;
    }

    public function listar() {
        return $this->tipoServicoDAO->listar();
    }

}