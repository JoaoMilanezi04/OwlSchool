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
  <title>OlwSchool — Chamada e Presenças</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">
      <div class="row g-4">

        <!-- Criar nova chamada -->
        <div class="col-12 col-lg-4">
          <div class="card h-100">
            <div class="card-body">
              <h2 class="h6 mb-3">Criar nova chamada</h2>
              <div class="mb-3">
                <label class="form-label">Data</label>
                <input type="date" id="data" class="form-control" required>
              </div>
              <button id="btnCriarChamada" class="btn btn-primary w-100">Salvar</button>
            </div>
          </div>
        </div>

        <!-- Lista de chamadas -->
        <div class="col-12 col-lg-8">
          <div class="card">
            <div class="card-body">
              <h2 class="h6 mb-3">Chamadas</h2>

              <div class="table-responsive mb-3">
                <table class="table table-striped align-middle mb-0">
                  <thead>
                    <tr>

                      <th>Data</th>
                      <th class="text-end">Ações</th>
                    </tr>
                  </thead>
                  <tbody id="tbodyChamadas"></tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Área de presenças da chamada -->
          <div id="cardChamada" class="card d-none mt-3">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h6 mb-0">
                  Presenças — <span id="tituloChamada"></span>
                  <small class="text-muted ms-2">(Chamada ID: <span id="chamadaIdPresencas"></span>)</small>
                </h2>
              </div>

 
              

              <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
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
          </div>
          <!-- /Área de presenças -->
        </div>

      </div> <!-- /row -->
    </main>
  </div>

  <!-- Modal Editar Chamada -->
  <div class="modal fade" id="editModalChamada" tabindex="-1">
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

  <!-- Modal Criar Presença -->
  <div class="modal fade" id="createChamadaItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Lançar presença</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="create_status" class="form-label">Status</label>
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

  <!-- Modal Editar Presença -->
  <div class="modal fade" id="editChamadaItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar presença</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="edit_status" class="form-label">Status</label>
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

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Chamadas -->
  <script src="/afonso/owl-school/public/assets/js/api/chamada/read.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/chamada/create.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/chamada/update.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/chamada/delete.js" defer></script>

  <!-- Presenças (chamada_item) -->
  <script src="/afonso/owl-school/public/assets/js/api/chamada_item/read.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/chamada_item/create.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/chamada_item/update.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/chamada_item/delete.js" defer></script>

  <!-- Helper para mostrar a área de presenças e carregar a lista -->
  <!-- Ex.: chamar listarItensDaChamada(chamadaId) ao clicar em "ver presenças" na tabela de chamadas -->
</body>
</html>
