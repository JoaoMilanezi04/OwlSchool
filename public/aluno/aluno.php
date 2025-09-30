<?php

require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';
require_once __DIR__ . '/../../api/aluno/aluno.php';

require_login();
require_role('aluno');

$userId   = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];

$responsavel = getNomeResponsavel($userId);

?>

<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool — Aluno</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background-color:#f8f9fa; }
    .avatar { width:100%; max-width:120px; aspect-ratio:1/1; border-radius:12px; object-fit:cover; border:2px solid #e9ecef; }
    .section-title { font-weight:700; letter-spacing:.3px; }
    .card { border-radius:14px; }
    main { padding-top:84px; padding-bottom:40px; }
  </style>
</head>
<body>

  <?php include __DIR__ . '/navbar.php'; ?>

  <main id="inicio">
    <div class="container">

      <section class="mb-4">
        <div class="row g-3 align-items-center">
          <div class="col-4 col-sm-3 col-md-2">
            <img class="avatar" src="../assets/media/aluno1.png" alt="Foto do aluno">
          </div>
          <div class="col-8 col-sm-9 col-md-10">
            <p>Aluno: <strong><?= $userName ?></strong></p>
            <p>Responsável: <strong><?= $responsavel ?: 'Não cadastrado' ?></strong></p>
            <p class="text-muted mb-2">3º Ano do Fundamental</p>
            <ul class="mb-0">
              <li>Você precisa melhorar em <strong>Matemática</strong>.</li>
              <li>Você está com <strong>2 faltas</strong> em Ciências.</li>
              <li>Você jogou <strong>4 minigames</strong> nesta semana.</li>
            </ul>
          </div>
        </div>
      </section>

      <section class="mb-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h2 class="h5 section-title mb-3">Missões do Dia</h2>
            <div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="m1">
                <label class="form-check-label" for="m1">Entregar tarefa</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="m2">
                <label class="form-check-label" for="m2">Realizar 5 minigames</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="m3">
                <label class="form-check-label" for="m3">Levar assinatura do responsável</label>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="mb-4">
        <div class="row g-3">
          <div class="col-12 col-md-4">
            <div class="card shadow-sm h-100">
              <div class="card-body">
                <h3 class="h6 section-title mb-2">Tarefa</h3>
                <p class="mb-0">Redação: “Meio ambiente na minha escola”. Entregar até amanhã.</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="card shadow-sm h-100">
              <div class="card-body">
                <h3 class="h6 section-title mb-2">Aulas de Amanhã</h3>
                <ul class="mb-0">
                  <li>07:50 – 08:50 • Matemática</li>
                  <li>08:50 – 09:30 • História</li>
                  <li>09:45 – 10:30 • Inglês</li>
                </ul>
              </div>
            </div>
          </div>
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

  <?php include __DIR__ . '/../../partials/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
