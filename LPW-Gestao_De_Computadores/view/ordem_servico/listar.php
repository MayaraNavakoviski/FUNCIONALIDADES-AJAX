<?php
require_once(__DIR__ . "/../../controller/OrdemServicoController.php");

$ordemServicoCont = new OrdemServicoController();
$lista = $ordemServicoCont->listar();

include_once(__DIR__ . "/../include/header.php");
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-11">

            <h5 class="text-center mb-4" style="color:#000; background: linear-gradient(-45deg, var(--bg-dark), var(--bg-darker), var(--bg-dark))">
                Listagem de Ordens de Serviço
            </h5>

            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Descrição do Problema</th>
                        <th>Tipo Serviço</th>
                        <th>Cliente</th>
                        <th style="width: 140px;">Data Entrada</th>
                        <th style="width: 160px;">Prazo Estimado</th>
                        <th>Status</th>
                        <th style="width:140px;">Ações</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($lista as $ordem): ?>
                        <tr class="text-center">

                            <td><?= $ordem->getId() ?></td>

                            <td><?= $ordem->getDescricaoProblema() ?></td>

                            <td>
                                <?= $ordem->getTipoServico() ? $ordem->getTipoServico()->getNome() : '' ?>
                            </td>

                            <td><?= $ordem->getCliente()->getNome() ?></td>

                            <td><?= date("d/m/Y", strtotime($ordem->getDataEntrada())) ?></td>

                            <td>
                                <?php
                                // Conversões ISO para o input type date
                                $prazoISO = date("Y-m-d", strtotime($ordem->getPrazoEstimadoSaida()));
                                $dataEntradaISO = date("Y-m-d", strtotime($ordem->getDataEntrada()));
                                $hojeISO = date("Y-m-d");
                                ?>

                                <!-- exibição da data -->
                                <?= date("d/m/Y", strtotime($ordem->getPrazoEstimadoSaida())) ?>

                                <!-- campo usado para conclusão -->
                                <input
                                    type="date"
                                    id="data_conclusao_<?= $ordem->getId() ?>"
                                    value="<?= $prazoISO ?>"
                                    min="<?= $dataEntradaISO ?>"
                                    max="<?= $hojeISO ?>"
                                    style="<?= ($ordem->getStatus() === 'Concluida')
                                                ? 'display:block;'
                                                : 'display:none;'
                                            ?> margin-top:5px; width:100%;">
                            </td>

                            <td style="min-width: 150px;">
                                <select class="form-control"
                                    id="status_os_<?= $ordem->getId() ?>"
                                    onchange="alterarStatus(<?= $ordem->getId() ?>)">

                                    <option value="Aberta"
                                        <?= ($ordem->getStatus() === "Aberta") ? "selected" : "" ?>>
                                        Aberta
                                    </option>

                                    <option value="Em andamento"
                                        <?= ($ordem->getStatus() === "Em andamento") ? "selected" : "" ?>>
                                        Em andamento
                                    </option>

                                    <option value="Concluida"
                                        <?= ($ordem->getStatus() === "Concluida") ? "selected" : "" ?>>
                                        Concluída
                                    </option>

                                    <option value="Cancelada"
                                        <?= ($ordem->getStatus() === "Cancelada") ? "selected" : "" ?>>
                                        Cancelada
                                    </option>

                                </select>
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="alterar.php?id=<?= $ordem->getId() ?>" class="btn btn-outline-primary btn-sm">
                                        Editar
                                    </a>

                                    <a href="excluir.php?id=<?= $ordem->getId() ?>"
                                        class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Confirma a exclusão?');">
                                        Excluir
                                    </a>
                                </div>
                            </td>

                        </tr>
                    <?php endforeach; ?>

                </tbody>

            </table>

            <div class="mt-4 text-center">
                <a href="inserir.php" class="btn btn-primary btn-sm">Nova Ordem</a>
                <a href="../ordem_servico/home.php" class="btn btn-secondary btn-sm ms-2">Voltar</a>
            </div>
        </div>
    </div>
</div>

<script src="js/ordem_servico.js"></script>