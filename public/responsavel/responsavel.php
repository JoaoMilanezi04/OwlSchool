<?php
declare(strict_types=1);

require_once __DIR__ . '/../../includes/auth.php';       // helpers de autenticação
require_once __DIR__ . '/../../db/conexao.php';          // conexão com o banco ($conn)
require_once __DIR__ . '/../../api/responsaveis.php';    // se houver helpers específicos

require_login();                         // bloqueia não logados
require_role('responsavel');             // exige papel "responsavel"

$respId   = session_entity_id('responsavel_id');         // id do responsável na sessão
$userName = $_SESSION['user_name'] ?? 'Responsável';     // nome do usuário (fallback)
if ($respId === null) {                                   // sem vínculo de responsável?
    header('Location: ../../public/index.php?erro=usuario'); // volta ao login com erro
    exit;                                                 // encerra execução
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">                                    <!-- charset -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- responsivo -->
  <title>OlwSchool - Responsável</title>
</head>
<body>

  <h1>Bem-vindo, <strong><?= htmlspecialchars($userName) ?></strong>!</h1> <!-- exibe nome com escape -->
  <p>Aqui estão suas informações:</p>

</body>
</html>
