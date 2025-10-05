<?php




require_once __DIR__ . '/../../db/conexao.php';
require_once __DIR__ . '/../../api/professor/comunicado.php';
require_once __DIR__ . '/../../includes/auth.php';





require_login();
require_role('admin');




if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['__act']) && $_POST['__act'] === 'create') {
  createComunicado($_POST['titulo'] ?? '', $_POST['corpo'] ?? '');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  deleteComunicadoById($_POST['delete_id']);
}



$comunicados = listComunicadosProfessor();




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

      <h1 class="h5 mb-4">OlwSchool — Comunicados</h1>

      <div class="row g-4">



        <div class="col-12 col-lg-4">
          <div class="card h-100">
            <div class="card-body">
              <h2 class="h6 mb-3">Criar novo comunicado</h2>

              <form method="post" autocomplete="off">
                <input type="hidden" name="__act" value="create">

                <div class="mb-3">
                  <label class="form-label">Título</label>
                  <input name="titulo" class="form-control">
                </div>

                <div class="mb-3">
                  <label class="form-label">Corpo</label>
                  <textarea name="corpo" class="form-control" rows="5"></textarea>
                </div>

                <button class="btn btn-primary w-100">Salvar</button>
              </form>
            </div>
          </div>
        </div>



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
                            <form method="post" class="d-inline">
                              <input type="hidden" name="delete_id" value="<?= (int)$comunicado['id'] ?>">
                              <button class="btn btn-sm btn-outline-danger">Excluir</button>
                            </form>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
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
