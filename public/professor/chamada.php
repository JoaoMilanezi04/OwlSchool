<?php
// public/professor/chamada.php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';
require_once __DIR__ . '/../../api/professor/chamada.php';

require_login();
require_role('professor');

/* ================================
   HANDLERS DE POST
   ================================ */

// Criar chamada
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ( $_POST['__act'] ?? '' ) === 'create_chamada') {
  $data = $_POST['data'] ?? null;
  if ($data) createChamada($data);
}

// Excluir chamada
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_chamada_id'])) {
  $id = (int)$_POST['delete_chamada_id'];
  deleteChamadaById($id);
}

// Editar chamada (data)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_chamada_id'])) {
  $id   = (int)$_POST['edit_chamada_id'];
  $data = $_POST['data'] ?? null;
  if ($data) updateChamada($id, $data);
}

// Salvar status em massa (presente/falta) para UMA chamada
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ( $_POST['__act'] ?? '' ) === 'save_status') {
  $chamadaId = isset($_POST['chamada_id']) ? (int)$_POST['chamada_id'] : 0;
  if ($chamadaId > 0) {
    $statusMap = $_POST['status'] ?? [];
    saveStatusEmMassa($chamadaId, $statusMap);
  }
}

$chamadas = listChamadas();
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
                <input type="hidden" name="__act" value="create_chamada">
                <div class="mb-3">
                  <label class="form-label">Data</label>
                  <input type="date" name="data" class="form-control" required>
                </div>
                <button class="btn btn-primary w-100">Salvar</button>
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
                               href="#collapseChamada<?= $chamada['id'] ?>">
                              Lançar presença
                            </a>

                            <button class="btn btn-sm btn-outline-secondary me-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditarChamada<?= $chamada['id'] ?>">
                              Editar
                            </button>

                            <form method="post" class="d-inline">
                              <input type="hidden" name="delete_chamada_id" value="<?= (int)$chamada['id'] ?>">
                              <button class="btn btn-sm btn-outline-danger">Excluir</button>
                            </form>

                          </td>
                        </tr>

                        <!-- Collapse com alunos daquela chamada específica -->
                        <tr class="bg-light">
                          <td colspan="2" class="p-0">
                            <div class="collapse" id="collapseChamada<?= $chamada['id'] ?>">
                              <div class="p-3 border-top">

                                <?php
                                  $alunos = listAlunosComStatusPorChamada($chamada['id']);
                                  if (empty($alunos)) {
                                    echo '<div class="alert alert-warning mb-0">Nenhum aluno encontrado.</div>';
                                  } else {
                                ?>

                                <form method="post">
                                  <input type="hidden" name="__act" value="save_status">
                                  <input type="hidden" name="chamada_id" value="<?= (int)$chamada['id'] ?>">

                                  <div class="d-flex gap-2 mb-3">
                                    <button type="button" class="btn btn-outline-success btn-sm"
                                            onclick="marcarTodos(this, 'presente')">Marcar todos: Presente</button>
                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                            onclick="marcarTodos(this, 'falta')">Marcar todos: Falta</button>
                                  </div>

                                  <div class="table-responsive">
                                    <table class="table table-sm align-middle">
                                      <thead>
                                        <tr>
                                          <th style="min-width:220px">Aluno</th>
                                          <th style="width:260px">Status</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php foreach ($alunos as $aluno): ?>
                                          <?php
                                            $alunoId = (int)$aluno['aluno_id'];
                                            $nome    = $aluno['nome'] !== null ? $aluno['nome'] : ('Aluno #'.$alunoId);
                                            $status  = $aluno['status']; // 'presente' | 'falta' | null
                                          ?>
                                          <tr>
                                            <td>
                                              <?= htmlspecialchars($nome) ?>
                                              <span class="text-muted">(#<?= htmlspecialchars($alunoId) ?>)</span>
                                            </td>
                                            <td>
                                              <div class="d-flex gap-3">
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio"
                                                         name="status[<?= $alunoId ?>]"
                                                         id="presente_<?= $alunoId ?>_<?= $chamada['id'] ?>"
                                                         value="presente" <?= $status === 'presente' ? 'checked' : '' ?>>
                                                  <label class="form-check-label" for="presente_<?= $alunoId ?>_<?= $chamada['id'] ?>">Presente</label>
                                                </div>
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio"
                                                         name="status[<?= $alunoId ?>]"
                                                         id="falta_<?= $alunoId ?>_<?= $chamada['id'] ?>"
                                                         value="falta" <?= $status === 'falta' ? 'checked' : '' ?>>
                                                  <label class="form-check-label" for="falta_<?= $alunoId ?>_<?= $chamada['id'] ?>">Falta</label>
                                                </div>
                                              </div>
                                            </td>
                                          </tr>
                                        <?php endforeach; ?>
                                      </tbody>
                                    </table>
                                  </div>

                                  <div class="d-flex gap-2">
                                    <button class="btn btn-success">Salvar presenças</button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="limparSelecoes(this)">Limpar</button>
                                  </div>
                                </form>

                                <?php } // endif alunos ?>

                              </div>
                            </div>
                          </td>
                        </tr>

                        <!-- Modal editar data -->
                        <div class="modal fade" id="modalEditarChamada<?= $chamada['id'] ?>" tabindex="-1">
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
    function marcarTodos(botao, valor) {
      const collapse = botao.closest('.collapse.show') || botao.closest('.collapse');
      if (!collapse) return;
      collapse.querySelectorAll('input[type="radio"][value="' + valor + '"]').forEach(r => { r.checked = true; });
    }

    function limparSelecoes(botao) {
      const collapse = botao.closest('.collapse.show') || botao.closest('.collapse');
      if (!collapse) return;
      collapse.querySelectorAll('input[type="radio"]').forEach(r => { r.checked = false; });
    }
  </script>

</body>
</html>
