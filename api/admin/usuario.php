<?php



require_once __DIR__ . '/../../db/conexao.php';





function listUsuarios() {
  global $conn;

  $sql = "
    SELECT
      usuario.id,
      usuario.nome,
      usuario.email,
      usuario.tipo_usuario,
      professor.telefone   AS tel_prof,
      responsavel.telefone AS tel_resp
    FROM usuario
    LEFT JOIN professor   ON professor.usuario_id   = usuario.id
    LEFT JOIN responsavel ON responsavel.usuario_id = usuario.id
    ORDER BY usuario.id ASC
  ";

  $resultado = $conn->query($sql);

  $usuarios = [];
  if ($resultado) {
    while ($linha = $resultado->fetch_assoc()) {
      $usuarios[] = $linha;
    }
  }
  return $usuarios;
}








function getUsuario($usuarioId) {
  global $conn;

  $sql = "SELECT usuario.id, usuario.nome, usuario.email, usuario.tipo_usuario,
                 professor.telefone AS telefone_professor, responsavel.telefone AS telefone_responsavel
            FROM usuario
       LEFT JOIN professor  ON professor.usuario_id  = usuario.id
       LEFT JOIN responsavel ON responsavel.usuario_id = usuario.id
           WHERE usuario.id = $usuarioId";
  $resultado = $conn->query($sql);

  if ($resultado && $resultado->num_rows > 0) {
    return $resultado->fetch_assoc();
  }
  return null;
}







function createUsuario($nome, $email, $senha, $tipoUsuario, $telefone = null) {
  global $conn;

  $sqlUsuario = "INSERT INTO usuario (nome, email, senha, tipo_usuario)
              VALUES ('$nome', '$email', '$senha', '$tipoUsuario')";
  $usuarioCriado = $conn->query($sqlUsuario);
  if (!$usuarioCriado) return null;

  $novoUsuarioId = $conn->insert_id;

  if ($tipoUsuario === 'aluno') {
    $sqlAluno = "INSERT INTO aluno (usuario_id, faltas, advertencia)
             VALUES ($novoUsuarioId, 0, NULL)";
    $conn->query($sqlAluno);
  }

  if ($tipoUsuario === 'professor') {
    if (!$telefone) return null;
    $sqlProfessor = "INSERT INTO professor (usuario_id, telefone)
             VALUES ($novoUsuarioId, '$telefone')";
    $conn->query($sqlProfessor);
  }

  if ($tipoUsuario === 'responsavel') {
    if (!$telefone) return null;
    $sqlResponsavel = "INSERT INTO responsavel (usuario_id, telefone)
             VALUES ($novoUsuarioId, '$telefone')";
    $conn->query($sqlResponsavel);
  }

  return $novoUsuarioId;
}







function updateUsuario($usuarioId, $nome, $email, $senhaOpcional, $tipoUsuario, $telefoneOpcional = null) {
  global $conn;

  if ($senhaOpcional !== '') {
    $sqlAtualizar = "UPDATE usuario
                SET nome = '$nome',
                    email = '$email',
                    senha = '$senhaOpcional',
                    tipo_usuario = '$tipoUsuario'
              WHERE id = $usuarioId";
  } else {
    $sqlAtualizar = "UPDATE usuario
                SET nome = '$nome',
                    email = '$email',
                    tipo_usuario = '$tipoUsuario'
              WHERE id = $usuarioId";
  }
  $usuarioAtualizado = $conn->query($sqlAtualizar);
  if (!$usuarioAtualizado) return false;

  $conn->query("DELETE FROM aluno WHERE usuario_id = $usuarioId");
  $conn->query("DELETE FROM professor WHERE usuario_id = $usuarioId");
  $conn->query("DELETE FROM responsavel WHERE usuario_id = $usuarioId");

  if ($tipoUsuario === 'aluno') {
    $sqlAluno = "INSERT INTO aluno (usuario_id, faltas, advertencia)
             VALUES ($usuarioId, 0, NULL)";
    $conn->query($sqlAluno);
  }

  if ($tipoUsuario === 'professor') {
    if (!$telefoneOpcional) return false;
    $sqlProfessor = "INSERT INTO professor (usuario_id, telefone)
             VALUES ($usuarioId, '$telefoneOpcional')";
    $conn->query($sqlProfessor);
  }

  if ($tipoUsuario === 'responsavel') {
    if (!$telefoneOpcional) return false;
    $sqlResponsavel = "INSERT INTO responsavel (usuario_id, telefone)
             VALUES ($usuarioId, '$telefoneOpcional')";
    $conn->query($sqlResponsavel);
  }

  return true;
}







function deleteUsuario($usuarioId) {
  global $conn;

  $conn->query("DELETE FROM aluno WHERE usuario_id = $usuarioId");
  $conn->query("DELETE FROM professor WHERE usuario_id = $usuarioId");
  $conn->query("DELETE FROM responsavel WHERE usuario_id = $usuarioId");
  $usuarioExcluido = $conn->query("DELETE FROM usuario WHERE id = $usuarioId");

  return $usuarioExcluido ? true : false;
}
