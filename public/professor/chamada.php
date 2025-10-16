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
  <title>OlwSchool — Gerenciar Chamadas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light">
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">
      <div class="row g-4">

        <!-- Coluna Criar -->
        <div class="col-12 col-lg-4">
          <div class="card h-100">
            <div class="card-body">
              <h2 class="h6 mb-3">Criar nova chamada</h2>

              <div class="mb-3">
                <label class="form-label">Data</label>
                <input id="data" type="date" class="form-control" required>
              </div>

              <button id="btnCriar" type="button" class="btn btn-primary w-100">Criar chamada</button>
            </div>
          </div>
        </div>

        <!-- Coluna Lista -->
        <div class="col-12 col-lg-8">
          <div class="card">
            <div class="card-body">
              <h2 class="h6 mb-3">Chamadas criadas</h2>
              <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                  <thead>
                    <tr>
                      <th>Data</th>
                      <th class="text-end">Ações</th>
                    </tr>
                  </thead>
                  <tbody id="tbodyChamadas">
                    <!-- Linhas geradas via JS -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>
    </main>
  </div>

  <!-- Modal de Edição -->
  <div class="modal fade" id="editModalChamada" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar chamada</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <input id="edit_data_chamada" type="date" class="form-control mb-3" placeholder="Data">
        </div>
        <div class="modal-footer">
          <button id="btnSalvarChamada" type="button" class="btn btn-primary">Salvar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="/afonso/owl-school/public/assets/js/api/chamada/read.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/chamada/create.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/chamada/delete.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/chamada/update.js" defer></script>

</body>
</html>
