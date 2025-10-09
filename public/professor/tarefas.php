<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';


require_once __DIR__ . '/../../api/tarefa/create.php';
require_once __DIR__ . '/../../api/tarefa/read.php';
require_once __DIR__ . '/../../api/tarefa/update.php';
require_once __DIR__ . '/../../api/tarefa/delete.php';


require_login();
require_role('professor');

// Criar nova tarefa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['__act']) && $_POST['__act'] === 'create') {
  createTarefa($_POST['titulo'], $_POST['descricao'], $_POST['data_entrega']);
}

// Excluir tarefa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  deleteTarefa($_POST['delete_id']);
}

// Editar tarefa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_tarefa_id'])) {
  $id           = $_POST['edit_tarefa_id'];
  $titulo       = $_POST['titulo'];
  $descricao    = $_POST['descricao'];
  $dataEntrega  = $_POST['data_entrega'];
  updateTarefa($id, $titulo, $descricao, $dataEntrega);
}

$tarefas = readTarefa();
?>

<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool — Gerenciar Tarefas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">

      <div class="row g-4">

        <!-- Criar nova tarefa -->
        <div class="col-12 col-lg-4">
          <div class="card h-100">
            <div class="card-body">
              <h2 class="h6 mb-3">Criar nova tarefa</h2>

              <form method="post">
                <input type="hidden" name="__act" value="create">

                <div class="mb-3">
                  <label class="form-label">Título</label>
                  <input name="titulo" class="form-control" required>
                </div>

                <div class="mb-3">
                  <label class="form-label">Descrição</label>
                  <textarea name="descricao" class="form-control" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                  <label class="form-label">Data de entrega</label>
                  <input name="data_entrega" type="date" class="form-control" required>
                </div>

                <button class="btn btn-primary w-100">Salvar</button>
              </form>
            </div>
          </div>
        </div>

        <!-- Lista de tarefas -->
        <div class="col-12 col-lg-8">
          <div class="card">
            <div class="card-body">
              <h2 class="h6 mb-3">Tarefas criadas</h2>

              <?php if (empty($tarefas)): ?>
                <div class="alert alert-secondary mb-0">Nenhuma tarefa cadastrada.</div>
              <?php else: ?>
                <div class="table-responsive">
                  <table class="table table-striped align-middle mb-0">
                    <thead>
                      <tr>
                        <th>Título</th>
                        <th>Entrega</th>
                        <th>Descrição</th>
                        <th class="text-end">Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($tarefas as $tarefa): ?>
                        <tr>
                          <td><?= htmlspecialchars($tarefa['titulo']) ?></td>
                          <td><?= htmlspecialchars($tarefa['data_entrega']) ?></td>
                          <td class="small"><?= nl2br(htmlspecialchars($tarefa['descricao'])) ?></td>
                          <td class="text-end">
                            <button class="btn btn-sm btn-outline-secondary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditar<?= $tarefa['id'] ?>">
                              Editar
                            </button>

                            <form method="post" class="d-inline">
                              <input type="hidden" name="delete_id" value="<?= htmlspecialchars($tarefa['id']) ?>">
                              <button class="btn btn-sm btn-outline-danger">Excluir</button>
                            </form>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>

                <!-- Modais de edição -->
                <?php foreach ($tarefas as $tarefa): ?>
                  <div class="modal fade" id="modalEditar<?= $tarefa['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <form method="post">
                          <div class="modal-header">
                            <h5 class="modal-title">Editar tarefa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>

                          <div class="modal-body">
                            <input type="hidden" name="edit_tarefa_id" value="<?= $tarefa['id'] ?>">

                            <div class="mb-3">
                              <label class="form-label">Título</label>
                              <input type="text" name="titulo" class="form-control"
                                     value="<?= htmlspecialchars($tarefa['titulo']) ?>" required>
                            </div>

                            <div class="mb-3">
                              <label class="form-label">Descrição</label>
                              <textarea name="descricao" class="form-control" rows="4" required><?= htmlspecialchars($tarefa['descricao']) ?></textarea>
                            </div>

                            <div class="mb-3">
                              <label class="form-label">Data de entrega</label>
                              <input type="date" name="data_entrega" class="form-control"
                                     value="<?= htmlspecialchars($tarefa['data_entrega']) ?>" required>
                            </div>
                          </div>

                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar alterações</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>

              <?php endif; ?>
            </div>
          </div>
        </div>

      </div>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
