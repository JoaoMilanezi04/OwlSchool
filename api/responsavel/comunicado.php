<?php


require __DIR__ . '/../../db/conexao.php';
require __DIR__ . '/responsavel.php';




function listComunicadosResponsavel() {
    global $conn;
    $sql = "
        SELECT 
            id,
            titulo,
            corpo
        FROM comunicado
    ";
    $resultado = $conn->query($sql);
    $comunicados = [];
    while ($linha = $resultado->fetch_assoc()) $comunicados[] = $linha;
    return $comunicados;
}




function listAdvertenciasDoFilhoDoResponsavel($responsavelId) {
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





function listTarefas() {
    global $conn;

    $sql = "
        SELECT 
            id,
            titulo,
            descricao,
            data_entrega
        FROM tarefa
        ORDER BY data_entrega ASC, id ASC
    ";

    $resultado = $conn->query($sql);
    $tarefas = [];

    while ($linha = $resultado->fetch_assoc()) {
        $tarefas[] = $linha;
    }

    return $tarefas;
}
