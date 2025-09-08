<?php
declare(strict_types=1);

require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../db/conexao.php';
require_once __DIR__ . '/../../api/professores.php'; // se houver

require_login();
require_role('professor');


$profId   = session_entity_id('professor_id');
$userName = $_SESSION['user_name'] ?? 'Professor';
if ($profId === null) {
    // Se não houver id, redireciona para login
    header('Location: ../../public/index.php?erro=usuario');
    exit;
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OlwSchool - Professor</title>
</head>
<body>

    <h1>Bem-vindo, <strong><?= htmlspecialchars($userName) ?></strong>!</h1>
    <p>Aqui estão suas informações:</p>

</body>
</html>