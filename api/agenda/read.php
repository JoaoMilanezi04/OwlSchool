<?php
require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "
        SELECT 
            id,
            dia_semana,
            TIME_FORMAT(inicio, '%H:%i') AS inicio,
            TIME_FORMAT(fim, '%H:%i')   AS fim,
            disciplina
        FROM horarios_aula
        ORDER BY FIELD(dia_semana,'segunda','terca','quarta','quinta','sexta'), inicio
    ";

    $resultado = $conn->query($sql);

    if ($resultado) {
        $porDia = ['segunda'=>[], 'terca'=>[], 'quarta'=>[], 'quinta'=>[], 'sexta'=>[]];
        while ($linha = $resultado->fetch_assoc()) {
            $porDia[$linha['dia_semana']][] = $linha;
        }
        echo json_encode(['success'=>true, 'por_dia'=>$porDia]);
    } else {
        echo json_encode(['success'=>false,'message'=>'Erro: '.$conn->error]);
    }
} else {
    echo json_encode(['success'=>false,'message'=>'Método inválido.']);
}

