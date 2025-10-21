<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';

require_login();
require_role('aluno');
?>

<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>OlwSchool — Comunicados, Tarefas e Advertências</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS próprio -->
  <link rel="stylesheet" href="/afonso/owl-school/public/assets/css/aluno/home.css">
</head>

<body class="bg-light">

  <!-- Navbar -->
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">

      <!-- ============================== -->
      <!-- Comunicados -->
      <!-- ============================== -->
      <h1 class="h5 mb-3">📢 Comunicados</h1>

      <table class="table table-striped align-middle mb-5">
        <thead>
          <tr>
            <th>Título</th>
            <th>Corpo</th>
          </tr>
        </thead>
        <tbody id="tbodyComunicados"></tbody>
      </table>

      <!-- ============================== -->
      <!-- Tarefas -->
      <!-- ============================== -->
      <h2 class="h5 mt-5 mb-3">🧾 Tarefas</h2>

      <table class="table table-striped align-middle mb-5">
        <thead>
          <tr>
            <th>Título</th>
            <th>Entrega</th>
            <th>Descrição</th>
          </tr>
        </thead>
        <tbody id="tbodyTarefas"></tbody>
      </table>

      <!-- ============================== -->
      <!-- Advertências -->
      <!-- ============================== -->
      <h2 class="h5 mt-5 mb-3">⚠️ Advertências</h2>

      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Título</th>
            <th>Descrição</th>
          </tr>
        </thead>
        <tbody id="tbodyAdvertencias"></tbody>
      </table>

    </main>
  </div>

  <!-- ============================== -->
  <!-- Scripts -->
  <!-- ============================== -->
  <script src="/afonso/owl-school/public/assets/js/api/tarefa/read.js"></script>
  <script src="/afonso/owl-school/public/assets/js/api/comunicado/read.js"></script>
  <script src="/afonso/owl-school/public/assets/js/api/utils/aluno/advertencia_aluno.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
