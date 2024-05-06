<?php
include_once "../conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {

    $query_atividade = "SELECT id, ord, produto, quantidade, data, horario, solicitante, documento, elaborado_por FROM atividades WHERE id = :id LIMIT 1";
    $result_atividade = $conn->prepare($query_atividade);
    $result_atividade->bindParam(':id', $id);
    $result_atividade->execute();

    $row_atividade = $result_atividade->fetch(PDO::FETCH_ASSOC);

    $retorna = ['erro' => false, 'dados' => $row_atividade];
} else {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Nenhuma atividade encontrada</div>"];
}

echo json_encode($retorna);
?>
