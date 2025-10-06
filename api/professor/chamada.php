<?php


require __DIR__ . '/../../db/conexao.php';




function createChamada($data) {
    global $conn;
    $sql = "INSERT INTO chamada (data) VALUES ('$data')";
    $conn->query($sql);
    return $conn->insert_id;
}




function updateChamada($id, $data) {
    global $conn;
    $sql = "UPDATE chamada SET data = '$data' WHERE id = $id";
    $conn->query($sql);
}




function deleteChamadaById($id) {
    global $conn;
    $conn->query("DELETE FROM chamada_item WHERE chamada_id = $id");
    $conn->query("DELETE FROM chamada WHERE id = $id");
}




function listChamadas() {
    global $conn;
    $sql = "SELECT id, data FROM chamada";
    $resultado = $conn->query($sql);
    $lista = [];
    while ($linha = $resultado->fetch_assoc()) $lista[] = $linha;
    return $lista;
}




function listAlunosComStatusPorChamada($chamadaId) {
    global $conn;
    $sql = "
        SELECT
            aluno.usuario_id AS aluno_id,
            COALESCE(usuario.nome, CONCAT('Aluno #', aluno.usuario_id)) AS nome,
            chamada_item.status
        FROM aluno
        LEFT JOIN usuario ON usuario.id = aluno.usuario_id
        LEFT JOIN chamada_item ON chamada_item.aluno_id = aluno.usuario_id
                               AND chamada_item.chamada_id = $chamadaId
    ";
    $resultado = $conn->query($sql);
    $alunos = [];
    while ($linha = $resultado->fetch_assoc()) $alunos[] = $linha;
    return $alunos;
}




function setStatusAlunoNaChamada($chamadaId, $alunoId, $status) {
    global $conn;
    $sql = "
        INSERT INTO chamada_item (chamada_id, aluno_id, status)
        VALUES ($chamadaId, $alunoId, '$status')
        ON DUPLICATE KEY UPDATE status = VALUES(status)
    ";
    $conn->query($sql);
}




function saveStatusEmMassa($chamadaId, $mapStatus) {
    foreach ($mapStatus as $alunoId => $status) {
        setStatusAlunoNaChamada($chamadaId, $alunoId, $status);
    }
}
