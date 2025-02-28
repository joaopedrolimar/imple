<!--/afastamentos/cadastrarAfastamentos.php-->
<?php

include_once "../conexao.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$query_afastamento = "INSERT INTO afastamentos ( color, start, end, nome, ord, motivacao, observacao) VALUES (:color, :start, :end, :nome, :ord, :motivacao, :observacao)";

$cad_afastamento = $conn->prepare($query_afastamento);

$cad_afastamento->bindParam(':color', $dados['color']);
$cad_afastamento->bindParam(':start', $dados['start']);
$cad_afastamento->bindParam(':end', $dados['end']);
$cad_afastamento->bindParam(':nome', $dados['nome']);
$cad_afastamento->bindParam(':ord', $dados['ord']);
$cad_afastamento->bindParam(':motivacao', $dados['motivacao']);
$cad_afastamento->bindParam(':observacao', $dados['observacao']);


$cad_afastamento->execute();

if($cad_afastamento->rowCount()){
    $retorna = ['erro' => false, 'msg' => "Afastamento cadastrado"];
}else{
    $retorna = ['erro' => true, 'msg' => "Afastamento não cadastrado"];
}

echo json_encode($retorna);

?>
