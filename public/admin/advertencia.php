<?php
require_once __DIR__ . '/../../includes/auth.php';

require_login();
require_role('admin');
?>

<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>OlwSchool — Gerenciar Advertências</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS próprio -->
  <link rel="stylesheet" href="/afonso/owl-school/public/assets/css/admin/advertencia.css"> 

</head>

<body class="bg-light">

  <!-- Navbar -->
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">

      <!-- ============================== -->
      <!-- Criar nova advertência -->
      <!-- ============================== -->
      <h1 class="h5 mb-3">⚠️ Criar nova advertência</h1>

      <div class="card mb-5">
        <div class="card-body">

          <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" id="titulo" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea id="descricao" class="form-control" rows="4" required></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Aluno</label>
            <select id="aluno_id" class="form-select" required></select>
          </div>

          <button id="btnCriarAdvertencia" class="btn btn-primary w-100">Salvar</button>

        </div>
      </div>

      <!-- ============================== -->
      <!-- Lista de advertências -->
      <!-- ============================== -->
      <h2 class="h5 mb-3">📋 Advertências</h2>

      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th style="width:60%">Título / Descrição</th>
            <th>Aluno</th>
            <th class="text-end">Ações</th>
          </tr>
        </thead>
        <tbody id="tbodyAdvertencias"></tbody>
      </table>

    </main>
  </div>

  <!-- ============================== -->
  <!-- Modal Editar Advertência -->
  <!-- ============================== -->
  <div class="modal fade" id="editModalAdvertencia" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Editar advertência</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="edit_id">

          <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" id="edit_titulo" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea id="edit_descricao" class="form-control" rows="4" required></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" id="btnSalvarAdvertencia" class="btn btn-primary">Salvar alterações</button>
        </div>

      </div>
    </div>
  </div>

  <!-- ============================== -->
  <!-- Scripts -->
  <!-- ============================== -->
  <script src="/afonso/owl-school/public/assets/js/api/advertencia/read.js"></script>
  <script src="/afonso/owl-school/public/assets/js/api/advertencia/create.js"></script>
  <script src="/afonso/owl-school/public/assets/js/api/advertencia/update.js"></script>
  <script src="/afonso/owl-school/public/assets/js/api/advertencia/delete.js"></script>

  <!-- Helper: popula o <select id="aluno_id"> -->
  <script src="/afonso/owl-school/public/assets/js/api/utils/aluno_select.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
