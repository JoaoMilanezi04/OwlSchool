<?php

require_once __DIR__ . '/../../db/conexao.php';




function listComunicadosAluno() {
    global $conn;

    $sql = "
        SELECT 
            id,
            titulo,
            corpo
        FROM comunicado
        ORDER BY id DESC
    ";

    $resultado = $conn->query($sql);
    $comunicados = [];

    while ($linha = $resultado->fetch_assoc()) {
        $comunicados[] = $linha;
    }

    return $comunicados;
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




function listAdvertenciasAluno($alunoId) {
    global $conn;

    $sql = "SELECT advertencia.titulo, advertencia.descricao
            FROM aluno_advertencia
            INNER JOIN advertencia ON aluno_advertencia.advertencia_id = advertencia.id
            WHERE aluno_advertencia.aluno_id = $alunoId";

    $resultado = $conn->query($sql);

    $lista = [];
    while ($linha = $resultado->fetch_assoc()) {
        $lista[] = $linha;
    }

    return $lista;
}

