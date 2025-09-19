<?php

require_once __DIR__ . '/../../includes/auth.php';

require_login();
require_role('responsavel');

$userId   = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>OlwSchool - Responsável</title>
</head>
<body>

  <h1>Bem-vindo, <strong><?= $userName ?></strong>!</h1>
  <p>Aqui estão suas informações.</p>

</body>
</html>
