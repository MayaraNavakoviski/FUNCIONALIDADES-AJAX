<?php

require_once(__DIR__ . "/../../controller/ClienteController.php");
$clienteCont = new ClienteController();
$clientes = $clienteCont->clienteDAO->listar();
include_once(__DIR__ . "/../include/header.php");
?>


<div class="container my-5" blac>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h3 class="text-center mb-4" style="background: linear-gradient(-45deg, var(--bg-dark), var(--bg-darker),   var(--bg-dark)); color: black;">Clientes</h3>
            <table class="table table-bordered table-hover table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th style="width:140px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($clientes as $cliente): ?>
                        <tr class="text-center">
                            <td><?= $cliente->getId() ?></td>
                            <td><?= $cliente->getNome() ?></td>
                            <td><?= $cliente->getTelefone() ?></td>
                            <td><?= $cliente->getEmail() ?></td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="alterar.php?id=<?= $cliente->getId() ?>" class="btn btn-outline-primary btn-sm">Editar</a>
                                    <a href="excluir.php?id=<?= $cliente->getId() ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Confirma exclusão?')">Excluir</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mt-4 text-center">
                <a href="cadastrar.php" class="btn btn-primary btn-sm">Cadastrar Cliente</a>
                <a href="../ordem_servico/listar.php" class="btn btn-secondary btn-sm ms-2">Voltar</a>
            </div>
        </div>
    </div>
</div>