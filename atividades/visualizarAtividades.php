<?php
include_once "../conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {

    $query_afastamento = "SELECT id,color, start, end, nome, ord, motivacao, observacao, tipo FROM afastamentos WHERE id = :id LIMIT 1";
    $result_afastamento = $conn->prepare($query_afastamento);
    $result_afastamento->bindParam(':id', $id);
    $result_afastamento->execute();

    $row_afastamento = $result_afastamento->fetch(PDO::FETCH_ASSOC);

    $retorna = ['erro' => false, 'dados' => $row_afastamento];
} else {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Nenhum afastamento encontrado</div>"];
}

echo json_encode($retorna);
?>

