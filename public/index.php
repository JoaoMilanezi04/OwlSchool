<?php
$erro = $_GET['erro'] ?? null;
$msg = ($erro === 'usuario') ? 'Usuário não encontrado.' :
       (($erro === 'senha') ? 'Senha incorreta.' :
       (($erro === 'tipo') ? 'Tipo de usuário inválido.' : null));
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>OlwSchool - Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background:#f8f9fa; }
    .login-card { width:500px; margin:60px auto; border-radius:1rem; box-shadow:0 4px 10px rgba(0,0,0,.1); }
  </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
  <div class="login-card card">
    <div class="card-body">
      <h1 class="h4 mb-3 text-center">🦉 OlwSchool</h1>
      <p class="text-muted text-center">Acesse sua conta</p>

      <?php if ($msg): ?>
        <div class="alert alert-danger d-flex align-items-center" role="alert">
          <span class="me-2">❌</span> <?= $msg ?>
        </div>
      <?php endif; ?>

      <form action="../api/auth.php" method="POST">
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" placeholder="Digite seu email" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Senha</label>
          <input type="password" name="senha" class="form-control" placeholder="Digite sua senha" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
      </form>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
