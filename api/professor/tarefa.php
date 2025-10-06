<?php


require __DIR__ . '/../../db/conexao.php';




function createTarefa($titulo, $descricao, $dataEntrega) {
    global $conn;
    $sql = "INSERT INTO tarefa (titulo, descricao, data_entrega) VALUES ('$titulo', '$descricao', '$dataEntrega')";
    $conn->query($sql);
    return $conn->insert_id;
}




function updateTarefa($id, $titulo, $descricao, $dataEntrega) {
    global $conn;
    $sql = "UPDATE tarefa SET titulo = '$titulo', descricao = '$descricao', data_entrega = '$dataEntrega' WHERE id = $id";
    $conn->query($sql);
}




function listTarefasProfessor() {
    global $conn;
    $sql = "SELECT id, titulo, descricao, data_entrega FROM tarefa";
    $resultado = $conn->query($sql);
    $tarefas = [];
    while ($linha = $resultado->fetch_assoc()) $tarefas[] = $linha;
    return $tarefas;
}




function deleteTarefaById($id) {
    global $conn;
    $sql = "DELETE FROM tarefa WHERE id = $id";
    $conn->query($sql);
}
