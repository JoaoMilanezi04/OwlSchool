<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';
require_once __DIR__ . '/../../api/utils/responsavel.php';

require_login();
require_role('responsavel');

$responsavelId = $_SESSION['user_id'];
$filhoNome     = getNomeFilho($responsavelId);
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
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Título</th>
            <th>Corpo</th>
          </tr>
        </thead>
        <tbody id="tbodyComunicados">
          <tr><td colspan="3" class="text-center text-muted">Carregando comunicados...</td></tr>
        </tbody>
      </table>

      <!-- ============================== -->
      <!-- Tarefas -->
      <!-- ============================== -->
      <h2 class="h5 mt-5 mb-3">🧾 Tarefas</h2>
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Título</th>
            <th>Entrega</th>
            <th>Descrição</th>
            <th class="text-end">Ações</th>
          </tr>
        </thead>
        <tbody id="tbodyTarefas">
          <tr><td colspan="4" class="text-center text-muted">Carregando tarefas...</td></tr>
        </tbody>
      </table>

      <!-- ============================== -->
      <!-- Advertências -->
      <!-- ============================== -->
      <h2 class="h5 mt-5 mb-3">⚠️ Advertências</h2>

      <?php if (!$filhoNome): ?>
        <div class="alert alert-warning">Nenhum filho vinculado à sua conta foi encontrado.</div>
      <?php else: ?>
        <p><strong>Aluno:</strong> <?= htmlspecialchars($filhoNome) ?></p>
        <table class="table table-striped align-middle">
          <thead>
            <tr>
              <th>Título</th>
              <th>Descrição</th>
            </tr>
          </thead>
          <tbody id="tbodyAdvertencias">
            <tr><td colspan="2" class="text-center text-muted">Carregando advertências...</td></tr>
          </tbody>
        </table>
      <?php endif; ?>

    </main>
  </div>

  <script>
    const idDoResponsavel = <?= (int) $responsavelId ?>;
  </script>

  <script src="/afonso/owl-school/public/assets/js/api/tarefa/read.js"></script>
  <script src="/afonso/owl-school/public/assets/js/api/comunicado/read.js"></script>
  <script src="/afonso/owl-school/public/assets/js/api/utils/advertencia_filho.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
