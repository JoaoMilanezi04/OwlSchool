<?php

require_once __DIR__ . '/../../includes/auth.php';

require_login();
require_role('admin');

$userName = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>OlwSchool - Admin</title>
</head>
<body>

<h1>Admin Dashboard</h1>
<p>Bem-vindo, <strong><?= $userName ?></strong></p>

</body>
</html>
