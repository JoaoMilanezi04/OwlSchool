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

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS próprio -->
  <link rel="stylesheet" href="/owl-school/public/assets/css/responsavel/responsavel.css">
</head>

<body class="bg-light">

  <!-- Navbar -->
  <?php include __DIR__ . '/navbar.php'; ?>

  <!-- ============================== -->
  <!-- Conteúdo principal -->
  <!-- ============================== -->
  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">

      <h1 class="h4 mb-2">Bem-vindo, <strong><?= htmlspecialchars($userName) ?></strong>!</h1>
      <p class="mb-4 text-muted">Aqui estão as informações do seu filho.</p>

      <!-- ============================== -->
      <!-- Card: Nome do filho -->
      <!-- ============================== -->
      <div class="card shadow-sm border-0">
        <div class="card-body text-center py-5">
          <h2 class="h6 fw-bold mb-3">Aluno vinculado:</h2>
          <p id="nomeFilho" class="fs-5 text-muted mb-0">Carregando...</p>
        </div>
      </div>

    </main>
  </div>

  <!-- ============================== -->
  <!-- Scripts -->
  <!-- ============================== -->
  <script src="/owl-school/public/assets/js/api/utils/responsavel/nome_filho.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
