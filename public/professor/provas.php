<?php
require_once __DIR__ . '/../../includes/auth.php';
require_login();
require_role('professor');
?>

<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>OlwSchool — Provas e Notas</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS próprio -->
  <link rel="stylesheet" href="/afonso/owl-school/public/assets/css/professor/prova.css">
</head>

<body class="bg-light">

  <!-- Navbar -->
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">

      <!-- ============================== -->
      <!-- Criar nova prova -->
      <!-- ============================== -->
      <h1 class="h5 mb-3">📝 Criar nova prova</h1>

      <div class="card mb-5">
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Título</label>
            <input id="titulo" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Data</label>
            <input type="date" id="data" class="form-control" required>
          </div>

          <button id="btnCriar" class="btn btn-primary w-100">Salvar</button>
        </div>
      </div>

      <!-- ============================== -->
      <!-- Lista de provas -->
      <!-- ============================== -->
      <h2 class="h5 mb-3">📚 Provas criadas</h2>

      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Título</th>
            <th>Data</th>
            <th class="text-end">Ações</th>
          </tr>
        </thead>
        <tbody id="tbodyProvas"></tbody>
      </table>

      <!-- ============================== -->
      <!-- Notas da prova -->
      <!-- ============================== -->
      <div id="cardNotas" class="card d-none mt-5">
        <div class="card-body">

          <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h6 mb-0">
              Notas — <span id="tituloProvaNotas"></span>
              <small class="text-muted ms-2">(Prova ID: <span id="provaIdNotas"></span>)</small>
            </h2>
          </div>

          <input type="hidden" id="prova_id">

          <table class="table table-striped align-middle">
            <thead>
              <tr>
                <th>Aluno</th>
                <th style="width:140px">Nota</th>
                <th class="text-end">Ações</th>
              </tr>
            </thead>
            <tbody id="tbodyNotas"></tbody>
          </table>

        </div>
      </div>

    </main>
  </div>

  <!-- ============================== -->
  <!-- Modal Editar Prova -->
  <!-- ============================== -->
  <div class="modal fade" id="editModalProva" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Editar prova</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" id="edit_titulo_prova" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Data</label>
            <input type="date" id="edit_data_prova" class="form-control" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" id="btnSalvarProva" class="btn btn-primary">Salvar alterações</button>
        </div>

      </div>
    </div>
  </div>

  <!-- ============================== -->
  <!-- Modal Criar Nota -->
  <!-- ============================== -->
  <div class="modal fade" id="createNotaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Lançar nota</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nota</label>
            <input type="number" step="0.01" min="0" max="100" id="create_nota" class="form-control">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="btnSalvarNota">Salvar</button>
        </div>

      </div>
    </div>
  </div>

  <!-- ============================== -->
  <!-- Modal Editar Nota -->
  <!-- ============================== -->
  <div class="modal fade" id="editNotaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Editar nota</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nota</label>
            <input type="number" step="0.01" min="0" max="100" id="edit_nota" class="form-control">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="btnSalvarEdicaoNota">Salvar</button>
        </div>

      </div>
    </div>
  </div>

  <!-- ============================== -->
  <!-- Scripts -->
  <!-- ============================== -->
  <script src="/afonso/owl-school/public/assets/js/api/prova/read.js"></script>
  <script src="/afonso/owl-school/public/assets/js/api/prova/create.js"></script>
  <script src="/afonso/owl-school/public/assets/js/api/prova/update.js"></script>
  <script src="/afonso/owl-school/public/assets/js/api/prova/delete.js"></script>

  <script src="/afonso/owl-school/public/assets/js/api/prova_nota/read.js"></script>
  <script src="/afonso/owl-school/public/assets/js/api/prova_nota/create.js"></script>
  <script src="/afonso/owl-school/public/assets/js/api/prova_nota/update.js"></script>
  <script src="/afonso/owl-school/public/assets/js/api/prova_nota/delete.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
