
<?php
include_once "../conexao.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


header('Content-Type: application/json');

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

// VALIDAÇÕES
if (empty($dados['elaborado_por'])) {
    echo json_encode(['erro' => true, 'msg' => "Selecione um usuário para 'Elaborado por'."]);
    exit();
}
if (empty($dados['participantes']) || !is_array($dados['participantes'])) {
    echo json_encode(['erro' => true, 'msg' => "Selecione ao menos um participante."]);
    exit();
}

// BUSCA NOMES DOS PARTICIPANTES PARA EXIBIÇÃO
$nomes_participantes = [];
$placeholders = implode(',', array_fill(0, count($dados['participantes']), '?'));
$sql_participantes = "SELECT username FROM policiais WHERE id IN ($placeholders)";
$stmt_participantes = $conn->prepare($sql_participantes);
$stmt_participantes->execute($dados['participantes']);
$nomes_participantes = $stmt_participantes->fetchAll(PDO::FETCH_COLUMN);

// Concatenar nomes em string para o campo "participantes"
$participantes_str = implode(', ', $nomes_participantes);

// INSERE A MISSÃO
$query_missao = "INSERT INTO missoes (color, start, end, funcao, motivacao, participantes, elaborado_por)
                 VALUES (:color, :start, :end, :funcao, :motivacao, :participantes, :elaborado_por)";
$cad_missao = $conn->prepare($query_missao);
$cad_missao->bindParam(':color', $dados['color']);
$cad_missao->bindParam(':start', $dados['start']);
$cad_missao->bindParam(':end', $dados['end']);
$cad_missao->bindParam(':funcao', $dados['funcao']);
$cad_missao->bindParam(':motivacao', $dados['motivacao']);
$cad_missao->bindParam(':participantes', $participantes_str); // <- visível na tabela
$cad_missao->bindParam(':elaborado_por', $dados['elaborado_por']);

if ($cad_missao->execute()) {
    $missao_id = $conn->lastInsertId();

    // INSERE CADA PARTICIPANTE NA TABELA mission_participants
    $query_part = "INSERT INTO mission_participants (mission_id, user_id, start, end)
                   VALUES (:mission_id, :user_id, :start, :end)";
    $stmt_part = $conn->prepare($query_part);

    foreach ($dados['participantes'] as $user_id) {
        $stmt_part->execute([
            'mission_id' => $missao_id,
            'user_id'    => $user_id,
            'start'      => $dados['start'],
            'end'        => $dados['end']
        ]);
    }

    echo json_encode(['erro' => false, 'msg' => "Missão e participantes cadastrados com sucesso!"]);
} else {
    echo json_encode(['erro' => true, 'msg' => "Erro ao cadastrar missão."]);
}
exit();