<?php

require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode([
    'success' => false,
    'message' => 'Método inválido.'
  ]);
  exit;
}


$nome         = $_POST['nome']         ?? '';
$email        = $_POST['email']        ?? '';
$senha        = $_POST['senha']        ?? '';
$tipo_usuario = $_POST['tipo_usuario'] ?? '';
$telefone     = $_POST['telefone']     ?? '';


if (empty($nome) || empty($email) || empty($senha) || empty($tipo_usuario)) {
  echo json_encode([
    'success' => false,
    'message' => 'Campos obrigatórios ausentes.'
  ]);
  exit;
}


$stmtUsuario = $conn->prepare("
  INSERT INTO usuario (nome, email, senha, tipo_usuario)
  VALUES (?, ?, ?, ?)
");
$stmtUsuario->bind_param("ssss", $nome, $email, $senha, $tipo_usuario);


if ($stmtUsuario->execute()) {
  $novoUsuarioId = $conn->insert_id;
  $stmtUsuario->close();


  if ($tipo_usuario === 'aluno') {
    $stmtAluno = $conn->prepare("INSERT INTO aluno (usuario_id) VALUES (?)");
    $stmtAluno->bind_param("i", $novoUsuarioId);
    $stmtAluno->execute();
    $stmtAluno->close();
  }


  if ($tipo_usuario === 'professor') {
    $stmtProfessor = $conn->prepare("INSERT INTO professor (usuario_id, telefone) VALUES (?, ?)");
    $stmtProfessor->bind_param("is", $novoUsuarioId, $telefone);
    $stmtProfessor->execute();
    $stmtProfessor->close();
  }


  if ($tipo_usuario === 'responsavel') {
    $stmtResp = $conn->prepare("INSERT INTO responsavel (usuario_id, telefone) VALUES (?, ?)");
    $stmtResp->bind_param("is", $novoUsuarioId, $telefone);
    $stmtResp->execute();
    $stmtResp->close();
  }


  echo json_encode([
    'success' => true,
    'message' => 'Usuário criado com sucesso.',
    'id'      => $novoUsuarioId
  ]);

} else {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao criar usuário: ' . $stmtUsuario->error
  ]);
  $stmtUsuario->close();
}


$conn->close();
