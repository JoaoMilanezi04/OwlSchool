<?php
$erro = $_GET['erro'] ?? null;
$email_prefill = $_GET['email'] ?? '';

function msgErro($e) {
  return match($e) {
    'usuario' => 'Usuário não encontrado.',
    'senha'   => 'Senha incorreta.',
    'tipo'    => 'Tipo de usuário inválido. Contate o admin.',
    default   => null,
  };
}
?>
<!-- Home pública (login rápido + mascote) -->

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OlwSchool - Login</title>

  <!-- Bootstrap via CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">




  <style>
    body {
      background: #f8f9fa; /* cinza claro */
    }
    .login-card {
      width: 500px;
      margin: 50px auto;
      border-radius: 1rem;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
  </style>



</head>
<body>




<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
  <div class="login-card card">
    <div class="card-body">
      <h1 class="h4 mb-3 text-center">🦉 OlwSchool</h1>
      <p class="text-muted text-center">Acesse sua conta</p>

      <!-- Mensagem de erro -->
      <?php if ($erro && ($m = msgErro($erro))): ?>
        <div class="alert alert-danger d-flex align-items-center" role="alert">
          <span class="me-2">❌</span> <?= htmlspecialchars($m) ?>
        </div>
      <?php endif; ?>

      <!-- Formulário de Login -->
      <form action="../api/auth.php" method="POST">
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control"
                 placeholder="Digite seu email"
                 value="<?= htmlspecialchars($email_prefill) ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Senha</label>
          <input type="password" name="senha" class="form-control" placeholder="Digite sua senha" required>
        </div>


        <button type="submit" class="btn btn-primary w-100">Entrar</button>
      </form>

      <!-- Links extras -->
      <div class="mt-3 text-center">
        <a href="#">Esqueci minha senha</a>
      </div>
    </div>
  </div>
</div>




<?php include __DIR__ . '/../partials/footer.php'; ?>



<!-- CSS do cursor -->
<link rel="stylesheet" href="assets/css/cursor.css">

<!-- JS do cursor -->
<script src="assets/js/cursor.js" defer></script>




<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>





<!-- Remove parâmetro de erro da URL ao carregar -->
<script>
  if (window.location.search.includes('erro=')) {
    const url = new URL(window.location);
    url.searchParams.delete('erro');
    url.searchParams.delete('email');
    window.history.replaceState({}, '', url);
  }
</script>





</body>
</html>
