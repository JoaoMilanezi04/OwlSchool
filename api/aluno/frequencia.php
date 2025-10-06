<?php
// api/aluno/frequencia.php
require __DIR__ . '/../../db/conexao.php';

/**
 * Monta o trecho de WHERE por período (data_inicio/data_fim podem ser null).
 */
function _wherePeriodo($dataInicio, $dataFim) {
    $filtros = [];
    if (!empty($dataInicio)) $filtros[] = "chamada.data >= '$dataInicio'";
    if (!empty($dataFim))    $filtros[] = "chamada.data <= '$dataFim'";
    return empty($filtros) ? "" : ("WHERE " . implode(" AND ", $filtros));
}

/**
 * Lista todas as chamadas no período, com o status do aluno em cada dia.
 * Se não houver registro em chamada_item, retorna status NULL (mostra como Falta).
 */
function listChamadasDoAluno($alunoUsuarioId, $dataInicio = null, $dataFim = null) {
    global $conn;
    $alunoUsuarioId = (int)$alunoUsuarioId;

    $where = _wherePeriodo($dataInicio, $dataFim);
    $sql = "
        SELECT
            chamada.id   AS chamada_id,
            chamada.data AS data,
            chamada_item.status AS status
        FROM chamada
        LEFT JOIN chamada_item
               ON chamada_item.chamada_id = chamada.id
              AND chamada_item.aluno_id   = $alunoUsuarioId
        $where
        ORDER BY chamada.data DESC, chamada.id DESC
    ";

    $resultado = $conn->query($sql);
    $linhas = [];
    while ($linha = $resultado->fetch_assoc()) $linhas[] = $linha;
    return $linhas;
}

/**
 * Resumo de frequência do aluno no período:
 * - total_dias: quantidade de registros em chamada (dias) no período
 * - presentes: quantos estavam como 'presente'
 * - faltas: total_dias - presentes (conta NULL como falta)
 * - percentual_presenca: presentes / total_dias * 100 (0 se total_dias = 0)
 */
function getResumoFrequencia($alunoUsuarioId, $dataInicio = null, $dataFim = null) {
    global $conn;
    $alunoUsuarioId = (int)$alunoUsuarioId;

    $where = _wherePeriodo($dataInicio, $dataFim);
    $sql = "
        SELECT
            COUNT(chamada.id) AS total_dias,
            SUM(CASE WHEN chamada_item.status = 'presente' THEN 1 ELSE 0 END) AS presentes
        FROM chamada
        LEFT JOIN chamada_item
               ON chamada_item.chamada_id = chamada.id
              AND chamada_item.aluno_id   = $alunoUsuarioId
        $where
    ";

    $resultado = $conn->query($sql);
    $dados = $resultado->fetch_assoc();

    $totalDias = (int)($dados['total_dias'] ?? 0);
    $presentes = (int)($dados['presentes'] ?? 0);
    $faltas    = max(0, $totalDias - $presentes);
    $percentual = $totalDias > 0 ? round(($presentes / $totalDias) * 100, 2) : 0.00;

    return [
        'total_dias'          => $totalDias,
        'presentes'           => $presentes,
        'faltas'              => $faltas,
        'percentual_presenca' => $percentual
    ];
}
