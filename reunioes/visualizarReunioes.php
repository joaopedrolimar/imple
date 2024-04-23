<?php
include_once "../conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {

    $query_reuniao = "SELECT id,title,color,start,end FROM reunioes WHERE id = :id LIMIT 1";
    $result_reuniao = $conn->prepare($query_reuniao);
    $result_reuniao->bindParam(':id', $id);
    $result_reuniao->execute();

    $row_reuniao = $result_reuniao->fetch(PDO::FETCH_ASSOC);

    $retorna = ['erro' => false, 'dados' => $row_reuniao];
} else {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Nenhuma reunião encontrada</div>"];
}

echo json_encode($retorna);
?>
