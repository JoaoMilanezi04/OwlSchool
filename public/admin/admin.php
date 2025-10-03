<?php

//colocar require login dps do auth

$userId   = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];

?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool — Gerenciar Tarefas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{background:#f8f9fa}
    .card{border-radius:14px}
  </style>
</head>
<body>
  <?php include __DIR__ . '/navbar.php'; ?>
  <main class="container py-4">
    <h1 class="h4 mb-0">Bem-vindo, <strong><?= $userName ?></strong>!</h1>
    <p>Aqui estão suas informações.</p>
  </main>
</body>
</html>
