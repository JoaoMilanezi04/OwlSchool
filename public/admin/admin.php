<?php
declare(strict_types=1);

require_once __DIR__ . '/../../includes/auth.php'; // auth helpers (require_login/require_role)
require_once __DIR__ . '/../../db/conexao.php';    // conexão com o banco ($conn)
require_once __DIR__ . '/../../api/admin.php'; // helpers específicos de admin

require_login();                // bloqueia acesso de não logados
require_role('admin');          // garante papel "admin"

$userName = $_SESSION['user_name'] ?? 'Admin'; // nome do usuário logado (fallback "Admin")
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">                                    <!-- charset padrão -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- responsivo -->
  <title>OlwSchool - Admin</title>                         <!-- título da página -->
</head>
<body>

<h1>Admin Dashboard</h1>
<p>Bem-vindo à área administrativa.</p>
<p>Usuário: <strong><?= htmlspecialchars($userName) ?></strong></p> <!-- exibe nome com escape -->

</body>
</html>
