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



function readAdvertenciasFilho($responsavelId) {
    global $conn;
    $alunoId = getIdFilho($responsavelId);
    $sql = "SELECT advertencia.titulo, advertencia.descricao
            FROM aluno_advertencia, advertencia
            WHERE aluno_advertencia.advertencia_id = advertencia.id
              AND aluno_advertencia.aluno_id = $alunoId";
    $resultado = $conn->query($sql);
    $lista = [];
    while ($linha = $resultado->fetch_assoc()) $lista[] = $linha;
    return $lista;
}