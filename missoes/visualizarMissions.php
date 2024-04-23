<?php
include_once "../conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if(!empty($id)){

    $query_usuario = "SELECT  id,title,color,start,end FROM events WHERE id =:id LIMIT 1";
    $result_ususario = $conn->prepare($query_usuario);
    $result_ususario->bindParam(':id', $id);
    $result_ususario->execute();

    $row_usuario = $result_ususario->fetch(PDO::FETCH_ASSOC);

    $retorna = ['erro' => false, 'dados' => $row_usuario];
    

} else {
   

    $retorna = ['erro' => true, 'msg' => "    <div class='alert alert-danger' role='alert'>
    Nenhuma pagina encontrada
</div>"];
    

    
}

echo json_encode($retorna);

?>