<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';

require_once __DIR__ . '/../../api/prova/create.php';
require_once __DIR__ . '/../../api/prova/read.php';
require_once __DIR__ . '/../../api/prova/update.php';
require_once __DIR__ . '/../../api/prova/delete.php';

require_once __DIR__ . '/../../api/nota_prova/create.php';
require_once __DIR__ . '/../../api/nota_prova/read.php';
require_once __DIR__ . '/../../api/nota_prova/update.php';
require_once __DIR__ . '/../../api/nota_prova/delete.php';

require_login();
require_role('professor');

// ---------- util: PRG mantendo a prova aberta ----------
function redirect_self($openProvaId = null) {
  $base = strtok($_SERVER['REQUEST_URI'], '?');
  if ($openProvaId) {
    header('Location: ' . $base . '?open=' . (int)$openProvaId . '#collapseNotas' . (int)$openProvaId);
  } else {
    header('Location: ' . $base);
  }
  exit;
}

// ---------- AÇÕES ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $act = $_POST['__act'] ?? '';
  switch ($act) {
    case 'create_prova':
      createProva($_POST['titulo'], $_POST['data']);
      return redirect_self();

    case 'save_notas':
      $provaId = (int)($_POST['prova_id'] ?? 0);
      $notas   = $_POST['notas'] ?? [];
      saveNotasEmMassa($provaId, $notas);
      return redirect_self($provaId);

    case 'update_nota_aluno':
      $provaId = (int)($_POST['prova_id'] ?? 0);
      $alunoId = (int)($_POST['aluno_id'] ?? 0);
      $nota    = $_POST['nota'] ?? null;
      if ($provaId && $alunoId) {
        if ($nota === '' || $nota === null) deleteNotaAluno($provaId, $alunoId);
        else updateNota($provaId, $alunoId, $nota);
      }
      return redirect_self($provaId);

    case 'delete_nota_aluno':
      $provaId = (int)($_POST['prova_id'] ?? 0);
      $alunoId = (int)($_POST['aluno_id'] ?? 0);
      if ($provaId && $alunoId) deleteNotaAluno($provaId, $alunoId);
      return redirect_self($provaId);

    case 'delete_notas_prova':
      $provaId = (int)($_POST['prova_id'] ?? 0);
      if ($provaId) deleteNotasByProva($provaId);
      return redirect_self($provaId);
  }

  // ações sem __act (form separado)
  if (isset($_POST['delete_prova_id'])) {
    deleteProvaById((int)$_POST['delete_prova_id']);
    return redirect_self();
  }
  if (isset($_POST['edit_prova_id'])) {
    updateProva((int)$_POST['edit_prova_id'], $_POST['titulo'] ?? '', $_POST['data'] ?? '');
    return redirect_self();
  }
}

$provas = readProvas();
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool — Provas e Notas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">
      <div class="row g-4">

        <!-- Criar nova prova -->
        <div class="col-12 col-lg-4">
          <div class="card h-100">
            <div class="card-body">
              <h2 class="h6 mb-3">Criar nova prova</h2>
              <form method="post">
                <div class="mb-3">
                  <label class="form-label">Título</label>
                  <input name="titulo" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Data</label>
                  <input type="date" name="data" class="form-control" required>
                </div>
                <button class="btn btn-primary w-100" name="__act" value="create_prova">Salvar</button>
              </form>
            </div>
          </div>
        </div>

        <!-- Lista de provas + notas -->
        <div class="col-12 col-lg-8">
          <div class="card">
            <div class="card-body">
              <h2 class="h6 mb-3">Provas</h2>

              <?php if (empty($provas)): ?>
                <div class="alert alert-secondary mb-0">Nenhuma prova cadastrada.</div>
              <?php else: ?>

              <div class="table-responsive mb-3">
                <table class="table table-striped align-middle mb-0">
                  <thead>
                    <tr>
                      <th>Título</th>
                      <th>Data</th>
                      <th class="text-end">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($provas as $prova): ?>
                      <tr>
                        <td><?= htmlspecialchars($prova['titulo']) ?></td>
                        <td><?= htmlspecialchars($prova['data']) ?></td>
                        <td class="text-end">
                          <a class="btn btn-sm btn-primary me-2"
                             data-bs-toggle="collapse"
                             href="#collapseNotas<?= (int)$prova['id'] ?>">
                            Lançar notas
                          </a>

                          <button class="btn btn-sm btn-outline-secondary me-2"
                                  data-bs-toggle="modal"
                                  data-bs-target="#modalEditarProva<?= (int)$prova['id'] ?>">
                            Editar
                          </button>

                          <form method="post" class="d-inline">
                            <input type="hidden" name="delete_prova_id" value="<?= (int)$prova['id'] ?>">
                            <button class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Excluir esta prova? Isso removerá também as notas.')">
                              Excluir
                            </button>
                          </form>
                        </td>
                      </tr>

                      <!-- Área de notas da prova -->
                      <tr class="bg-light">
                        <td colspan="3" class="p-0">
                          <div class="collapse" id="collapseNotas<?= (int)$prova['id'] ?>">
                            <div class="p-3 border-top">
                              <?php
                                $alunos = readNotasByProva((int)$prova['id']); // deve trazer aluno_id, nome, nota (ou NULL), lancada (0/1)
                                if (empty($alunos)) {
                                  echo '<div class="alert alert-warning mb-0">Nenhum aluno encontrado.</div>';
                                } else {
                              ?>

                              <!-- Form ÚNICO por prova (sem forms aninhados) -->
                              <form method="post" class="mb-2">
                                <input type="hidden" name="prova_id" value="<?= (int)$prova['id'] ?>">
                                <!-- hidden usados pelos botões Editar/Excluir -->
                                <input type="hidden" name="aluno_id" id="aluno_id_hidden_<?= (int)$prova['id'] ?>">
                                <input type="hidden" name="nota"     id="nota_hidden_<?= (int)$prova['id'] ?>">

                                <div class="table-responsive">
                                  <table class="table table-sm align-middle">
                                    <thead>
                                      <tr>
                                        <th style="min-width:220px">Aluno</th>
                                        <th style="width:160px">Nota (0–10)</th>
                                        <th style="width:220px" class="text-end">Opções</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php foreach ($alunos as $aluno): ?>
                                        <tr>
                                          <td>
                                            <?= htmlspecialchars($aluno['nome']) ?>
                                            <span class="text-muted">(#<?= (int)$aluno['aluno_id'] ?>)</span>
                                          </td>
                                          <td>
                                            <input
                                              type="number"
                                              step="0.01" min="0" max="10"
                                              name="notas[<?= (int)$aluno['aluno_id'] ?>]"
                                              value="<?= !empty($aluno['lancada']) ? htmlspecialchars($aluno['nota']) : '' ?>"
                                              class="form-control form-control-sm"
                                              placeholder="<?= !empty($aluno['lancada']) ? '' : 'NAO_LANCADA' ?>"
                                              style="appearance:textfield;-moz-appearance:textfield;-webkit-appearance:none;">
                                          </td>
                                          <td class="text-end">
                                            <!-- EDITAR (somente este aluno) -->
                                            <button
                                              type="submit"
                                              class="btn btn-sm btn-outline-primary me-1"
                                              name="__act" value="update_nota_aluno"
                                              onclick="
                                                const rowInput = this.closest('tr').querySelector('input[type=number]');
                                                document.getElementById('aluno_id_hidden_<?= (int)$prova['id'] ?>').value = '<?= (int)$aluno['aluno_id'] ?>';
                                                document.getElementById('nota_hidden_<?= (int)$prova['id'] ?>').value = rowInput.value ?? '';
                                              ">
                                              Editar
                                            </button>

                                            <!-- EXCLUIR nota do aluno -->
                                            <button
                                              type="submit"
                                              class="btn btn-sm btn-outline-danger"
                                              name="__act" value="delete_nota_aluno"
                                              onclick="
                                                if(!confirm('Remover a nota deste aluno?')) return false;
                                                document.getElementById('aluno_id_hidden_<?= (int)$prova['id'] ?>').value = '<?= (int)$aluno['aluno_id'] ?>';
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
                                  <button class="btn btn-success" name="__act" value="save_notas">Salvar notas</button>
                                  <button class="btn btn-outline-danger ms-auto"
                                          name="__act" value="delete_notas_prova"
                                          onclick="return confirm('Limpar TODAS as notas desta prova?')">
                                    Limpar todas as notas
                                  </button>
                                </div>
                              </form>

                              <?php } // endif alunos ?>
                            </div>
                          </div>
                        </td>
                      </tr>

                      <!-- Modal editar prova -->
                      <div class="modal fade" id="modalEditarProva<?= (int)$prova['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <form method="post">
                              <div class="modal-header">
                                <h5 class="modal-title">Editar prova</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                              <div class="modal-body">
                                <input type="hidden" name="edit_prova_id" value="<?= (int)$prova['id'] ?>">
                                <div class="mb-3">
                                  <label class="form-label">Título</label>
                                  <input type="text" name="titulo" class="form-control"
                                         value="<?= htmlspecialchars($prova['titulo']) ?>" required>
                                </div>
                                <div class="mb-3">
                                  <label class="form-label">Data</label>
                                  <input type="date" name="data" class="form-control"
                                         value="<?= htmlspecialchars($prova['data']) ?>" required>
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
    // Reabrir a prova após PRG
    (function() {
      const params = new URLSearchParams(location.search);
      const open = params.get('open');
      if (!open) return;
      const el = document.getElementById('collapseNotas' + open);
      if (!el) return;
      const c = new bootstrap.Collapse(el, { toggle: false });
      c.show();
    })();
  </script>
</body>
</html>
