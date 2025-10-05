<?php

require_once __DIR__ . '/../../db/conexao.php';




function listComunicadosResponsavel() {
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
