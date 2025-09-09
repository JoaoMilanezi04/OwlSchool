<?php
// owl-school/public/logout.php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); } // garante que a sessão está aberta

$_SESSION = [];        // limpa todos os dados da sessão
session_destroy();     // encerra a sessão no servidor

header("Location: ./index.php"); // redireciona para a página inicial (login)
exit;                // encerra o script
