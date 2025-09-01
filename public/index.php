<?php    
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


<?php include __DIR__ . '/../partials/navbar.php'; ?>



  <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="login-card card">
      <div class="card-body">
        <h1 class="h4 mb-3 text-center">🦉 OlwSchool</h1>
        <p class="text-muted text-center">Acesse sua conta</p>

        <!-- Formulário de Login -->
        <form>

          <div class="mb-3">
            <label class="form-label">Login (RA/CPF/Email)</label>
            <input type="text" class="form-control" placeholder="Digite seu login">
          </div>

          <div class="mb-3">
            <label class="form-label">Senha</label>
            <input type="password" class="form-control" placeholder="Digite sua senha">
          </div>

          <div class="mb-3">
            <label class="form-label">Papel</label>
            <select class="form-select">
              <option value="aluno">Aluno</option>
              <option value="responsavel">Responsável</option>
              <option value="professor">Professor</option>
              <option value="admin">Admin</option>
            </select>
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


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

