<?php

include_once "../conexao.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (empty($dados['id'])) {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: ID do afastamento não recebido!</div>"];
} else {
    $query_afastamentos = "UPDATE afastamentos SET title=:title, start=:start, end=:end WHERE id=:id";

    $edit_afastamentos = $conn->prepare($query_afastamentos);
    $edit_afastamentos->bindParam(':title', $dados['title']);
    $edit_afastamentos->bindParam(':start', $dados['start']);
    $edit_afastamentos->bindParam(':end', $dados['end']);
    $edit_afastamentos->bindParam(':id', $dados['id']);

    if ($edit_afastamentos->execute()) {
        $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Afastamento editado com sucesso!</div>"];
    } else {
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Falha ao editar o afastamento!</div>"];
    }
}

echo json_encode($retorna);

?>

