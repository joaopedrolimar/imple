<?php

include_once "../conexao.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (empty($dados['id'])) {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: ID da atividade não recebido!</div>"];
} else {
    $query_atividades = "UPDATE atividades SET ord=:ord, produto=:produto, quantidade=:quantidade, data=:data, horario=:horario, solicitante=:solicitante, documento=:documento, elaborado_por=:elaborado_por WHERE id=:id";

    $edit_atividades = $conn->prepare($query_atividades);
    $edit_atividades->bindParam(':ord', $dados['ord']);
    $edit_atividades->bindParam(':produto', $dados['produto']);
    $edit_atividades->bindParam(':quantidade', $dados['quantidade']);
    $edit_atividades->bindParam(':data', $dados['data']);
    $edit_atividades->bindParam(':horario', $dados['horario']);
    $edit_atividades->bindParam(':solicitante', $dados['solicitante']);
    $edit_atividades->bindParam(':documento', $dados['documento']);
    $edit_atividades->bindParam(':elaborado_por', $dados['elaborado_por']);
    $edit_atividades->bindParam(':id', $dados['id']);

    if ($edit_atividades->execute()) {
        $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Atividade editada com sucesso!</div>"];
    } else {
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Falha ao editar a atividade!</div>"];
    }
}

echo json_encode($retorna);

?>

