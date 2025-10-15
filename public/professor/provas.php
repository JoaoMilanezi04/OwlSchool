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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">
      <div class="row g-4">

        <!-- Criar nova prova -->
        <div class="col-12 col-lg-4">
          <div class="card h-100">
            <div class="card-body">
              <h2 class="h6 mb-3">Criar nova prova</h2>
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
        </div>

        <!-- Lista de provas -->
        <div class="col-12 col-lg-8">
          <div class="card">
            <div class="card-body">
              <h2 class="h6 mb-3">Provas</h2>

              <div class="table-responsive mb-3">
                <table class="table table-striped align-middle mb-0">
                  <thead>
                    <tr>
                      <th>Título</th>
                      <th>Data</th>
                      <th class="text-end">Ações</th>
                    </tr>
                  </thead>
                  <tbody id="tbodyProvas"></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div> <!-- /row -->
    </main>
  </div>

  <!-- Modal Editar Prova -->
  <div class="modal fade" id="editModalProva" tabindex="-1">
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

  <!-- Modal Lançar Notas -->
  <div class="modal fade" id="modalLancamentoNotas" tabindex="-1" style="display:none;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            Lançar notas — <span id="tituloProvaNotas"></span>
            <small class="text-muted ms-2">(Prova ID: <span id="provaIdNotas"></span>)</small>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <!-- input oculto usado pelos scripts -->
          <input type="hidden" id="prova_id">

          <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
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
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Provas -->
  <script src="/afonso/owl-school/public/assets/js/api/prova/read.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/prova/create.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/prova/update.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/prova/delete.js" defer></script>

  <!-- Notas -->
  <script src="/afonso/owl-school/public/assets/js/api/prova_nota/read.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/prova_nota/create.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/prova_nota/update.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/prova_nota/delete.js" defer></script>

  <!-- Abrir modal -->
  <script>
async function abrirLancamentoNotas(idProva, tituloProva) {
  document.getElementById("prova_id").value = idProva;

  const elementoModal = document.getElementById("modalLancamentoNotas");
  const modal = new bootstrap.Modal(elementoModal);
  modal.show();

  if (typeof carregarNotasDaProva === "function") {
    await carregarNotasDaProva(idProva);
  }
}
  </script>
</body>
</html>
