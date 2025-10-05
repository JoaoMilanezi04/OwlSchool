<?php


require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';
require_once __DIR__ . '/../../api/aluno/tarefa.php';



require_login();
require_role('responsavel');



$tarefas = listTarefas();


?>


<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool — Tarefas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<body class="bg-light">

  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">
      <h1 class="h5 mb-3">Tarefas</h1>

      <?php if (empty($tarefas)): ?>
        <div class="alert alert-secondary">Nenhuma tarefa cadastrada.</div>

      <?php else: ?>

        <div class="row g-3">
          <?php foreach ($tarefas as $tarefa): ?>

            <div class="col-12 col-md-6">
              <div class="card h-100 shadow-sm">

                <div class="card-body">
                  <h5 class="card-title mb-2"><?= htmlspecialchars($tarefa['titulo']) ?></h5>
                  <p class="card-text small"><?= nl2br(htmlspecialchars($tarefa['descricao'])) ?></p>
                </div>

                <div class="card-footer">
                  <span class="text-muted small">Entrega: <?= htmlspecialchars($tarefa['data_entrega']) ?></span>
                </div>
                
              </div>
            </div>

          <?php endforeach; ?>
        </div>

      <?php endif; ?>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
