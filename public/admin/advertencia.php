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
  <title>OlwSchool — Advertências (Admin)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">
      <div class="row g-4">

        <!-- Criar nova advertência -->
        <div class="col-12 col-lg-4">
          <div class="card h-100">
            <div class="card-body">
              <h2 class="h6 mb-3">Criar nova advertência</h2>

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

                <!-- Dica: depois você pode trocar por um <select> populado via API de alunos -->
              </div>

              <button id="btnCriarAdvertencia" class="btn btn-primary w-100">Salvar</button>
            </div>
          </div>
        </div>

        <!-- Lista de advertências -->
        <div class="col-12 col-lg-8">
          <div class="card">
            <div class="card-body">
              <h2 class="h6 mb-3">Advertências</h2>

              <div class="table-responsive mb-3">
                <table class="table table-striped align-middle mb-0">
                  <thead>
                    <tr>
                      <th style="width: 60%">Título / Descrição</th>
                      <th>Aluno</th>
                      <th class="text-end">Ações</th>
                    </tr>
                  </thead>
                  <tbody id="tbodyAdvertencias"></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div> <!-- /row -->
    </main>
  </div>

  <!-- Modal Editar Advertência -->
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
          <!-- Obs.: o vínculo do aluno foi pensado no create; se quiser editar o aluno, crie outro modal/endpoint -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" id="btnSalvarAdvertencia" class="btn btn-primary">Salvar alterações</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Advertência -->
  <script src="/afonso/owl-school/public/assets/js/api/advertencia/read.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/advertencia/create.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/advertencia/update.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/advertencia/delete.js" defer></script>

  <!-- Helper: exemplo de render no tbody (implemente em read.js)
       - montar linhas com: título, descrição (em <small>), aluno_nome e botões editar/excluir -->
  <script src="/afonso/owl-school/public/assets/js/api/utils/aluno_select.js" defer></script>

</body>
</html>
