<?php
require_once(__DIR__ . "/../../controller/ClienteController.php");
require_once(__DIR__ . "/../../model/Cliente.php"); 

$controller = new ClienteController();
$msgErro = ''; 
$cliente = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $email = $_POST['email'] ?? '';

    $cliente = new Cliente();
    $cliente->setId($id);
    $cliente->setNome($nome);
    $cliente->setTelefone($telefone);
    $cliente->setEmail($email);

    $erros = $controller->alterar($cliente);

    if (empty($erros)) {
        header('Location: listar.php?msg=Cliente alterado com sucesso!');
        exit;
    } else {
        $msgErro = implode('<br>', $erros);
    }
} else {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $cliente = $controller->buscarPorId($id);
    }
}
?>

<?php include_once(__DIR__ . "/../include/header.php"); ?>

<div class="container my-5 text-black">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="form-card p-4">
                <div class="form-tabs d-flex mb-4">
                    <div class="form-tab flex-fill text-center">
                        <a href="cadastrar.php" style="text-decoration:none;color:inherit;">Cadastrar</a>
                    </div>
                    <div class="form-tab flex-fill text-center active" style="background:#000B58;color:#fff;border-radius:0 16px 0 0;">
                        Editar
                    </div>
                </div>
                <div class="form-avatar text-center mb-3">
                    <span class="form-avatar-icon" style="display:inline-block;width:48px;height:48px;background:#eee;border-radius:50%;">
                        <svg width="32" height="32" fill="#888" viewBox="0 0 16 16">
                            <path d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0z" />
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37c.69-1.19 2.065-2.37 5.468-2.37s4.778 1.18 5.468 2.37A7 7 0 0 0 8 1z" />
                        </svg>
                    </span>
                </div>

                
                <?php if (!empty($msgErro)): ?>
                    <div class="alert alert-danger text-center"><?= $msgErro ?></div>
                <?php endif; ?>

                <?php if ($cliente): ?>
                    <form method="POST" action="">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($cliente->getId()) ?>">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo"
                                value="<?= htmlspecialchars($cliente->getNome()) ?>">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone"
                                value="<?= htmlspecialchars($cliente->getTelefone()) ?>">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="E-mail"
                                value="<?= htmlspecialchars($cliente->getEmail()) ?>">
                        </div>
                        <button type="submit" class="btn btn-success w-100">Salvar</button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-danger text-center">Cliente não encontrado.</div>
                <?php endif; ?>
                <div class="form-footer mt-3 text-center">
                    <a href="listar.php">Voltar para listagem</a>
                </div>
            </div>
        </div>
    </div>
</div>
