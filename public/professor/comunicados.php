<?php
// pages/professor/comunicados.php
require_once __DIR__ . '/../../db/conexao.php';
require_once __DIR__ . '/../../api/professor/comunicado.php';

$msg = null;

// Criar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['__act']) && $_POST['__act'] === 'create') {
  $id  = createComunicado($_POST['titulo'] ?? '', $_POST['corpo'] ?? '');
  $msg = $id ? "Comunicado criado (ID $id)." : "Erro ao criar comunicado.";
}

// Deletar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  $ok  = deleteComunicadoById($_POST['delete_id']);
  $msg = $ok ? 'Comunicado excluído.' : 'Erro ao excluir comunicado.';
}

$comunicados = listComunicadosProfessor();
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool — Gerenciar Comunicados</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <?php include __DIR__ . '/navbar.php'; ?>

  <main class="container py-4">
    <div class="row g-3">
      <div class="col-12">
        <h1 class="h4 mb-0">Gerenciar Comunicados</h1>
        <?php if ($msg): ?>
          <div class="alert mt-3 alert-<?php echo str_contains($msg,'Erro')?'danger':'success'; ?>"><?= $msg ?></div>
        <?php endif; ?>
      </div>

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

      <!-- Listar comunicados -->
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
                      <th>ID</th>
                      <th>Título</th>
                      <th>Corpo</th>
                      <th class="text-end">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($comunicados as $c): ?>
                    <tr>
                      <td><?= (int)$c['id'] ?></td>
                      <td><?= htmlspecialchars($c['titulo']) ?></td>
                      <td class="small"><?= nl2br(htmlspecialchars($c['corpo'])) ?></td>
                      <td class="text-end">
                        <form method="post" class="d-inline" onsubmit="return confirm('Excluir comunicado #<?= (int)$c['id'] ?>?');">
                          <input type="hidden" name="delete_id" value="<?= (int)$c['id'] ?>">
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
</body>
</html>
