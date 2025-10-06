<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';
require_once __DIR__ . '/../../api/responsavel/comunicado.php';
require_once __DIR__ . '/../../api/responsavel/responsavel.php';
require_once __DIR__ . '/../../api/professor/tarefa.php'; // ajusta se o caminho for outro

require_login();
require_role('responsavel');

$comunicados = listComunicadosResponsavel();

$responsavelId = $_SESSION['user_id'];

$filhoNome    = getNomeFilho($responsavelId);
$advertencias = listAdvertenciasDoFilhoDoResponsavel($responsavelId);
$tarefas      = listTarefas(); // já existente na tua API
?>

<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool — Comunicados, Tarefas e Advertências</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">

      <!-- ============================== -->
      <!-- Comunicados -->
      <!-- ============================== -->
      <h1 class="h5 mb-3">📢 Comunicados</h1>

      <?php if (empty($comunicados)): ?>
        <div class="alert alert-secondary">Nenhum comunicado disponível.</div>
      <?php else: ?>
        <div class="list-group shadow-sm mb-5">
          <?php foreach ($comunicados as $comunicado): ?>
            <div class="list-group-item">
              <h5 class="mb-1"><?= htmlspecialchars($comunicado['titulo']) ?></h5>
              <p class="mb-1 small"><?= nl2br(htmlspecialchars($comunicado['corpo'])) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <!-- ============================== -->
      <!-- Tarefas -->
      <!-- ============================== -->
      <h2 class="h5 mb-3">🧾 Tarefas</h2>

      <?php if (empty($tarefas)): ?>
        <div class="alert alert-secondary">Nenhuma tarefa cadastrada.</div>
      <?php else: ?>
        <div class="row g-3 mb-5">
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

      <!-- ============================== -->
      <!-- Advertências -->
      <!-- ============================== -->
      <h2 class="h5 mb-3">⚠️ Advertências</h2>

      <?php if (!$filhoNome): ?>
        <div class="alert alert-warning">Nenhum filho vinculado à sua conta foi encontrado.</div>
      <?php elseif (empty($advertencias)): ?>
        <div class="alert alert-secondary">Nenhuma advertência registrada para <?= htmlspecialchars($filhoNome) ?>.</div>
      <?php else: ?>
        <div class="card shadow-sm">
          <div class="card-body">
            <p class="mb-3">
              <strong>Aluno:</strong> <?= htmlspecialchars($filhoNome) ?>
            </p>
            <div class="table-responsive">
              <table class="table table-striped align-middle mb-0">
                <thead>
                  <tr>
                    <th style="width: 250px;">Título</th>
                    <th>Descrição</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($advertencias as $adv): ?>
                    <tr>
                      <td><?= htmlspecialchars($adv['titulo']) ?></td>
                      <td><?= nl2br(htmlspecialchars($adv['descricao'])) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      <?php endif; ?>

    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
