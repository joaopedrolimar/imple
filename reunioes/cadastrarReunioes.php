<!--/reunioes/cadastrarReunioes.php-->
<?php
include_once "../conexao.php";


$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$start = date('Y-m-d', strtotime($dados['start']));
$end = date('Y-m-d', strtotime($dados['end']));

$query_usuario = "INSERT INTO reunioes (color, start, end, motivacao, participantes) VALUES (:color, :start, :end, :motivacao, :participantes)";

$cad_usuario = $conn->prepare($query_usuario);
$cad_usuario->bindParam(':color', $dados['color']);
$cad_usuario->bindParam(':start', $start);
$cad_usuario->bindParam(':end', $end);
$cad_usuario->bindParam(':motivacao', $dados['motivacao']);
$cad_usuario->bindParam(':participantes', $dados['participantes']);

$cad_usuario->execute();


if($cad_usuario->rowCount()){
    $retorna = ['erro' => false, 'msg' => "usuario cadastrado"];
}else{
    $retorna = ['erro' => true, 'msg' => "usuario não cadastrado"];
}

echo json_encode($retorna);

?>