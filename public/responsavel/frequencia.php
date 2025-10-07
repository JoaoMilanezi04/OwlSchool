<?php
// public/aluno/frequencia.php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';
require_once __DIR__ . '/../../api/responsavel/frequencia.php';

require_login();
require_role('responsavel');

/**
 * Pegando o ID do usuário logado.
 * Ajuste a linha abaixo conforme sua auth (ex.: $_SESSION['user']['id']).
 */
$alunoUsuarioId = (int)($_SESSION['user']['id'] ?? $_SESSION['usuario']['id'] ?? 0);
$userId   = $_SESSION['user_id'];
/* ================================
   FILTRO DE PERÍODO (opcional)
   ================================ */
$dataInicio = $_GET['data_inicio'] ?? null;
$dataFim    = $_GET['data_fim']    ?? null;

/* ================================
   CONSULTAS
   ================================ */
$resumo = getResumoFrequencia($alunoUsuarioId);
$linhas = listChamadasDoAluno($alunoUsuarioId);


// Cálculo para a barra de progresso
$percentual = (float)$resumo['percentual_presenca'];
?>

<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool — Minha Frequência</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <?php include __DIR__ . '/navbar.php'; // se tiver navbar comum para aluno ?>

  <main class="container py-4">
    <div class="row g-4">


      <!-- Resumo -->
      <div class="col-12 col-lg-4">
        <div class="card h-100">
          <div class="card-body">
            <h2 class="h6 mb-3">Resumo</h2>

            <div class="mb-2">
              <div class="d-flex justify-content-between small">
                <span>Presença</span>
                <span><?= number_format($percentual, 2, ',', '.') ?>%</span>
              </div>
              <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?= (int)$percentual ?>">
                <div class="progress-bar" style="width: <?= (float)$percentual ?>%"></div>
              </div>
            </div>

            <ul class="list-group list-group-flush">
              <li class="list-group-item d-flex justify-content-between"><span>Total de dias</span><strong><?= (int)$resumo['total_dias'] ?></strong></li>
              <li class="list-group-item d-flex justify-content-between text-success"><span>Presentes</span><strong><?= (int)$resumo['presentes'] ?></strong></li>
              <li class="list-group-item d-flex justify-content-between text-danger"><span>Faltas</span><strong><?= (int)$resumo['faltas'] ?></strong></li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Lista por dia -->
      <div class="col-12 col-lg-8">
        <div class="card">
          <div class="card-body">
            <h2 class="h6 mb-3">Chamadas do período</h2>

            <?php if (empty($linhas)): ?>
              <div class="alert alert-secondary mb-0">Nenhuma chamada encontrada para o período.</div>
            <?php else: ?>
              <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                  <thead>
                    <tr>
                      <th style="width: 160px;">Data</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($linhas as $linha): ?>
                      <?php
                        $status = $linha['status']; // 'presente' | 'falta' | NULL
                        $badgeClass = ($status === 'presente') ? 'bg-success' : 'bg-danger';
                        $texto = ($status === 'presente') ? 'Presente' : 'Falta';
                      ?>
                      <tr>
                        <td><?= htmlspecialchars($linha['data']) ?></td>
                        <td>
                          <span class="badge <?= $badgeClass ?>"><?= $texto ?></span>
                        </td>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
