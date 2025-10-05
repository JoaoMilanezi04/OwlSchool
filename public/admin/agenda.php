<?php



require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';
require_once __DIR__ . '/../../api/admin/agenda.php';




require_login();
require_role('admin');




$msg  = null;
$DAYS = ['segunda', 'terca', 'quarta', 'quinta', 'sexta'];




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $act = $_POST['__act'] ?? '';

  if ($act === 'create') {
    $ok  = criarHorario($_POST['dia_semana'] ?? '', $_POST['inicio'] ?? '', $_POST['fim'] ?? '', $_POST['disciplina'] ?? '');
    $msg = $ok ? 'Horário criado.' : 'Erro ao criar horário.';
  } elseif ($act === 'update') {
    $ok  = atualizarHorario((int)($_POST['id'] ?? 0), $_POST['dia_semana'] ?? '', $_POST['inicio'] ?? '', $_POST['fim'] ?? '', $_POST['disciplina'] ?? '');
    $msg = $ok ? 'Horário atualizado.' : 'Erro ao atualizar.';
  } elseif ($act === 'delete') {
    $ok  = deletarHorario((int)($_POST['id'] ?? 0));
    $msg = $ok ? 'Horário excluído.' : 'Erro ao excluir.';
  }
}

$grade = [];
foreach ($DAYS as $d) $grade[$d] = listarHorarios($d);




?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool — Horários</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{background:#f8f9fa}
    .card{border-radius:14px}
    .hidden{display:none}
  </style>
</head>

<body>

  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="container py-4" style="max-width:1000px">

    <?php if ($msg): ?>
      <div class="alert alert-info"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <h1 class="h5 mb-3">OlwSchool — Horários</h1>

    <div class="row g-4">
      <?php foreach ($DAYS as $dia): ?>
        <div class="col-12">
          <div class="card shadow-sm">
            <div class="card-body">

              <h2 class="h6 mb-3"><?= ucfirst($dia) ?></h2>

              <div class="table-responsive">
                <table class="table align-middle">
                  <thead>
                    <tr>
                      <th>Início</th>
                      <th>Fim</th>
                      <th>Disciplina</th>
                      <th class="text-end">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!$grade[$dia]): ?>
                      <tr><td colspan="4" class="text-muted">Sem horários cadastrados.</td></tr>
                    <?php else: foreach ($grade[$dia] as $h): ?>
                      <tr>
                        <td><?= htmlspecialchars(substr($h['inicio'], 0, 5)) ?></td>
                        <td><?= htmlspecialchars(substr($h['fim'], 0, 5)) ?></td>
                        <td><?= htmlspecialchars($h['disciplina']) ?></td>
                        <td class="text-end">
                          <button
                            class="btn btn-sm btn-outline-primary"
                            onclick="openEdit(<?= (int)$h['id'] ?>,'<?= $dia ?>','<?= substr($h['inicio'], 0, 5) ?>','<?= substr($h['fim'], 0, 5) ?>','<?= htmlspecialchars(addslashes($h['disciplina'])) ?>')">
                            Editar
                          </button>
                          <form method="post" class="d-inline" onsubmit="return confirm('Excluir este horário?')">
                            <input type="hidden" name="__act" value="delete">
                            <input type="hidden" name="id" value="<?= (int)$h['id'] ?>">
                            <button class="btn btn-sm btn-outline-danger">Excluir</button>
                          </form>
                        </td>
                      </tr>
                    <?php endforeach; endif; ?>
                  </tbody>
                </table>
              </div>

              <div id="editBox-<?= $dia ?>" class="border rounded p-3 mb-3 hidden">
                <h3 class="h6 mb-3">Editar horário</h3>
                <form method="post" class="row g-2">
                  <input type="hidden" name="__act" value="update">
                  <input type="hidden" name="id" id="ed-id-<?= $dia ?>">
                  <input type="hidden" name="dia_semana" value="<?= $dia ?>">
                  <div class="col-6 col-md-3">
                    <label class="form-label">Início</label>
                    <input name="inicio" id="ed-inicio-<?= $dia ?>" type="time" class="form-control" required>
                  </div>
                  <div class="col-6 col-md-3">
                    <label class="form-label">Fim</label>
                    <input name="fim" id="ed-fim-<?= $dia ?>" type="time" class="form-control" required>
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="form-label">Disciplina</label>
                    <input name="disciplina" id="ed-disciplina-<?= $dia ?>" class="form-control" required>
                  </div>
                  <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary">Atualizar</button>
                    <button type="button" class="btn btn-light" onclick="closeEdit('<?= $dia ?>')">Cancelar</button>
                  </div>
                </form>
              </div>

              <h3 class="h6">Adicionar horário</h3>
              <form method="post" class="row g-2" autocomplete="off">
                <input type="hidden" name="__act" value="create">
                <input type="hidden" name="dia_semana" value="<?= $dia ?>">
                <div class="col-6 col-md-3">
                  <label class="form-label">Início</label>
                  <input name="inicio" type="time" class="form-control" required>
                </div>
                <div class="col-6 col-md-3">
                  <label class="form-label">Fim</label>
                  <input name="fim" type="time" class="form-control" required>
                </div>
                <div class="col-12 col-md-6">
                  <label class="form-label">Disciplina</label>
                  <input name="disciplina" class="form-control" placeholder="Ex.: Matemática" required>
                </div>
                <div class="col-12">
                  <button class="btn btn-success">Salvar</button>
                </div>
              </form>

            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function openEdit(id, dia, inicio, fim, disciplina) {
      document.getElementById('ed-id-' + dia).value = id;
      document.getElementById('ed-inicio-' + dia).value = inicio;
      document.getElementById('ed-fim-' + dia).value = fim;
      document.getElementById('ed-disciplina-' + dia).value = disciplina.replaceAll("\\'", "'");
      document.getElementById('editBox-' + dia).classList.remove('hidden');
      document.getElementById('editBox-' + dia).scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function closeEdit(dia) {
      document.getElementById('editBox-' + dia).classList.add('hidden');
    }
  </script>
</body>
</html>
