<?php


require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';
require_once __DIR__ . '/../../api/aluno/comunicado.php';



require_login();
require_role('aluno');



$comunicados = listComunicadosAluno();


?>


<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool — Comunicados</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<body class="bg-light">

  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">


      <h1 class="h4 mb-4">Comunicados</h1>


      <?php if (empty($comunicados)): ?>
        <div class="alert alert-secondary">Nenhum comunicado disponível.</div>
      <?php else: ?>

        <div class="list-group shadow-sm">
          <?php foreach ($comunicados as $comunicado): ?>
            <div class="list-group-item">
              <h5 class="mb-1"><?= htmlspecialchars($comunicado['titulo']) ?></h5>
              <p class="mb-1 small"><?= nl2br(htmlspecialchars($comunicado['corpo'])) ?></p>
            </div>
          <?php endforeach; ?>
        </div>

      <?php endif; ?>


    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
