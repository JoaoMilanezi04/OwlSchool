<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';

require_login();
require_role('responsavel');

$userName = $_SESSION['user_name'];
?>

<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool — Área do Responsável</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background:#f8f9fa; }
    .card { border-radius:14px; }
  </style>
</head>

<body>

  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">

      <h1 class="h4 mb-0">Bem-vindo, <strong><?= htmlspecialchars($userName) ?></strong>!</h1>
      <p class="mb-4">Aqui estão as informações do seu filho.</p>

      <div class="card shadow-sm border-0">
        <div class="card-body text-center py-5">

          <h5 class="fw-bold mb-3">Aluno vinculado:</h5>
          <p id="nomeFilho" class="fs-5 mb-0 text-muted">Carregando...</p>

        </div>
      </div>

    </main>
  </div>

  <script src="/afonso/owl-school/public/assets/js/api/utils/responsavel/nome_filho.js"></script>

</body>
</html>
