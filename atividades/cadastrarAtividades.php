<?php

include_once "../conexao.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$query_atividade = "INSERT INTO atividades (ord, produto, quantidade, data, hora, solicitante_cliente, documento, elaborado_por) VALUES (:ord, :produto, :quantidade, :data, :hora, :solicitante_cliente, :documento, :elaborado_por)";

$cad_atividade = $conn->prepare($query_atividade);

$cad_atividade->bindParam(':ord', $dados['ord']);
$cad_atividade->bindParam(':produto', $dados['produto']);
$cad_atividade->bindParam(':quantidade', $dados['quantidade']);
$cad_atividade->bindParam(':data', $dados['data']);
$cad_atividade->bindParam(':hora', $dados['hora']);
$cad_atividade->bindParam(':solicitante_cliente', $dados['solicitante_cliente']);
$cad_atividade->bindParam(':documento', $dados['documento']);
$cad_atividade->bindParam(':elaborado_por', $dados['elaborado_por']);

$cad_atividade->execute();

if($cad_atividade->rowCount()){
    $retorna = ['erro' => false, 'msg' => "Atividade cadastrada"];
}else{
    $retorna = ['erro' => true, 'msg' => "Atividade não cadastrada"];
}

echo json_encode($retorna);

?>
