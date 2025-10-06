<?php



require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';
require_once __DIR__ . '/../../api/admin/usuario.php';





require_login();
require_role('admin');




$mensagem = null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $acao = $_POST['__act'] ?? '';

  if ($acao === 'create') {
    $nome      = trim($_POST['nome'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $senha     = trim($_POST['senha'] ?? '');
    $tipo      = $_POST['tipo_usuario'] ?? 'aluno';
    $telefone  = trim($_POST['telefone'] ?? '');
    $idNovo    = createUsuario($nome, $email, $senha, $tipo, $telefone !== '' ? $telefone : null);
    $mensagem  = $idNovo ? 'Usuário criado.' : 'Erro ao criar usuário.';
  }

  if ($acao === 'update') {
    $usuarioId = (int)($_POST['id'] ?? 0);
    $nome      = trim($_POST['nome'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $senha     = trim($_POST['senha'] ?? '');
    $tipo      = $_POST['tipo_usuario'] ?? 'aluno';
    $telefone  = trim($_POST['telefone'] ?? '');
    $sucesso   = updateUsuario($usuarioId, $nome, $email, $senha, $tipo, $telefone !== '' ? $telefone : null);
    $mensagem  = $sucesso ? 'Usuário atualizado.' : 'Erro ao atualizar.';
  }

  if ($acao === 'delete') {
    $usuarioId = (int)($_POST['id'] ?? 0);
    $sucesso   = deleteUsuario($usuarioId);
    $mensagem  = $sucesso ? 'Usuário excluído.' : 'Erro ao excluir.';
  }
}




$lista = listUsuarios();




?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool — Usuários</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .hidden { display: none; }
  </style>
</head>
<body class="bg-light">
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="flex-grow-1" style="margin-left: 220px;">
    <div class="container py-4" style="max-width:1100px">

      <?php if ($mensagem): ?>
        <div class="alert alert-info"><?= htmlspecialchars($mensagem) ?></div>
      <?php endif; ?>

      <div class="row g-4">
        <div class="col-12">
          <div class="card shadow-sm">
            <div class="card-body">


              <form method="post" class="row g-3" autocomplete="off">
                <input type="hidden" name="__act" value="create">

                <div class="col-md-4">
                  <label class="form-label">Nome</label>
                  <input name="nome" class="form-control" required>
                </div>

                <div class="col-md-4">
                  <label class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" required>
                </div>

                <div class="col-md-4">
                  <label class="form-label">Senha</label>
                  <input type="text" name="senha" class="form-control" required>
                </div>

                <div class="col-md-4">
                  <label class="form-label">Tipo</label>
                  <select name="tipo_usuario" id="tipo-create" class="form-select" required>
                    <option value="aluno">aluno</option>
                    <option value="professor">professor</option>
                    <option value="responsavel">responsavel</option>
                    <option value="admin">admin</option>
                  </select>
                </div>

                <div id="tel-create-wrap" class="col-md-4 hidden">
                  <label class="form-label">Telefone (professor/responsável)</label>
                  <input name="telefone" id="tel-create" class="form-control" placeholder="(41) 99999-0000">
                </div>

                <div class="col-12">
                  <button class="btn btn-primary">Salvar</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="card shadow-sm">
            <div class="card-body">
              <h2 class="h5 mb-3">Lista de usuários</h2>

              <div class="table-responsive">
                <table class="table align-middle">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nome</th>
                      <th>Email</th>
                      <th>Tipo</th>
                      <th>Telefone</th>
                      <th class="text-end">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($lista as $usuario):
                      $telefone = $usuario['tipo_usuario'] === 'professor'
                        ? ($usuario['tel_prof'] ?? '')
                        : ($usuario['tipo_usuario'] === 'responsavel' ? ($usuario['tel_resp'] ?? '') : '');
                    ?>
                    <tr>
                      <td><?= (int)$usuario['id'] ?></td>
                      <td><?= htmlspecialchars($usuario['nome']) ?></td>
                      <td><?= htmlspecialchars($usuario['email']) ?></td>
                      <td><span class="badge bg-secondary"><?= htmlspecialchars($usuario['tipo_usuario']) ?></span></td>
                      <td><?= htmlspecialchars($telefone) ?></td>
                      <td class="text-end">
                        <button
                          class="btn btn-sm btn-outline-primary"
                          onclick="openEdit(
                            <?= (int)$usuario['id'] ?>,
                            '<?= htmlspecialchars(addslashes($usuario['nome'])) ?>',
                            '<?= htmlspecialchars(addslashes($usuario['email'])) ?>',
                            '<?= htmlspecialchars($usuario['tipo_usuario']) ?>',
                            '<?= htmlspecialchars(addslashes($telefone)) ?>'
                          )">
                          Editar
                        </button>

                        <form method="post" class="d-inline" onsubmit="return confirm('Excluir usuário #<?= (int)$usuario['id'] ?>?')">
                          <input type="hidden" name="__act" value="delete">
                          <input type="hidden" name="id" value="<?= (int)$usuario['id'] ?>">
                          <button class="btn btn-sm btn-outline-danger">Excluir</button>
                        </form>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>

              <div id="editBox" class="border rounded p-3 mt-4 hidden">
                <h3 class="h6 mb-3">Editar usuário</h3>

                <form method="post" class="row g-3">
                  <input type="hidden" name="__act" value="update">
                  <input type="hidden" name="id" id="edit-id">

                  <div class="col-md-4">
                    <label class="form-label">Nome</label>
                    <input name="nome" id="edit-nome" class="form-control" required>
                  </div>

                  <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" id="edit-email" class="form-control" required>
                  </div>

                  <div class="col-md-4">
                    <label class="form-label">Senha (deixe vazio para manter)</label>
                    <input type="text" name="senha" id="edit-senha" class="form-control" placeholder="••••••">
                  </div>

                  <div class="col-md-4">
                    <label class="form-label">Tipo</label>
                    <select name="tipo_usuario" id="edit-tipo" class="form-select" required>
                      <option value="aluno">aluno</option>
                      <option value="professor">professor</option>
                      <option value="responsavel">responsavel</option>
                      <option value="admin">admin</option>
                    </select>
                  </div>

                  <div id="edit-tel-wrap" class="col-md-4 hidden">
                    <label class="form-label">Telefone (professor/responsável)</label>
                    <input name="telefone" id="edit-telefone" class="form-control" placeholder="(41) 99999-0000">
                  </div>

                  <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary">Atualizar</button>
                    <button type="button" class="btn btn-light" onclick="closeEdit()">Cancelar</button>
                  </div>
                </form>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script>
    const tipoCreate    = document.getElementById('tipo-create');
    const telCreateWrap = document.getElementById('tel-create-wrap');
    const telCreate     = document.getElementById('tel-create');

    function toggleTelCreate() {
      const precisa = (tipoCreate.value === 'professor' || tipoCreate.value === 'responsavel');
      telCreateWrap.classList.toggle('hidden', !precisa);
      telCreate.required = precisa;
    }
    tipoCreate.addEventListener('change', toggleTelCreate);
    toggleTelCreate();

    const editBox       = document.getElementById('editBox');
    const editId        = document.getElementById('edit-id');
    const editNome      = document.getElementById('edit-nome');
    const editEmail     = document.getElementById('edit-email');
    const editSenha     = document.getElementById('edit-senha');
    const editTipo      = document.getElementById('edit-tipo');
    const editTelWrap   = document.getElementById('edit-tel-wrap');
    const editTelefone  = document.getElementById('edit-telefone');

    function toggleTelEdit() {
      const precisa = (editTipo.value === 'professor' || editTipo.value === 'responsavel');
      editTelWrap.classList.toggle('hidden', !precisa);
      editTelefone.required = precisa;
    }
    editTipo.addEventListener('change', toggleTelEdit);

    function openEdit(id, nome, email, tipo, telefone) {
      editId.value = id;
      editNome.value = nome.replaceAll("\\'", "'");
      editEmail.value = email.replaceAll("\\'", "'");
      editSenha.value = '';
      editTipo.value = tipo;
      editTelefone.value = telefone ? telefone.replaceAll("\\'", "'") : '';
      toggleTelEdit();
      editBox.classList.remove('hidden');
      editBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function closeEdit() {
      editBox.classList.add('hidden');
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
