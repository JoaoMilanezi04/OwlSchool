<?php

require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


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


        echo json_encode([
            'success'  => true,
            'usuarios' => $usuarios
        ]);



    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao listar: ' . $conn->error
        ]);
    }



} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método inválido.'
    ]);
}
