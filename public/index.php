<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>OwlSchool - Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root { --card-w: 420px; }
    body { background:#f8f9fa; }
    .login-card { width: min(92vw, var(--card-w)); margin: 60px auto; border-radius:1rem; box-shadow:0 4px 12px rgba(0,0,0,.08); }
    .brand { font-weight: 700; letter-spacing:.2px; }
    .muted { color:#6c757d; }
  </style>
  <link rel="stylesheet" href="/afonso/owl-school/public/assets/css/cursor.css">
<script src="/afonso/owl-school/public/assets/js/cursor.js"></script>

</head>
<body>
<script src="/afonso/owl-school/public/assets/js/cursor.js"></script>
<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
  <div class="login-card card">
    <div class="card-body p-4">
      <h1 class="h4 mb-1 text-center brand">🦉 OwlSchool</h1>
      <p class="text-center muted mb-4">Acesse sua conta</p>


      <div id="alertArea" class="alert alert-danger d-none" role="alert"></div>

      <form id="formLogin" autocomplete="on">
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input id="email" type="email" name="email" class="form-control" placeholder="Digite seu email" required autofocus>
        </div>

        <div class="mb-3">
          <label class="form-label">Senha</label>
          <input id="senha" type="password" name="senha" class="form-control" placeholder="Digite sua senha" required>
        </div>

        <button id="btnEntrar" type="submit" class="btn btn-primary w-100">
          <span class="btn-text">Entrar</span>
          <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
        </button>
      </form>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/afonso/owl-school/public/assets/js/api/auth.js"></script>

</body>
</html>
