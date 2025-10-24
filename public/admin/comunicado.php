<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';

require_login();
require_role('admin');
?>

<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>OlwSchool — Gerenciar Comunicados</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS próprio -->
  <link rel="stylesheet" href="/owl-school/public/assets/css/admin/comunicado.css"> 
  
</head>

<body class="bg-light">

  <!-- Navbar -->
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">

      <!-- ============================== -->
      <!-- Criar novo comunicado -->
      <!-- ============================== -->
      <h1 class="h5 mb-3">📢 Criar novo comunicado</h1>

      <div class="card mb-5">
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Título</label>
            <input id="titulo" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Corpo</label>
            <textarea id="corpo" class="form-control" rows="6" required></textarea>
          </div>

          <button id="btnCriar" type="button" class="btn btn-primary w-100">Publicar</button>
        </div>
      </div>

      <!-- ============================== -->
      <!-- Comunicados criados -->
      <!-- ============================== -->
      <h2 class="h5 mb-3">📋 Comunicados criados</h2>

      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Título</th>
            <th>Corpo</th>
            <th class="text-end">Ações</th>
          </tr>
        </thead>
        <tbody id="tbodyComunicados"></tbody>
      </table>

    </main>
  </div>

  <!-- ============================== -->
  <!-- Modal de Edição -->
  <!-- ============================== -->
  <div class="modal fade" id="editModalComunicado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Editar comunicado</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>

        <div class="modal-body">
          <input id="edit_titulo" class="form-control mb-3" placeholder="Título">
          <textarea id="edit_corpo" class="form-control mb-3" rows="5" placeholder="Corpo"></textarea>
        </div>

        <div class="modal-footer">
          <button id="btnSalvarComunicado" type="button" class="btn btn-primary">Salvar</button>
        </div>

      </div>
    </div>
  </div>

  <!-- ============================== -->
  <!-- Scripts -->
  <!-- ============================== -->
  <script src="/owl-school/public/assets/js/api/comunicado/read.js"></script>
  <script src="/owl-school/public/assets/js/api/comunicado/create.js"></script>
  <script src="/owl-school/public/assets/js/api/comunicado/update.js"></script>
  <script src="/owl-school/public/assets/js/api/comunicado/delete.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
