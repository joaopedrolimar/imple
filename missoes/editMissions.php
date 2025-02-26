<!--/missoes/editMissions.php-->
<?php

include_once "../conexao.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (empty($dados['id'])) {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: ID do evento não recebido!</div>"];
} else {
    $query_usuario = "UPDATE missoes SET start=:start, end=:end, funcao=:funcao, motivacao=:motivacao, participantes=:participantes WHERE id=:id";


    $edit_usuario = $conn->prepare($query_usuario);
    $edit_usuario->bindParam(':start', $dados['start']);
    $edit_usuario->bindParam(':end', $dados['end']);
    $edit_usuario->bindParam(':funcao', $dados['funcao']);
    $edit_usuario->bindParam(':motivacao', $dados['motivacao']);
    $edit_usuario->bindParam(':participantes', $dados['participantes']);
    $edit_usuario->bindParam(':id', $dados['id']);

    if ($edit_usuario->execute()) {
        $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Evento editado com sucesso!</div>"];
    } else {
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Falha ao editar o evento!</div>"];
    }
}

echo json_encode($retorna);

?>
