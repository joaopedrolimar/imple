<?php

include_once "../conexao.php";


$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$query_usuario = "INSERT INTO reunioes (title, color, start, end) VALUES (:title, :color, :start, :end)";

$cad_usuario = $conn->prepare($query_usuario);


$cad_usuario->bindParam(':title', $dados['title']);
$cad_usuario->bindParam(':color', $dados['color']);
$cad_usuario->bindParam(':start', $dados['start']);
$cad_usuario->bindParam(':end', $dados['end']);

$cad_usuario->execute();

if($cad_usuario->rowCount()){
    $retorna = ['erro' => false, 'msg' => "usuario cadastrado"];
}else{
    $retorna = ['erro' => true, 'msg' => "usuario não cadastrado"];
}

echo json_encode($retorna);

?>