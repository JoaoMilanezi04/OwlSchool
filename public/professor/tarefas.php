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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">
      <div class="row g-4">

        <!-- Criar nova tarefa (via JS) -->
        <div class="col-12 col-lg-4">
          <div class="card h-100">
            <div class="card-body">
              <h2 class="h6 mb-3">Criar nova tarefa</h2>

              <!-- não submete; JS captura pelo botão -->
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
        </div>

        <!-- Lista de tarefas (preenchida pelo read.js) -->
        <div class="col-12 col-lg-8">
          <div class="card">
            <div class="card-body">
              <h2 class="h6 mb-3">Tarefas criadas</h2>

              <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Título</th>
                      <th>Entrega</th>
                      <th>Descrição</th>
                      <th class="text-end">Ações</th>
                    </tr>
                  </thead>
                  <tbody id="tbodyTarefas">
                    <!-- linhas inseridas via JS -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- Editar / Excluir (via JS) -->
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h2 class="h6 mb-3">Editar / Excluir tarefa</h2>
              <div class="row g-3">
                <div class="col-12 col-md-2">
                  <label class="form-label">ID</label>
                  <input id="id" class="form-control" placeholder="Selecione na tabela">
                </div>
                <div class="col-12 col-md-3">
                  <label class="form-label">Título</label>
                  <input id="titulo_edit" class="form-control">
                </div>
                <div class="col-12 col-md-3">
                  <label class="form-label">Descrição</label>
                  <input id="descricao_edit" class="form-control">
                </div>
                <div class="col-12 col-md-2">
                  <label class="form-label">Data de entrega</label>
                  <input id="data_entrega_edit" type="date" class="form-control">
                </div>
                <div class="col-12 col-md-2 d-flex align-items-end gap-2">
                  <button id="btnEditar"  type="button" class="btn btn-outline-secondary w-100">Salvar edição</button>
                  <button id="btnExcluir" type="button" class="btn btn-outline-danger w-100">Excluir</button>
                </div>
              </div>
              <small class="text-muted d-block mt-2">
                Dica: clique em “Editar” na tabela para preencher os campos acima automaticamente.
              </small>
            </div>
          </div>
        </div>

      </div>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- no final do <body> ou até no <head>, mas com defer -->
<script src="/afonso/owl-school/public/assets/js/api/tarefa/read.js" defer></script>
<script src="/afonso/owl-school/public/assets/js/api/tarefa/create.js" defer></script>
<script src="/afonso/owl-school/public/assets/js/api/tarefa/update.js" defer></script>
<script src="/afonso/owl-school/public/assets/js/api/tarefa/delete.js" defer></script>

</body>
</html>
