<?php
require_once __DIR__ . '/../../includes/auth.php';

require_login();
require_role('aluno');
?>

<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>OlwSchool — Agenda da Semana</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS próprio -->
  <link rel="stylesheet" href="/owl-school/public/assets/css/aluno/agenda.css">
</head>

<body class="bg-light">

  <!-- Navbar -->
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">

      <!-- ============================== -->
      <!-- Cabeçalho -->
      <!-- ============================== -->
      <h1 class="h5 fw-bold mb-4">📘 Agenda da Semana</h1>

      <!-- ============================== -->
      <!-- Cards por dia -->
      <!-- ============================== -->
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
        <div class="card shadow-sm mb-4">
          <div class="card-header fw-semibold bg-success text-white">
            <?= $label ?>
          </div>
          <div class="card-body p-0">
            <table class="table table-sm mb-0 align-middle">
              <thead class="table-light">
                <tr>
                  <th style="width:110px;">Início</th>
                  <th style="width:110px;">Fim</th>
                  <th>Disciplina</th>
                </tr>
              </thead>
              <tbody id="<?= $key ?>">

                <tr><td colspan="3" class="text-muted">Carregando…</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      <?php endforeach; ?>

    </main>
  </div>

  <!-- ============================== -->
  <!-- Scripts -->
  <!-- ============================== -->
  <!-- Preenche cada <tbody id="segunda|terca|..."> -->
  <script src="/owl-school/public/assets/js/api/agenda/read.js"></script>

  <!-- Bootstrap (por último) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
