<?php
require_once __DIR__ . '/../../db/conexao.php';
require_once __DIR__ . '/../../helpers/get_id_filho.php'; // ajusta o caminho se for outro
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // lê o id do responsável vindo do JS
    $responsavelId = isset($_POST['responsavel_id']) ? (int) $_POST['responsavel_id'] : 0;

    if ($responsavelId <= 0) {
        echo json_encode(['success'=>false, 'message'=>'responsavel_id inválido.']);
        exit;
    }

    // pega o id do filho (aluno) conforme tua regra
    $alunoId = getIdFilho($responsavelId);
    if (!$alunoId) {
        echo json_encode(['success'=>false, 'message'=>'Filho não encontrado para este responsável.']);
        exit;
    }

    // consulta no teu estilo (JOIN explícito só pra ficar claro)
    $sql = "
        SELECT 
            advertencia.id,
            advertencia.titulo,
            advertencia.descricao
        FROM aluno_advertencia
        JOIN advertencia 
          ON aluno_advertencia.advertencia_id = advertencia.id
        WHERE aluno_advertencia.aluno_id = $alunoId
        ORDER BY aluno_advertencia.id DESC
    ";

    $resultado = $conn->query($sql);

    if ($resultado) {
        $advertencias = [];
        while ($linha = $resultado->fetch_assoc()) $advertencias[] = $linha;

        echo json_encode(['success'=>true, 'advertencias'=>$advertencias]);
    } else {
        echo json_encode(['success'=>false, 'message'=>'Erro: ' . $conn->error]);
    }

} else {
    echo json_encode(['success'=>false, 'message'=>'Método inválido.']);
}
