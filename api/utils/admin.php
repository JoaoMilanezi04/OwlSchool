<?php




require_once __DIR__ . '/../../db/conexao.php';




function listAlunosParaSelect() {
    global $conn;
    $sql = "
        SELECT
            aluno.usuario_id AS aluno_id,
            usuario.nome
        FROM aluno
        INNER JOIN usuario ON usuario.id = aluno.usuario_id
        ORDER BY usuario.nome ASC, aluno.usuario_id ASC
    ";
    $resultado = $conn->query($sql);

    $alunos = [];
    while ($linha = $resultado->fetch_assoc()) {
        $alunos[] = $linha;
    }
    return $alunos;
}
