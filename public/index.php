<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool — Login</title>

  <!-- ============================== -->
  <!-- Bootstrap -->
  <!-- ============================== -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- ============================== -->
  <!-- CSS próprio -->
  <!-- ============================== -->
  <link rel="stylesheet" href="/owl-school/public/assets/css/index.css">
</head>

<body class="bg-light">

  <!-- ============================== -->
  <!-- Conteúdo principal -->
  <!-- ============================== -->
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="login-card card shadow-sm border-0">
      <div class="card-body p-4">

        <!-- Título e subtítulo -->
        <h1 class="h4 mb-1 text-center brand">🦉 OwlSchool</h1>
        <p class="text-center text-muted mb-4">Acesse sua conta</p>

        <!-- Alerta -->
        <div id="alertArea" class="alert alert-danger d-none" role="alert"></div>

        <!-- Formulário de login -->
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

  <!-- ============================== -->
  <!-- Rodapé -->
  <!-- ============================== -->
  <?php include __DIR__ . '/../partials/footer.php'; ?>

  <!-- ============================== -->
  <!-- Scripts -->
  <!-- ============================== -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/owl-school/public/assets/js/api/auth.js"></script>

</body>
</html>
