<?php
declare(strict_types=1);

require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';
// opcional: require_once __DIR__ . '/../../api/admin.php';

require_login();
require_role('admin');

// NÃO cheque admin_id; use só informações básicas de sessão
$userName = $_SESSION['user_name'] ?? 'Admin';


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OlwSchool - Admin</title>
</head>
<body>

<h1>Admin Dashboard</h1>
<p>Bem-vindo à área administrativa.</p>
<p>Usuário: <strong><?= htmlspecialchars($userName) ?></strong></p>

</body>
</html>