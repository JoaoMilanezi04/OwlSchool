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
  <title>OlwSchool — Agenda (Horários)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{background:#f8f9fa}
    .card{border-radius:14px}
    .table td, .table th{vertical-align: middle;}
  </style>
</head>
<body>

  <?php include __DIR__ . '/navbar.php'; ?>

  <main class="container py-4" style="max-width:1000px">
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
          <h1 class="h5 m-0">Agenda — Horários de Aula</h1>
        </div>

        <!-- FORM CRIAR -->
        <h2 class="h6 mb-2">Adicionar horário</h2>
        <form class="row g-2 mb-4">
          <div class="col-12 col-md-3">
            <label class="form-label">Dia da semana</label>
            <select id="dia_semana" class="form-select" required>
              <option value="" selected disabled>Selecione</option>
              <option value="segunda">Segunda</option>
              <option value="terca">Terça</option>
              <option value="quarta">Quarta</option>
              <option value="quinta">Quinta</option>
              <option value="sexta">Sexta</option>
            </select>
          </div>
          <div class="col-6 col-md-2">
            <label class="form-label">Início</label>
            <input id="inicio" type="time" class="form-control" required>
          </div>
          <div class="col-6 col-md-2">
            <label class="form-label">Fim</label>
            <input id="fim" type="time" class="form-control" required>
          </div>
          <div class="col-12 col-md-5">
            <label class="form-label">Disciplina</label>
            <input id="disciplina" class="form-control" placeholder="Ex.: Matemática" required>
          </div>
          <div class="col-12">
            <button id="btnCriarHorario" class="btn btn-success">Salvar</button>
          </div>
        </form>

        <!-- LISTA -->
<div class="container">
  <h2>Segunda-feira</h2>
  <table class="table">
    <tbody id="segunda"></tbody>
  </table>

  <h2>Terça-feira</h2>
  <table class="table">
    <tbody id="terca"></tbody>
  </table>

  <h2>Quarta-feira</h2>
  <table class="table">
    <tbody id="quarta"></tbody>
  </table>

  <h2>Quinta-feira</h2>
  <table class="table">
    <tbody id="quinta"></tbody>
  </table>

  <h2>Sexta-feira</h2>
  <table class="table">
    <tbody id="sexta"></tbody>
  </table>
</div>

  </main>

  <!-- MODAL EDITAR -->
  <div class="modal fade" id="editModalHorario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content" onsubmit="event.preventDefault(); document.getElementById('btnSalvarHorario').click();">
        <div class="modal-header">
          <h5 class="modal-title">Editar horário</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <label class="form-label">Dia da semana</label>
            <select id="edit_dia_semana" class="form-select" required>
              <option value="segunda">Segunda</option>
              <option value="terca">Terça</option>
              <option value="quarta">Quarta</option>
              <option value="quinta">Quinta</option>
              <option value="sexta">Sexta</option>
            </select>
          </div>
          <div class="row g-2">
            <div class="col-6">
              <label class="form-label">Início</label>
              <input id="edit_inicio" type="time" class="form-control" required>
            </div>
            <div class="col-6">
              <label class="form-label">Fim</label>
              <input id="edit_fim" type="time" class="form-control" required>
            </div>
          </div>
          <div class="mt-2">
            <label class="form-label">Disciplina</label>
            <input id="edit_disciplina" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button id="btnSalvarHorario" type="button" class="btn btn-primary">Salvar alterações</button>
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

   <script src="/afonso/owl-school/public/assets/js/api/agenda/read.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/agenda/create.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/agenda/delete.js" defer></script>
  <script src="/afonso/owl-school/public/assets/js/api/agenda/update.js" defer></script>
</body>
</html>
