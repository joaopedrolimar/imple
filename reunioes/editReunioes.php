<?php

include_once "../conexao.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (empty($dados['id'])) {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: ID do evento não recebido!</div>"];
} else {
    $query_reunioes = "UPDATE reunioes SET  start=:start, end=:end, motivacao=:motivacao, participantes=:participantes WHERE id=:id";

    $edit_reunioes = $conn->prepare($query_reunioes);
    $edit_reunioes->bindParam(':start', $dados['start']);
    $edit_reunioes->bindParam(':end', $dados['end']);
    $edit_reunioes->bindParam(':id', $dados['id']);
    $edit_reunioes->bindParam(':motivacao', $dados['motivacao']);
    $edit_reunioes->bindParam(':participantes', $dados['participantes']);

    if ($edit_reunioes->execute()) {
        $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Evento editado com sucesso!</div>"];
    } else {
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Falha ao editar o evento!</div>"];
    }
}

echo json_encode($retorna);


