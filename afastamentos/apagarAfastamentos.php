<?php
include_once "../conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {

    $query_afastamento = "DELETE FROM afastamentos WHERE id=:id";
    $result_afastamento = $conn->prepare($query_afastamento);
    $result_afastamento->bindParam(':id', $id);

    if ($result_afastamento->execute()) {
        $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Afastamento apagado com sucesso!</div>"];
    } else {
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Afastamento não apagado com sucesso!</div>"];
    }
} else {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Nenhum afastamento encontrado!</div>"];
}

echo json_encode($retorna);
?>
