<!--/missoes/editMissions.php-->
<?php

include_once "../conexao.php";
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (empty($dados['id'])) {
    echo json_encode([
        'erro' => true,
        'msg' => "<div class='alert alert-danger'>Erro: ID da missão não recebido!</div>"
    ]);
    exit();
}

// Atualizar a missão
$query_update = "UPDATE missoes 
                 SET start = :start, end = :end, funcao = :funcao, motivacao = :motivacao, participantes = :participantes, elaborado_por = :elaborado_por 
                 WHERE id = :id";

$stmt_update = $conn->prepare($query_update);
$stmt_update->bindParam(':start', $dados['start']);
$stmt_update->bindParam(':end', $dados['end']);
$stmt_update->bindParam(':funcao', $dados['funcao']);
$stmt_update->bindParam(':motivacao', $dados['motivacao']);
$stmt_update->bindParam(':participantes', $dados['participantes']); // Ainda salva nomes visíveis na tabela
$stmt_update->bindParam(':elaborado_por', $dados['elaborado_por']);
$stmt_update->bindParam(':id', $dados['id']);

if ($stmt_update->execute()) {
    // Apagar os registros antigos da mission_participants
    $delete = "DELETE FROM mission_participants WHERE mission_id = :mission_id";
    $stmt_delete = $conn->prepare($delete);
    $stmt_delete->bindParam(':mission_id', $dados['id']);
    $stmt_delete->execute();

    // Inserir novamente os participantes atualizados
    if (!empty($dados['participantes']) && is_array($dados['participantes'])) {
        $query_insert = "INSERT INTO mission_participants (mission_id, user_id, start, end) 
                         VALUES (:mission_id, :user_id, :start, :end)";
        $stmt_insert = $conn->prepare($query_insert);

        foreach ($dados['participantes'] as $user_id) {
            $stmt_insert->execute([
                ':mission_id' => $dados['id'],
                ':user_id' => $user_id,
                ':start' => $dados['start'],
                ':end' => $dados['end']
            ]);
        }
    }

    echo json_encode([
        'erro' => false,
        'msg' => "<div class='alert alert-success'>Missão e participantes atualizados com sucesso!</div>"
    ]);
} else {
    echo json_encode([
        'erro' => true,
        'msg' => "<div class='alert alert-danger'>Erro ao atualizar missão!</div>"
    ]);
}

exit();
?>
