<?php



if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}




function require_login() {
    if (empty($_SESSION['user_id'])) {
        header('Location: /public/index.php?erro=login');
        exit;
    }
}




function require_role($role) {
    if ($_SESSION['tipo_usuario'] !== $role) {
        header('Location: /public/index.php?erro=permissao');
        exit;
    }
}



?>
