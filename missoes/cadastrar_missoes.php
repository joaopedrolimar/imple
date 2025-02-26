<?php
include_once "../conexao.php";

header('Content-Type: application/json'); // Garante que a resposta seja JSON

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (empty($dados['elaborado_por'])) {
    echo json_encode(['erro' => true, 'msg' => "Selecione um usuário para 'Elaborado por'."]);
    exit();
}

$query_usuario = "INSERT INTO missoes (color, start, end, funcao, motivacao, participantes, elaborado_por) 
                  VALUES (:color, :start, :end, :funcao, :motivacao, :participantes, :elaborado_por)";

$cad_usuario = $conn->prepare($query_usuario);
$cad_usuario->bindParam(':color', $dados['color']);
$cad_usuario->bindParam(':start', $dados['start']);
$cad_usuario->bindParam(':end', $dados['end']);
$cad_usuario->bindParam(':funcao', $dados['funcao']);
$cad_usuario->bindParam(':motivacao', $dados['motivacao']);
$cad_usuario->bindParam(':participantes', $dados['participantes']);
$cad_usuario->bindParam(':elaborado_por', $dados['elaborado_por']);

if ($cad_usuario->execute()) {
    echo json_encode(['erro' => false, 'msg' => "Missão cadastrada com sucesso!"]);
} else {
    echo json_encode(['erro' => true, 'msg' => "Erro ao cadastrar missão."]);
}
exit(); // Certifique-se de encerrar o script aqui
