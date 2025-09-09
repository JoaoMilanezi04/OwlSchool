<?php
declare(strict_types=1);                              // tipagem estrita (segurança básica)

$erro = $_GET['erro'] ?? null;                        // parâmetro de erro (usuario/senha/tipo)
$email_prefill = $_GET['email'] ?? '';                // e-mail para preencher no form (se veio na URL)

/** Mapeia a chave de erro para a mensagem de exibição */
function msgErro(string $e): ?string {                // retorna string ou null
  return match($e) {
    'usuario' => 'Usuário não encontrado.',           // e-mail não existe
    'senha'   => 'Senha incorreta.',                  // senha inválida
    'tipo'    => 'Tipo de usuário inválido. Contate o admin.', // sem vínculo/tipo errado
    default   => null,                                // sem mensagem
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
    body { background: #f8f9fa; }                     /* cinza claro */
    .login-card {
      width: 500px;                                   /* largura fixa suave */
      margin: 50px auto;                              /* centraliza verticalmente com espaço */
      border-radius: 1rem;                            /* cantos arredondados */
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);         /* leve sombra */
    }
  </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
  <div class="login-card card">
    <div class="card-body">
      <h1 class="h4 mb-3 text-center">🦉 OlwSchool</h1>       <!-- marca/mascote -->
      <p class="text-muted text-center">Acesse sua conta</p>  <!-- subtítulo -->

      <!-- Mensagem de erro -->
      <?php if ($erro && ($m = msgErro($erro))): ?>           <!-- só mostra se houver erro mapeado -->
        <div class="alert alert-danger d-flex align-items-center" role="alert">
          <span class="me-2">❌</span> <?= htmlspecialchars($m) ?> <!-- escapa a msg -->
        </div>
      <?php endif; ?>

      <!-- Formulário de Login -->
      <form action="../api/auth.php" method="POST">           <!-- envia para autenticação -->
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control"
                 placeholder="Digite seu email"
                 value="<?= htmlspecialchars($email_prefill) ?>" required> <!-- preenche com e-mail da URL -->
        </div>

        <div class="mb-3">
          <label class="form-label">Senha</label>
          <input type="password" name="senha" class="form-control" placeholder="Digite sua senha" required> <!-- campo de senha -->
        </div>

        <button type="submit" class="btn btn-primary w-100">Entrar</button> <!-- CTA -->
      </form>

      <!-- Links extras -->
      <div class="mt-3 text-center">
        <a href="#">Esqueci minha senha</a>                     <!-- link placeholder -->
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>          <!-- rodapé padrão do site -->

<!-- CSS do cursor -->
<link rel="stylesheet" href="assets/css/cursor.css">           <!-- efeito de cursor (opcional) -->

<!-- JS do cursor -->
<script src="assets/js/cursor.js" defer></script>              <!-- script do cursor (adiado) -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Remove parâmetro de erro da URL ao carregar -->
<script>
  if (window.location.search.includes('erro=')) {              // se houver ?erro= na URL
    const url = new URL(window.location);                      // cria objeto URL
    url.searchParams.delete('erro');                           // remove erro
    url.searchParams.delete('email');                          // remove email prefill
    window.history.replaceState({}, '', url);                  // troca URL sem recarregar
  }
</script>

</body>
</html>
