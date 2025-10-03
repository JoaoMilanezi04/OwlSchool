<?php
// pages/professor/tarefas_gerenciar.php
require_once __DIR__ . '/../../db/conexao.php';
require_once __DIR__ . '/../../api/professor/tarefa.php';

$msg = null;

// CREATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['__act']) && $_POST['__act'] === 'create') {
  $id  = createTarefa($_POST['titulo'] ?? '', $_POST['descricao'] ?? '', $_POST['data_entrega'] ?? '');
  $msg = $id ? "Tarefa criada (ID $id)." : "Erro ao criar tarefa.";
}

// DELETE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  $ok  = deleteTarefaById($_POST['delete_id']);
  $msg = $ok ? 'Tarefa excluída.' : 'Erro ao excluir tarefa.';
}

$tarefas = listTarefasProfessor();
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool — Gerenciar Tarefas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{background:#f8f9fa}
    .card{border-radius:14px}
  </style>
</head>
<body>
  <?php include __DIR__ . '/navbar.php'; ?>

  <main class="container py-4">
    <div class="row g-3">
      <div class="col-12">
        <h1 class="h4 mb-0">Gerenciar Tarefas</h1>
        <?php if ($msg): ?>
          <div class="alert mt-3 alert-<?php echo str_contains($msg,'Erro')?'danger':'success'; ?>"><?= $msg ?></div>
        <?php endif; ?>
      </div>

      <!-- Criar -->
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

      <!-- Listar/Excluir -->
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
                      <th>ID</th>
                      <th>Título</th>
                      <th>Entrega</th>
                      <th>Descrição</th>
                      <th class="text-end">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($tarefas as $t): ?>
                    <tr>
                      <td><?= (int)$t['id'] ?></td>
                      <td><?= htmlspecialchars($t['titulo']) ?></td>
                      <td><?= htmlspecialchars($t['data_entrega']) ?></td>
                      <td class="small"><?= nl2br(htmlspecialchars($t['descricao'])) ?></td>
                      <td class="text-end">
                        <form method="post" class="d-inline" onsubmit="return confirm('Excluir a tarefa #<?= (int)$t['id'] ?>?');">
                          <input type="hidden" name="delete_id" value="<?= (int)$t['id'] ?>">
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
