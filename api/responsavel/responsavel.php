<?php


require __DIR__ . '/../../db/conexao.php';




function getNomeFilho($responsavelId) {
    global $conn;
    $sql = "
        SELECT usuario.nome
          FROM aluno_responsavel
          JOIN aluno ON aluno.usuario_id = aluno_responsavel.aluno_id
          JOIN usuario ON usuario.id = aluno.usuario_id
         WHERE aluno_responsavel.responsavel_id = $responsavelId
    ";
    $resultado = $conn->query($sql);
    $linha = $resultado->fetch_assoc();
    return $linha['nome'];
}





function getIdFilho($responsavelId) {
    global $conn;
    $sql = "
        SELECT aluno.usuario_id AS id
          FROM aluno_responsavel
          JOIN aluno ON aluno.usuario_id = aluno_responsavel.aluno_id
         WHERE aluno_responsavel.responsavel_id = $responsavelId
        LIMIT 1
    ";
    $resultado = $conn->query($sql);
    $linha = $resultado->fetch_assoc();
    return $linha['id'];
}
