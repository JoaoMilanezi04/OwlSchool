<?php


require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';
require_once __DIR__ . '/../../api/professor/tarefa.php';



require_login();
require_role('professor');



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['__act']) && $_POST['__act'] === 'create') {
  createTarefa($_POST['titulo'], $_POST['descricao'], $_POST['data_entrega']);
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  deleteTarefaById($_POST['delete_id']);
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
</head>


<body class="bg-light">

  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">


      <div class="row g-4">


        <div class="col-12 col-lg-4">
          <div class="card h-100">
            <div class="card-body">
              <h2 class="h6 mb-3">Criar nova tarefa</h2>

              <form method="post">
                <input type="hidden" name="__act" value="create">

                <div class="mb-3">
                  <label class="form-label">Título</label>
                  <input name="titulo" class="form-control">
                </div>

                <div class="mb-3">
                  <label class="form-label">Descrição</label>
                  <textarea name="descricao" class="form-control" rows="4"></textarea>
                </div>

                <div class="mb-3">
                  <label class="form-label">Data de entrega</label>
                  <input name="data_entrega" type="date" class="form-control">
                </div>

                <button class="btn btn-primary w-100">Salvar</button>
              </form>

            </div>
          </div>
        </div>


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
