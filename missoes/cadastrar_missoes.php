<?php

include_once "../conexao.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$query_usuario = "INSERT INTO missoes (ord, color, start, end, funcao, motivacao, participantes ) VALUES (:ord, :color, :start, :end, :funcao, :motivacao, :participantes)";

$cad_usuario = $conn->prepare($query_usuario);


$cad_usuario->bindParam(':ord', $dados['ord']);
$cad_usuario->bindParam(':color', $dados['color']);
$cad_usuario->bindParam(':start', $dados['start']);
$cad_usuario->bindParam(':end', $dados['end']);
$cad_usuario->bindParam(':funcao', $dados['funcao']);
$cad_usuario->bindParam(':motivacao', $dados['motivacao']);
$cad_usuario->bindParam(':participantes', $dados['participantes']);

$cad_usuario->execute();

if($cad_usuario->rowCount()){
    $retorna = ['erro' => false, 'msg' => "Missão cadastrada"];
}else{
    $retorna = ['erro' => true, 'msg' => "Missão não cadastrada"];
}

echo json_encode($retorna);

?>