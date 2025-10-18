<?php


require_once __DIR__ . '/../../includes/auth.php';

require_login();
require_role('aluno');



$usuarioId   = $_SESSION['user_id'];
$usuarioNome = $_SESSION['user_name'];








?>


<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool — Início do Aluno</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .avatar {
      width: 100%;
      max-width: 120px;
      aspect-ratio: 1 / 1;
      border-radius: 12px;
      object-fit: cover;
      border: 2px solid #e9ecef;
    }
    .section-title { font-weight: 700; letter-spacing: .3px; }
    .card { border-radius: 14px; }
    main { padding-top: 84px; padding-bottom: 40px; }
  </style>
</head>


<body class="bg-light">

  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main id="inicio">

      <div class="container">

        <h1 class="h4 mb-4">Início do Aluno</h1>

       

            <div class="col-12 col-md-4">
              <div class="card shadow-sm h-100">
                <div class="card-body">
                  <h3 class="h6 section-title mb-2">Conquistas</h3>
                  <ul class="mb-0">
                    <li>🏅 Medalha “Pontual”</li>
                    <li>🏅 Medalha “Leitor da Semana”</li>
                    <li>🏅 Medalha “Amigo da Turma”</li>
                  </ul>
                </div>
              </div>
            </div>

          </div>
        </section>

      </div>

    </main>
  </div>

  <?php include __DIR__ . '/../../partials/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
