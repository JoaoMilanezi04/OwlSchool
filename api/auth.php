<?php

require_once __DIR__ . '/../db/conexao.php';
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success' => false, 'message' => 'Método inválido.']);
  exit;
}

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

$sql = "
  SELECT id,
         nome,
         tipo_usuario
    FROM usuario
   WHERE email = '$email'
     AND senha = '$senha'
";

$resultado = $conn->query($sql);
$usuario   = $resultado ? $resultado->fetch_assoc() : null;

if (!$usuario) {
  echo json_encode(['success' => false, 'message' => 'Usuário ou senha incorretos.']);
  exit;
}

$_SESSION['user_id']      = $usuario['id'];
$_SESSION['user_name']    = $usuario['nome'];
$_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

echo json_encode([
  'success' => true,
  'message' => 'Login realizado com sucesso.',
  'usuario' => [
    'id' => $usuario['id'],
    'nome' => $usuario['nome'],
    'tipo_usuario' => $usuario['tipo_usuario']
  ]
]);

exit;

?>
