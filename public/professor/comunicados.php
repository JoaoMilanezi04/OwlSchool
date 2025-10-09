<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';


require_once __DIR__ . '/../../api/comunicado/create.php';
require_once __DIR__ . '/../../api/comunicado/read.php';
require_once __DIR__ . '/../../api/comunicado/update.php';
require_once __DIR__ . '/../../api/comunicado/delete.php';




require_login();
require_role('professor');

// Criar novo comunicado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['__act']) && $_POST['__act'] === 'create') {
  $titulo = $_POST['titulo'] ?? '';
  $corpo  = $_POST['corpo']  ?? '';
  createComunicado($titulo, $corpo);
}

// Excluir comunicado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  deleteComunicado((int) $_POST['delete_id']);
}

// Editar comunicado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_comunicado_id'])) {
  $id     = $_POST['edit_comunicado_id'];
  $titulo = $_POST['titulo'];
  $corpo  = $_POST['corpo'];
  updateComunicado($id, $titulo, $corpo);
}


$comunicados = readComunicado();


?>

<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool — Comunicados</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">

      <div class="row g-4">

        <!-- Criar comunicado -->
        <div class="col-12 col-lg-4">
          <div class="card h-100">
            <div class="card-body">
              <h2 class="h6 mb-3">Criar novo comunicado</h2>

              <form method="post">
                <input type="hidden" name="__act" value="create">

                <div class="mb-3">
                  <label class="form-label">Título</label>
                  <input name="titulo" class="form-control" required>
                </div>

                <div class="mb-3">
                  <label class="form-label">Corpo</label>
                  <textarea name="corpo" class="form-control" rows="5" required></textarea>
                </div>

                <button class="btn btn-primary w-100">Salvar</button>
              </form>

            </div>
          </div>
        </div>

        <!-- Lista de comunicados -->
        <div class="col-12 col-lg-8">
          <div class="card">
            <div class="card-body">
              <h2 class="h6 mb-3">Comunicados criados</h2>

              <?php if (empty($comunicados)): ?>
                <div class="alert alert-secondary mb-0">Nenhum comunicado cadastrado.</div>
              <?php else: ?>

                <div class="table-responsive">
                  <table class="table table-striped align-middle mb-0">
                    <thead>
                      <tr>
                        <th>Título</th>
                        <th>Corpo</th>
                        <th class="text-end">Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($comunicados as $comunicado): ?>
                        <tr>
                          <td><?= htmlspecialchars($comunicado['titulo']) ?></td>
                          <td class="small"><?= nl2br(htmlspecialchars($comunicado['corpo'])) ?></td>
                          <td class="text-end">
                            <button class="btn btn-sm btn-outline-secondary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditar<?= $comunicado['id'] ?>">
                              Editar
                            </button>

                            <form method="post" class="d-inline">
                              <input type="hidden" name="delete_id" value="<?= htmlspecialchars($comunicado['id']) ?>">
                              <button class="btn btn-sm btn-outline-danger">Excluir</button>
                            </form>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>

                <!-- Modais de edição -->
                <?php foreach ($comunicados as $comunicado): ?>
                  <div class="modal fade" id="modalEditar<?= $comunicado['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <form method="post">
                          <div class="modal-header">
                            <h5 class="modal-title">Editar comunicado</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>

                          <div class="modal-body">
                            <input type="hidden" name="edit_comunicado_id" value="<?= $comunicado['id'] ?>">

                            <div class="mb-3">
                              <label class="form-label">Título</label>
                              <input type="text" name="titulo" class="form-control"
                                     value="<?= htmlspecialchars($comunicado['titulo']) ?>" required>
                            </div>

                            <div class="mb-3">
                              <label class="form-label">Corpo</label>
                              <textarea name="corpo" class="form-control" rows="4" required><?= htmlspecialchars($comunicado['corpo']) ?></textarea>
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
