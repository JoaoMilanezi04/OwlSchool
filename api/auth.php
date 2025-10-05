<?php


require_once __DIR__ . '/../db/conexao.php';
session_start();




$email = $_POST['email'];
$senha = $_POST['senha'];




$sql = "
  SELECT id,
         nome,
         tipo_usuario
    FROM usuario
   WHERE email = '$email'
     AND senha = '$senha'
";

$result = $conn->query($sql);
$user   = $result->fetch_assoc();



if (!$user) {
  header('Location: ../public/index.php?erro=usuario');
  exit;
}



$_SESSION['user_id']      = $user['id'];
$_SESSION['user_name']    = $user['nome'];
$_SESSION['tipo_usuario'] = $user['tipo_usuario'];




switch ($user['tipo_usuario']) {
  case 'aluno':       header('Location: ../public/aluno/aluno.php'); break;
  case 'professor':   header('Location: ../public/professor/professor.php'); break;
  case 'responsavel': header('Location: ../public/responsavel/responsavel.php'); break;
  case 'admin':       header('Location: ../public/admin/admin.php'); break;
  default:            header('Location: ../public/index.php?erro=tipo'); break;
}
exit;
