<!--/reunioes/apagarReunioes.php-->
<?php
include_once "../conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {

    $query_reuniao = "DELETE FROM reunioes WHERE id=:id";
    $result_reuniao = $conn->prepare($query_reuniao);
    $result_reuniao->bindParam(':id', $id);

    if ($result_reuniao->execute()) {
        $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Reunião apagada com sucesso!</div>"];
    } else {
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Reunião não apagada com sucesso!</div>"];
    }
} else {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Nenhuma reunião encontrada!</div>"];
}

echo json_encode($retorna);
?>
