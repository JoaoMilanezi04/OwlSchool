<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';
require_once __DIR__ . '/../../api/professor/prova.php';

require_login();
require_role('professor');

// Criar prova
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['__act'] ?? '') === 'create_prova') {
  createProva($_POST['titulo'], $_POST['data']);
}

// Excluir prova
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_prova_id'])) {
  deleteProvaById($_POST['delete_prova_id']);
}

// Salvar notas em massa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['__act'] ?? '') === 'save_notas') {
  saveNotasEmMassa($_POST['prova_id'], $_POST['notas'] ?? []);
}

// Editar prova (título/data)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_prova_id'])) {
  $id    = $_POST['edit_prova_id'];
  $titulo = $_POST['titulo'];
  $data   = $_POST['data'];
  updateProva($id, $titulo, $data);
}

$provas = listProvas();
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

        <div class="col-12 col-lg-4">
          <div class="card h-100">
            <div class="card-body">
              <h2 class="h6 mb-3">Criar nova prova</h2>

              <form method="post">
                <input type="hidden" name="__act" value="create_prova">

                <div class="mb-3">
                  <label class="form-label">Título</label>
                  <input name="titulo" class="form-control" required>
                </div>

                <div class="mb-3">
                  <label class="form-label">Data</label>
                  <input type="date" name="data" class="form-control" required>
                </div>

                <button class="btn btn-primary w-100">Salvar</button>
              </form>

            </div>
          </div>
        </div>

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
     href="#collapseNotas<?= $prova['id'] ?>">
     Lançar notas
  </a>

  <button class="btn btn-sm btn-outline-secondary me-2"
          data-bs-toggle="modal"
          data-bs-target="#modalEditarProva<?= $prova['id'] ?>">
    Editar
  </button>

  <form method="post" class="d-inline">
    <input type="hidden" name="delete_prova_id" value="<?= htmlspecialchars($prova['id']) ?>">
    <button class="btn btn-sm btn-outline-danger">Excluir</button>
  </form>
</td>

                        </tr>

                        <tr class="bg-light">
                          <td colspan="3" class="p-0">
                            <div class="collapse" id="collapseNotas<?= $prova['id'] ?>">
                              <div class="p-3 border-top">

                                <?php
                                  $alunos = listAlunosComNota($prova['id']);
                                  if (empty($alunos)) {
                                    echo '<div class="alert alert-warning mb-0">Nenhum aluno encontrado.</div>';
                                  } else {
                                ?>

                                <form method="post">
                                  <input type="hidden" name="__act" value="save_notas">
                                  <input type="hidden" name="prova_id" value="<?= htmlspecialchars($prova['id']) ?>">

                                  <div class="table-responsive">
                                    <table class="table table-sm align-middle">
                                      <thead>
                                        <tr>
                                          <th style="min-width:220px">Aluno</th>
                                          <th style="width:160px">Nota (0–10)</th>
                                        </tr>
                                      </thead>
                                      <tbody>

                                        <?php foreach ($alunos as $aluno): ?>
                                          <tr>
                                            <td><?= htmlspecialchars($aluno['nome']) ?> <span class="text-muted">(#<?= htmlspecialchars($aluno['aluno_id']) ?>)</span></td>
                                            <td>
                                              <input
                                                type="number"
                                                step="0.01"
                                                min="0"
                                                max="10"
                                                name="notas[<?= htmlspecialchars($aluno['aluno_id']) ?>]"
                                                value="<?= $aluno['nota'] !== null ? htmlspecialchars($aluno['nota']) : '' ?>"
                                                class="form-control form-control-sm"
                                                placeholder="ex.: 8.50"
                                                style="appearance: textfield; -moz-appearance: textfield; -webkit-appearance: none;">
                                            </td>
                                          </tr>
                                        <?php endforeach; ?>

                                      </tbody>
                                    </table>
                                  </div>

                                  <div class="d-flex gap-2">
                                    <button class="btn btn-success">Salvar notas</button>
                                    <button class="btn btn-outline-secondary" type="button" onclick="preencherCom('10')">Preencher 10</button>
                                    <button class="btn btn-outline-secondary" type="button" onclick="limparNotas()">Limpar</button>
                                  </div>
                                </form>

                                <?php } // endif alunos ?>

                              </div>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach; ?>

                    </tbody>
                  </table>
                </div>

                <!-- Modais de edição de Prova -->
                <?php foreach ($provas as $prova): ?>
                  <div class="modal fade" id="modalEditarProva<?= $prova['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <form method="post">
                          <div class="modal-header">
                            <h5 class="modal-title">Editar prova</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>

                          <div class="modal-body">
                            <input type="hidden" name="edit_prova_id" value="<?= $prova['id'] ?>">

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

              <?php endif; ?>

            </div>
          </div>
        </div>

      </div>

    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function preencherCom(valor) {
      const aberto = document.querySelector('.collapse.show');
      if (!aberto) return;
      aberto.querySelectorAll('input[type="number"]').forEach(i => i.value = valor);
    }

    function limparNotas() {
      const aberto = document.querySelector('.collapse.show');
      if (!aberto) return;
      aberto.querySelectorAll('input[type="number"]').forEach(i => i.value = '');
    }
  </script>

</body>
</html>
