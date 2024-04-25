<?php

include_once "../conexao.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$query_afastamento = "INSERT INTO afastamentos (title, color, start, end, nome) VALUES (:title, :color, :start, :end, :nome)";

$cad_afastamento = $conn->prepare($query_afastamento);

$cad_afastamento->bindParam(':title', $dados['title']);
$cad_afastamento->bindParam(':color', $dados['color']);
$cad_afastamento->bindParam(':start', $dados['start']);
$cad_afastamento->bindParam(':end', $dados['end']);
$cad_afastamento->bindParam(':nome', $dados['nome']);


$cad_afastamento->execute();

if($cad_afastamento->rowCount()){
    $retorna = ['erro' => false, 'msg' => "Afastamento cadastrado"];
}else{
    $retorna = ['erro' => true, 'msg' => "Afastamento não cadastrado"];
}

echo json_encode($retorna);

?>
