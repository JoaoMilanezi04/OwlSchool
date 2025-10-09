<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';

require_once __DIR__ . '/../../api/chamada/create.php';
require_once __DIR__ . '/../../api/chamada/read.php';
require_once __DIR__ . '/../../api/chamada/update.php';
require_once __DIR__ . '/../../api/chamada/delete.php';

require_once __DIR__ . '/../../api/chamada_item/create.php';
require_once __DIR__ . '/../../api/chamada_item/read.php';
require_once __DIR__ . '/../../api/chamada_item/update.php';
require_once __DIR__ . '/../../api/chamada_item/delete.php';

require_login();
require_role('professor');

// ---------- util: PRG mantendo a chamada aberta ----------
function redirect_self($openChamadaId = null) {
  $base = strtok($_SERVER['REQUEST_URI'], '?');
  if ($openChamadaId) {
    header('Location: ' . $base . '?open=' . (int)$openChamadaId . '#collapsePresencas' . (int)$openChamadaId);
  } else {
    header('Location: ' . $base);
  }
  exit;
}

// ---------- util: listar TODOS os alunos + status daquela chamada ----------
function listAlunosComStatusPorChamada(mysqli $conn, int $chamadaId): array {
  $chamadaId = (int)$chamadaId;
  $sql = "
    SELECT 
      a.usuario_id AS aluno_id,
      COALESCE(u.nome, CONCAT('Aluno #', a.usuario_id)) AS nome,
      ci.status AS status
    FROM aluno a
    LEFT JOIN usuario u ON u.id = a.usuario_id
    LEFT JOIN chamada_item ci
           ON ci.aluno_id = a.usuario_id
          AND ci.chamada_id = $chamadaId
    ORDER BY nome ASC, aluno_id ASC
  ";
  $res = $conn->query($sql);
  $out = [];
  if ($res) while ($r = $res->fetch_assoc()) $out[] = $r;
  return $out;
}

// ---------- AÇÕES ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $act = $_POST['__act'] ?? '';

  switch ($act) {
    case 'create_chamada':
      createChamada($_POST['data'] ?? '');
      return redirect_self();

    case 'save_status': {
      $chamadaId = (int)($_POST['chamada_id'] ?? 0);
      if ($chamadaId) {
        // salva só o que vier marcado. (Se quiser “não marcado = falta”, dá pra mudar aqui.)
        $statusMap = $_POST['status'] ?? []; // [ aluno_id => 'presente'|'falta' ]
        saveChamadaEmMassa($chamadaId, $statusMap);
      }
      return redirect_self($chamadaId);
    }

    case 'update_status_aluno': {
      $chamadaId = (int)($_POST['chamada_id'] ?? 0);
      $alunoId   = (int)($_POST['aluno_id'] ?? 0);
      $status    = $_POST['status_value'] ?? null; // 'presente'|'falta'|''

      if ($chamadaId && $alunoId) {
        if ($status === '' || $status === null) {
          deleteChamadaItem($chamadaId, $alunoId);
        } else {
          updateChamadaItem($chamadaId, $alunoId, $status);
        }
      }
      return redirect_self($chamadaId);
    }

    case 'delete_status_aluno': {
      $chamadaId = (int)($_POST['chamada_id'] ?? 0);
      $alunoId   = (int)($_POST['aluno_id'] ?? 0);
      if ($chamadaId && $alunoId) deleteChamadaItem($chamadaId, $alunoId);
      return redirect_self($chamadaId);
    }

    case 'delete_status_chamada': {
      $chamadaId = (int)($_POST['chamada_id'] ?? 0);
      if ($chamadaId) {
        // limpa todos os lançamentos desta chamada
        $alunos = listAlunosComStatusPorChamada($conn, $chamadaId);
        foreach ($alunos as $a) deleteChamadaItem($chamadaId, (int)$a['aluno_id']);
      }
      return redirect_self($chamadaId);
    }
  }

  // ações sem __act (forms simples)
  if (isset($_POST['delete_chamada_id'])) {
    deleteChamada((int)$_POST['delete_chamada_id']);
    return redirect_self();
  }
  if (isset($_POST['edit_chamada_id'])) {
    updateChamada((int)$_POST['edit_chamada_id'], $_POST['data'] ?? '');
    return redirect_self((int)$_POST['edit_chamada_id']);
  }
}

// ---------- GET ----------
$chamadas = readChamadas();
$open     = isset($_GET['open']) ? (int)$_GET['open'] : 0;
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool — Chamada</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">
      <div class="row g-4">

        <!-- Criar nova chamada -->
        <div class="col-12 col-lg-4">
          <div class="card h-100">
            <div class="card-body">
              <h2 class="h6 mb-3">Criar nova chamada</h2>
              <form method="post">
                <div class="mb-3">
                  <label class="form-label">Data</label>
                  <input type="date" name="data" class="form-control" required>
                </div>
                <button class="btn btn-primary w-100" name="__act" value="create_chamada">Salvar</button>
              </form>
            </div>
          </div>
        </div>

        <!-- Lista de chamadas -->
        <div class="col-12 col-lg-8">
          <div class="card">
            <div class="card-body">
              <h2 class="h6 mb-3">Chamadas</h2>

              <?php if (empty($chamadas)): ?>
                <div class="alert alert-secondary mb-0">Nenhuma chamada cadastrada.</div>
              <?php else: ?>

              <div class="table-responsive mb-3">
                <table class="table table-striped align-middle mb-0">
                  <thead>
                    <tr>
                      <th>Data</th>
                      <th class="text-end">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($chamadas as $chamada): ?>
                      <tr>
                        <td><?= htmlspecialchars($chamada['data']) ?></td>
                        <td class="text-end">
                          <a class="btn btn-sm btn-primary me-2"
                             data-bs-toggle="collapse"
                             href="#collapsePresencas<?= (int)$chamada['id'] ?>">
                            Lançar presença
                          </a>

                          <button class="btn btn-sm btn-outline-secondary me-2"
                                  data-bs-toggle="modal"
                                  data-bs-target="#modalEditarChamada<?= (int)$chamada['id'] ?>">
                            Editar
                          </button>

                          <form method="post" class="d-inline">
                            <input type="hidden" name="delete_chamada_id" value="<?= (int)$chamada['id'] ?>">
                            <button class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Excluir esta chamada? Isso removerá também as presenças.')">
                              Excluir
                            </button>
                          </form>
                        </td>
                      </tr>

                      <!-- Área de presença (collapse por chamada) -->
                      <tr class="bg-light">
                        <td colspan="2" class="p-0">
                          <div class="collapse" id="collapsePresencas<?= (int)$chamada['id'] ?>">
                            <div class="p-3 border-top">
                              <?php
                                $alunos = listAlunosComStatusPorChamada($conn, (int)$chamada['id']); 
                                if (empty($alunos)) {
                                  echo '<div class="alert alert-warning mb-0">Nenhum aluno encontrado.</div>';
                                } else {
                              ?>

                              <!-- Form ÚNICO por chamada -->
                              <form method="post" class="mb-2">
                                <input type="hidden" name="chamada_id" value="<?= (int)$chamada['id'] ?>">
                                <!-- hiddens para botões individuais -->
                                <input type="hidden" name="aluno_id" id="aluno_id_hidden_<?= (int)$chamada['id'] ?>">
                                <input type="hidden" name="status_value" id="status_hidden_<?= (int)$chamada['id'] ?>">

                                <div class="table-responsive">
                                  <table class="table table-sm align-middle">
                                    <thead>
                                      <tr>
                                        <th style="min-width:220px">Aluno</th>
                                        <th style="width:260px">Status</th>
                                        <th class="text-end" style="width:220px">Opções</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php foreach ($alunos as $aluno): ?>
                                        <?php
                                          $alunoId = (int)$aluno['aluno_id'];
                                          $nome    = $aluno['nome'] ?? ('Aluno #'.$alunoId);
                                          $status  = $aluno['status']; // 'presente' | 'falta' | NULL (NAO_LANCADA)
                                        ?>
                                        <tr>
                                          <td>
                                            <?= htmlspecialchars($nome) ?>
                                            <span class="text-muted">(#<?= $alunoId ?>)</span>
                                          </td>
                                          <td>
                                            <div class="d-flex gap-3">
                                              <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                       name="status[<?= $alunoId ?>]"
                                                       id="presente_<?= $alunoId ?>_<?= (int)$chamada['id'] ?>"
                                                       value="presente" <?= $status==='presente' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="presente_<?= $alunoId ?>_<?= (int)$chamada['id'] ?>">Presente</label>
                                              </div>
                                              <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                       name="status[<?= $alunoId ?>]"
                                                       id="falta_<?= $alunoId ?>_<?= (int)$chamada['id'] ?>"
                                                       value="falta" <?= $status==='falta' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="falta_<?= $alunoId ?>_<?= (int)$chamada['id'] ?>">Falta</label>
                                              </div>
                                            </div>
                                            <?php if ($status === null): ?>
                                              <small class="text-muted">NAO_LANCADA</small>
                                            <?php endif; ?>
                                          </td>
                                          <td class="text-end">
                                            <!-- EDITAR (somente este aluno) -->
                                            <button
                                              type="submit"
                                              class="btn btn-sm btn-outline-primary me-1"
                                              name="__act" value="update_status_aluno"
                                              onclick="
                                                const rowChecked = this.closest('tr').querySelector('input[type=radio]:checked');
                                                document.getElementById('aluno_id_hidden_<?= (int)$chamada['id'] ?>').value = '<?= $alunoId ?>';
                                                document.getElementById('status_hidden_<?= (int)$chamada['id'] ?>').value = rowChecked ? rowChecked.value : '';
                                              ">
                                              Editar
                                            </button>

                                            <!-- EXCLUIR presença do aluno -->
                                            <button
                                              type="submit"
                                              class="btn btn-sm btn-outline-danger"
                                              name="__act" value="delete_status_aluno"
                                              onclick="
                                                if(!confirm('Remover o lançamento deste aluno?')) return false;
                                                document.getElementById('aluno_id_hidden_<?= (int)$chamada['id'] ?>').value = '<?= $alunoId ?>';
                                              ">
                                              Excluir
                                            </button>
                                          </td>
                                        </tr>
                                      <?php endforeach; ?>
                                    </tbody>
                                  </table>
                                </div>

                                <div class="d-flex flex-wrap gap-2">
                                  <button class="btn btn-success" name="__act" value="save_status">Salvar presenças</button>
                                  <button class="btn btn-outline-danger ms-auto"
                                          name="__act" value="delete_status_chamada"
                                          onclick="return confirm('Limpar TODAS as presenças desta chamada?')">
                                    Limpar todas as presenças
                                  </button>
                                </div>
                              </form>

                              <?php } // endif alunos ?>
                            </div>
                          </div>
                        </td>
                      </tr>

                      <!-- Modal editar chamada -->
                      <div class="modal fade" id="modalEditarChamada<?= (int)$chamada['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <form method="post">
                              <div class="modal-header">
                                <h5 class="modal-title">Editar chamada</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                              <div class="modal-body">
                                <input type="hidden" name="edit_chamada_id" value="<?= (int)$chamada['id'] ?>">
                                <div class="mb-3">
                                  <label class="form-label">Data</label>
                                  <input type="date" name="data" class="form-control"
                                         value="<?= htmlspecialchars($chamada['data']) ?>" required>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Salvar alterações</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

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
  <script>
    // Reabrir a chamada após PRG (mesmo padrão das provas)
    (function() {
      const params = new URLSearchParams(location.search);
      const open = params.get('open');
      if (!open) return;
      const el = document.getElementById('collapsePresencas' + open);
      if (!el) return;
      const c = new bootstrap.Collapse(el, { toggle: false });
      c.show();
    })();
  </script>
</body>
</html>
