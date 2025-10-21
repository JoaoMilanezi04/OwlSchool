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

  <title>OlwSchool — Gerenciar Chamadas e Presenças</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS próprio -->
  <link rel="stylesheet" href="/afonso/owl-school/public/assets/css/professor/chamada.css">
</head>

<body class="bg-light">

  <!-- Navbar -->
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">

      <!-- ============================== -->
      <!-- Criar nova chamada -->
      <!-- ============================== -->
      <h1 class="h5 mb-3">📅 Criar nova chamada</h1>

      <div class="card mb-5">
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Data</label>
            <input type="date" id="data" class="form-control" required>
          </div>
          <button id="btnCriarChamada" class="btn btn-primary w-100">Salvar</button>
        </div>
      </div>

      <!-- ============================== -->
      <!-- Lista de chamadas -->
      <!-- ============================== -->
      <h2 class="h5 mb-3">🗂️ Chamadas</h2>

      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Data</th>
            <th class="text-end">Ações</th>
          </tr>
        </thead>
        <tbody id="tbodyChamadas"></tbody>
      </table>

      <!-- ============================== -->
      <!-- Presenças da chamada -->
      <!-- ============================== -->
      <div id="cardChamada" class="card d-none mt-5">
        <div class="card-body">

          <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h6 mb-0">
              Presenças — <span id="tituloChamada"></span>
              <small class="text-muted ms-2">(Chamada ID: <span id="chamadaIdPresencas"></span>)</small>
            </h2>
          </div>

          <table class="table table-striped align-middle">
            <thead>
              <tr>
                <th>Aluno</th>
                <th style="width:160px">Status</th>
                <th class="text-end">Ações</th>
              </tr>
            </thead>
            <tbody id="tbodyChamada"></tbody>
          </table>

        </div>
      </div>

    </main>
  </div>

  <!-- ============================== -->
  <!-- Modal Editar Chamada -->
  <!-- ============================== -->
  <div class="modal fade" id="editModalChamada" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Editar chamada</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Data</label>
            <input type="date" id="edit_data_chamada" class="form-control" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" id="btnSalvarChamada" class="btn btn-primary">Salvar alterações</button>
        </div>

      </div>
    </div>
  </div>

  <!-- ============================== -->
  <!-- Modal Criar Presença -->
  <!-- ============================== -->
  <div class="modal fade" id="createChamadaItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Lançar presença</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select id="create_status" class="form-select">
              <option value="presente">Presente</option>
              <option value="falta">Falta</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="btnSalvarChamadaItem">Salvar</button>
        </div>

      </div>
    </div>
  </div>

  <!-- ============================== -->
  <!-- Modal Editar Presença -->
  <!-- ============================== -->
  <div class="modal fade" id="editChamadaItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Editar presença</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select id="edit_status" class="form-select">
              <option value="presente">Presente</option>
              <option value="falta">Falta</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="btnSalvarEdicaoChamadaItem">Salvar</button>
        </div>

      </div>
    </div>
  </div>

  <!-- ============================== -->
  <!-- Scripts -->
  <!-- ============================== -->
  <script src="/afonso/owl-school/public/assets/js/api/chamada/read.js"></script>
  <script src="/afonso/owl-school/public/assets/js/api/chamada/create.js"></script>
  <script src="/afonso/owl-school/public/assets/js/api/chamada/update.js"></script>
  <script src="/afonso/owl-school/public/assets/js/api/chamada/delete.js"></script>

  <script src="/afonso/owl-school/public/assets/js/api/chamada_item/read.js"></script>
  <script src="/afonso/owl-school/public/assets/js/api/chamada_item/create.js"></script>
  <script src="/afonso/owl-school/public/assets/js/api/chamada_item/update.js"></script>
  <script src="/afonso/owl-school/public/assets/js/api/chamada_item/delete.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
