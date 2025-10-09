<?php

require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';

require_once __DIR__ . '/../../api/admin/admin.php';



require_once __DIR__ . '/../../api/advertencia/create.php';
require_once __DIR__ . '/../../api/advertencia/read.php';
require_once __DIR__ . '/../../api/advertencia/update.php';
require_once __DIR__ . '/../../api/advertencia/delete.php';


require_login();
require_role('admin');

/* Criação (obrigatório selecionar aluno) */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (($_POST['__act'] ?? '') === 'create_advertencia')) {
  $titulo = trim($_POST['titulo']);
  $descricao = trim($_POST['descricao']);
  $alunoUsuarioId = (int)($_POST['aluno_usuario_id'] ?? 0);

  if ($titulo !== '' && $descricao !== '' && $alunoUsuarioId > 0) {
    $novaId = createAdvertencia($titulo, $descricao);
    vincularAlunoAdvertencia($novaId, $alunoUsuarioId);
  }
}

/* Edição (título/descrição) */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (($_POST['__act'] ?? '') === 'update_advertencia')) {
  $id = (int)$_POST['advertencia_id'];
  $titulo = trim($_POST['titulo']);
  $descricao = trim($_POST['descricao']);
  if ($id > 0 && $titulo !== '' && $descricao !== '') {
    updateAdvertencia($id, $titulo, $descricao);
  }
}

/* Exclusão */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_advertencia_id'])) {
  deleteAdvertencia($_POST['delete_advertencia_id']);
}

/* Vinculações em massa */


/* Dados para render */
$advertencias = readAdvertencias();


$alunosParaSelect = listAlunosParaSelect();

?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool — Advertências</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <main class="container py-4">

      <div class="row g-4">

        <!-- Criar nova advertência -->
        <div class="col-12 col-lg-4">
          <div class="card h-100">
            <div class="card-body">
              <h2 class="h6 mb-3">Criar nova advertência</h2>

              <form method="post">
                <input type="hidden" name="__act" value="create_advertencia">

                <div class="mb-3">
                  <label class="form-label">Título</label>
                  <input name="titulo" class="form-control" required>
                </div>

                <div class="mb-3">
                  <label class="form-label">Descrição</label>
                  <textarea name="descricao" class="form-control" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                  <label class="form-label">Aluno</label>
                  <select name="aluno_usuario_id" class="form-select" required>
                    <option value="" disabled selected>Selecione o aluno</option>
                    <?php foreach ($alunosParaSelect as $al): ?>
                      <option value="<?= htmlspecialchars($al['aluno_id']) ?>">
                        <?= htmlspecialchars($al['nome']) ?> (#<?= htmlspecialchars($al['aluno_id']) ?>)
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <button class="btn btn-primary w-100">Salvar</button>
              </form>

            </div>
          </div>
        </div>

        <!-- Lista de advertências -->
        <div class="col-12 col-lg-8">
          <div class="card">
            <div class="card-body">
              <h2 class="h6 mb-3">Advertências</h2>

              <?php if (empty($advertencias)): ?>
                <div class="alert alert-secondary mb-0">Nenhuma advertência cadastrada.</div>
              <?php else: ?>

                <div class="table-responsive mb-3">
                  <table class="table table-striped align-middle mb-0">
                    <thead>
                      <tr>
                        <th style="min-width:180px;">Título</th>
                        <th style="min-width:260px;">Descrição</th>
                        <th style="min-width:220px;">Aluno(s)</th>
                        <th class="text-end">Ações</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php foreach ($advertencias as $advertencia): ?>
                        <tr>
                          <td><?= htmlspecialchars($advertencia['titulo']) ?></td>
                          <td class="text-break"><?= nl2br(htmlspecialchars($advertencia['descricao'])) ?></td>
                          <td class="text-break">
                            <?= htmlspecialchars($advertencia['alunos']) ?>
                          </td>
                          <td class="text-end">
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalEditar<?= $advertencia['id'] ?>">
                              Editar
                            </button>

                            <form method="post" class="d-inline">
                              <input type="hidden" name="delete_advertencia_id" value="<?= htmlspecialchars($advertencia['id']) ?>">
                              <button class="btn btn-sm btn-outline-danger">Excluir</button>
                            </form>
                          </td>
                        </tr>

                        <!-- Collapse de vinculação -->
                        <tr class="bg-light">
                          <td colspan="4" class="p-0">
                            <div class="collapse" id="collapseVinculos<?= $advertencia['id'] ?>">
                              <div class="p-3 border-top">
                                <?php
                                  $alunos = readAdvertencias();
                                  if (empty($alunos)) {
                                    echo '<div class="alert alert-warning mb-0">Nenhum aluno encontrado.</div>';
                                  } else {
                                ?>

                                <form method="post">
                                  <input type="hidden" name="__act" value="save_vinculos">
                                  <input type="hidden" name="advertencia_id" value="<?= htmlspecialchars($advertencia['id']) ?>">

                                  <div class="table-responsive">
                                    <table class="table table-sm align-middle">
                                      <thead>
                                        <tr>
                                          <th style="min-width:260px">Aluno</th>
                                          <th style="width:160px">Vinculado</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php foreach ($alunos as $aluno): ?>
                                          <tr>
                                            <td>
                                              <?= htmlspecialchars($aluno['nome']) ?>
                                              <span class="text-muted">(#<?= htmlspecialchars($aluno['aluno_id']) ?>)</span>
                                            </td>
                                            <td>
                                              <input type="hidden" name="vinculos[<?= htmlspecialchars($aluno['aluno_id']) ?>]" value="0">
                                              <input
                                                type="checkbox"
                                                name="vinculos[<?= htmlspecialchars($aluno['aluno_id']) ?>]"
                                                value="1"
                                                <?= (int)$aluno['vinculado'] === 1 ? 'checked' : '' ?>
                                              >
                                            </td>
                                          </tr>
                                        <?php endforeach; ?>
                                      </tbody>
                                    </table>
                                  </div>

                                  <div class="d-flex flex-wrap gap-2">
                                    <button class="btn btn-success">Salvar vínculos</button>
                                  </div>
                                </form>

                                <?php } ?>
                              </div>
                            </div>
                          </td>
                        </tr>

                        <!-- Modal de edição -->
                        <div class="modal fade" id="modalEditar<?= $advertencia['id'] ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <form method="post">
                                <input type="hidden" name="__act" value="update_advertencia">
                                <input type="hidden" name="advertencia_id" value="<?= htmlspecialchars($advertencia['id']) ?>">
                                <div class="modal-header">
                                  <h5 class="modal-title">Editar advertência</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <div class="mb-3">
                                    <label class="form-label">Título</label>
                                    <input name="titulo" class="form-control" value="<?= htmlspecialchars($advertencia['titulo']) ?>" required>
                                  </div>
                                  <div class="mb-3">
                                    <label class="form-label">Descrição</label>
                                    <textarea name="descricao" class="form-control" rows="4" required><?= htmlspecialchars($advertencia['descricao']) ?></textarea>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                  <button class="btn btn-primary">Salvar alterações</button>
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
</body>
</html>
