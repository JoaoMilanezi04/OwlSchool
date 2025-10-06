<?php


require __DIR__ . '/../../db/conexao.php';




function listChamadasDoAluno($alunoUsuarioId) {
    global $conn;
    $sql = "
        SELECT
            chamada.id AS chamada_id,
            chamada.data AS data,
            chamada_item.status AS status
        FROM chamada
        LEFT JOIN chamada_item
               ON chamada_item.chamada_id = chamada.id
              AND chamada_item.aluno_id = $alunoUsuarioId
    ";
    $resultado = $conn->query($sql);
    $linhas = [];
    while ($linha = $resultado->fetch_assoc()) $linhas[] = $linha;
    return $linhas;
}




function getResumoFrequencia($alunoUsuarioId) {
    global $conn;
    $sql = "
        SELECT
            COUNT(chamada.id) AS total_dias,
            SUM(CASE WHEN chamada_item.status = 'presente' THEN 1 ELSE 0 END) AS presentes
        FROM chamada
        LEFT JOIN chamada_item
               ON chamada_item.chamada_id = chamada.id
              AND chamada_item.aluno_id = $alunoUsuarioId
    ";
    $resultado = $conn->query($sql);
    $dados = $resultado->fetch_assoc();
    $totalDias = $dados['total_dias'] + 0;
    $presentes = $dados['presentes'] + 0;
    $faltas = $totalDias - $presentes;
    $percentual = $totalDias > 0 ? ($presentes / $totalDias) * 100 : 0;
    return [
        'total_dias' => $totalDias,
        'presentes' => $presentes,
        'faltas' => $faltas,
        'percentual_presenca' => $percentual
    ];
}
