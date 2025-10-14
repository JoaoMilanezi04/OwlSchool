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
  <title>OlwSchool — Usuários</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left:220px;">
    <main class="container py-4" style="max-width:1100px">
      <!-- Card: Formulário de criação -->
      <div class="card shadow-sm mb-4">
        <div class="card-body">
          <form class="row g-3" autocomplete="off" onsubmit="return false;">
            <div class="col-md-4">
              <label class="form-label">Nome</label>
              <input id="nome" class="form-control" placeholder="Nome completo">
            </div>
            <div class="col-md-4">
              <label class="form-label">Email</label>
              <input id="email" type="email" class="form-control" placeholder="email@exemplo.com">
            </div>
            <div class="col-md-4">
              <label class="form-label">Senha</label>
              <input id="senha" class="form-control" placeholder="••••••">
            </div>

            <div class="col-md-4">
              <label class="form-label">Tipo</label>
              <select id="tipo_usuario" class="form-select">
                <option value="aluno" selected>aluno</option>
                <option value="professor">professor</option>
                <option value="responsavel">responsavel</option>
                <option value="admin">admin</option>
              </select>
            </div>

            <!-- Telefone só aparece para professor/responsável -->
            <div class="col-md-4" id="grupo_tel_create" style="display:none;">
              <label class="form-label">Telefone (prof/resp)</label>
              <input id="telefone" class="form-control" placeholder="(41) 99999-0000">
            </div>

            <div class="col-12">
              <button id="btnCriar" class="btn btn-primary">Salvar</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Card: Lista -->
      <div class="card shadow-sm">
        <div class="card-body">
          <h2 class="h5 mb-3">Lista de usuários</h2>
          <div class="table-responsive">
            <table class="table align-middle">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nome</th>
                  <th>Email</th>
                  <th>Tipo</th>
                  <th>Telefone</th>
                  <th class="text-end">Ações</th>
                </tr>
              </thead>
              <tbody id="tbodyUsuarios"></tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>

 
  <div class="modal fade" id="editModalAluno" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog"><div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-6">Editar usuário (Aluno/Admin)</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nome</label>
            <input id="edit_aluno_nome" class="form-control">
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input id="edit_aluno_email" type="email" class="form-control">
          </div>
          <div class="col-md-6">
            <label class="form-label">Senha (vazio = manter)</label>
            <input id="edit_aluno_senha" class="form-control" placeholder="••••••">
          </div>
          <div class="col-md-6">
            <label class="form-label">Tipo</label>
            <input id="edit_aluno_tipo" class="form-control" disabled>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <!-- O update real fica no teu update.js -->
        <button id="btnSalvarAluno" class="btn btn-primary">Salvar</button>
        <button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div></div>
  </div>

  <!-- Modal: Editar (Professor/Responsável) -->
  <div class="modal fade" id="editModalProfResp" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog"><div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-6">Editar usuário (Professor/Responsável)</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nome</label>
            <input id="edit_pr_nome" class="form-control">
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input id="edit_pr_email" type="email" class="form-control">
          </div>
          <div class="col-md-6">
            <label class="form-label">Senha (vazio = manter)</label>
            <input id="edit_pr_senha" class="form-control" placeholder="••••••">
          </div>
          <div class="col-md-3">
            <label class="form-label">Tipo</label>
            <input id="edit_pr_tipo" class="form-control" disabled>
          </div>
          <div class="col-md-9">
            <label class="form-label">Telefone</label>
            <input id="edit_pr_telefone" class="form-control" placeholder="(41) 99999-0000">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <!-- O update real fica no teu update.js -->
        <button id="btnSalvarProfResp" class="btn btn-primary">Salvar</button>
        <button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div></div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Tuas APIs JS externas (listar/criar/excluir/atualizar) -->
  <script src="/afonso/owl-school/public/assets/js/api/users/read.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/users/create.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/users/delete.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/users/update.js" defer></script>

  <!-- JS mínimo: toggle telefone no create + abrir o modal certo no editar -->
  <script>
  // Mostrar/ocultar telefone no formulário de criação (visual apenas)
  document.getElementById("tipo_usuario").addEventListener("change", function () {
    document.getElementById("grupo_tel_create").style.display =
      (this.value === "professor" || this.value === "responsavel") ? "block" : "none";
  });
  // inicializa estado
  document.addEventListener("DOMContentLoaded", function() {
    const sel = document.getElementById("tipo_usuario");
    document.getElementById("grupo_tel_create").style.display =
      (sel.value === "professor" || sel.value === "responsavel") ? "block" : "none";
  });

  </script>
</body>
</html>