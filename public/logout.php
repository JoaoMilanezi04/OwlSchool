<?php
// public/logout.php — versão simples demo

session_start();      // inicia sessão (mesmo se já estiver ativa)
session_unset();      // limpa variáveis
session_destroy();    // encerra a sessão

header("Location: index.php"); // volta pro login
exit;
