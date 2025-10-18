<?php
require_once __DIR__ . '/../../includes/auth.php';

require_login();
require_role('responsavel');
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool — Agenda da Semana</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <div class="container py-4">

      <h3 class="fw-bold mb-4">📘 Agenda da Semana</h3>

      <!-- Cards por dia com tabela; os <tbody> têm IDs que o JS usa -->
      <?php
        $dias = [
          'segunda' => 'Segunda-feira',
          'terca'   => 'Terça-feira',
          'quarta'  => 'Quarta-feira',
          'quinta'  => 'Quinta-feira',
          'sexta'   => 'Sexta-feira'
        ];
        foreach ($dias as $key => $label):
      ?>
        <div class="card shadow-sm mb-3">
          <div class="card-header fw-semibold bg-primary text-white">
            <?= $label ?>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-sm mb-0 align-middle">
                <thead class="table-light">
                  <tr>
                    <th style="width: 110px;">Início</th>
                    <th style="width: 110px;">Fim</th>
                    <th>Disciplina</th>

                  </tr>
                </thead>
                <tbody id="<?= $key ?>">
                  <!-- preenchido pelo JS -->
                  <tr><td colspan="4" class="text-muted">Carregando…</td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

    </div>
  </div>

  <!-- JS que faz o fetch e preenche cada <tbody id="segunda|terca|..."> -->
  <script src="/afonso/owl-school/public/assets/js/api/agenda/read.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
