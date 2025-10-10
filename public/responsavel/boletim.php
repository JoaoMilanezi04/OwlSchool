<?php


require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';


require_once __DIR__ . '/../../api/comunicado/read.php';
require_once __DIR__ . '/../../api/prova_nota/read.php';

require_once __DIR__ . '/../../api/utils/responsavel.php';

require_login();
require_role('responsavel');



$userId = $_SESSION['user_id'];

$alunoNome = getNomeFilho($userId);
$alunoId   = getIdFilho($userId);

$provas = listProvasENotasDoAluno($alunoId);
$media  = mediaNotasDoAluno($alunoId);





function br_date(?string $ymd): string {
  if (!$ymd) return '';
  $dt = DateTime::createFromFormat('Y-m-d', $ymd);
  return $dt ? $dt->format('d/m/Y') : htmlspecialchars($ymd);
}



function situacao(?float $nota): array {
  if ($nota === null) return ['Em aberto', 'secondary'];
  if ($nota >= 6.0)   return ['Aprovado', 'success'];
  return ['Reprovado', 'danger'];
}


?>


<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool — Notas do Denpendente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<body class="bg-light">

  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">

      <div class="row g-3">
        <div class="col-12 d-flex align-items-center justify-content-between">
          <h1 class="h4 mb-0">Notas do Dependente</h1>
          <span class="text-muted small">
            Logado como: <?= htmlspecialchars($alunoNome) ?> (#<?= $alunoId ?>)
          </span>
        </div>



        <div class="col-12 col-lg-4">
          <div class="card">
            <div class="card-body">
              <h2 class="h6 mb-2">Média geral</h2>
              <div class="display-6 mb-0">
                <?= $media !== null ? number_format($media, 2, ',', '') : '—' ?>
              </div>
              <div class="text-muted small">
                Somente provas avaliadas entram no cálculo.
              </div>
            </div>
          </div>
        </div>



        <div class="col-12 col-lg-8">
          <div class="card">
            <div class="card-body">
              <h2 class="h6 mb-3">Provas</h2>

              <?php if (empty($provas)): ?>
                <div class="alert alert-secondary mb-0">
                  Nenhuma prova cadastrada até o momento.
                </div>
              <?php else: ?>

                <div class="table-responsive">
                  <table class="table table-striped align-middle mb-0">
                    <thead>
                      <tr>
                        <th style="width:110px">Data</th>
                        <th>Prova</th>
                        <th style="width:120px">Nota</th>
                        <th style="width:130px">Situação</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php foreach ($provas as $prova): ?>
                        <?php
                          $nota = $prova['nota'] !== null ? (float)$prova['nota'] : null;
                          [$sitLabel, $sitColor] = situacao($nota);
                        ?>
                        <tr>
                          <td><?= br_date($prova['data']) ?></td>
                          <td><?= htmlspecialchars($prova['titulo']) ?></td>
                          <td><?= $nota !== null ? number_format($nota, 2, ',', '') : '—' ?></td>
                          <td><span class="badge text-bg-<?= $sitColor ?>"><?= $sitLabel ?></span></td>
                        </tr>
                      <?php endforeach; ?>

                    </tbody>
                  </table>
                </div>

              <?php endif; ?>

            </div>
          </div>
        </div>

      </div>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
