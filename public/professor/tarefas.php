<?php

require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';

require_login();
require_role('professor');

?>

<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>OlwSchool — Gerenciar Tarefas</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS próprio -->
  <link rel="stylesheet" href="/owl-school/public/assets/css/professor/tarefa.css">
</head>

<body class="bg-light">

  <!-- Navbar -->
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">

      <!-- ============================== -->
      <!-- Criar nova tarefa -->
      <!-- ============================== -->
      <h1 class="h5 mb-3">🧾 Criar nova tarefa</h1>

      <div class="card mb-5">
        <div class="card-body">

          <div class="mb-3">
            <label class="form-label">Título</label>
            <input id="titulo" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea id="descricao" class="form-control" rows="4" required></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Data de entrega</label>
            <input id="data_entrega" type="date" class="form-control" required>
          </div>

          <button id="btnCriar" type="button" class="btn btn-primary w-100">Salvar</button>

        </div>
      </div>

      <!-- ============================== -->
      <!-- Tarefas criadas -->
      <!-- ============================== -->
      <h2 class="h5 mb-3">📋 Tarefas criadas</h2>

      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Título</th>
            <th>Entrega</th>
            <th>Descrição</th>
            <th class="text-end">Ações</th>
          </tr>
        </thead>
        <tbody id="tbodyTarefas"></tbody>
      </table>

    </main>
  </div>

  <!-- ============================== -->
  <!-- Modal Editar Tarefa -->
  <!-- ============================== -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h5 id="editTituloTopo" class="modal-title">Editar tarefa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>

        <div class="modal-body">
          <input id="edit_titulo" class="form-control mb-3" placeholder="Título">
          <textarea id="edit_descricao" class="form-control mb-3" rows="3" placeholder="Descrição"></textarea>
          <input id="edit_data" type="date" class="form-control" placeholder="Entrega">
        </div>

        <div class="modal-footer">
          <button id="btnSalvar" type="button" class="btn btn-primary">Salvar</button>
        </div>

      </div>
    </div>
  </div>

  <!-- ============================== -->
  <!-- Scripts -->
  <!-- ============================== -->
  <script src="/owl-school/public/assets/js/api/tarefa/read.js"></script>
  <script src="/owl-school/public/assets/js/api/tarefa/create.js"></script>
  <script src="/owl-school/public/assets/js/api/tarefa/delete.js"></script>
  <script src="/owl-school/public/assets/js/api/tarefa/update.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
