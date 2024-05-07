<?php
include_once "../conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {

    $query_atividade = "DELETE FROM atividades WHERE id=:id";
    $result_atividade = $conn->prepare($query_atividade);
    $result_atividade->bindParam(':id', $id);


    if ($result_atividade->execute()) {
        $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Atividade apagada com sucesso!</div>"];
    } else {
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Atividade não apagado com sucesso!</div>"];
    }
} else {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Nenhuma atividade  encontrado!</div>"];
}

echo json_encode($retorna);
?>

