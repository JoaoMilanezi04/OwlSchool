<?php


require_once __DIR__ . '/../../includes/auth.php';



require_login();
require_role('admin');



$usuarioNome = $_SESSION['user_name'];


?>


<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool — Área do Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background:#f8f9fa }
    .card { border-radius:14px }
  </style>
</head>


<body>

  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">

      <h1 class="h4 mb-0">Bem-vindo, <strong><?= htmlspecialchars($usuarioNome) ?></strong>!</h1>
      <p class="mb-0">Aqui estão suas informações.</p>

    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
