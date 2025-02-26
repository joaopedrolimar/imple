<?php
session_start(); // Inicia a sessão

include_once "../conexao.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

// Obter o ID do usuário atualmente logado
$id_usuario_logado = $_SESSION['user_id'];

// Preparar a consulta para inserir atividade
$query_atividade = "INSERT INTO atividades (ord, produto, quantidade, data, hora, solicitante_cliente, documento, elaborado_por, tipo, criado_por) 
                    VALUES (:ord, :produto, :quantidade, :data, :hora, :solicitante_cliente, :documento, :elaborado_por, :tipo, :criado_por)";

$cad_atividade = $conn->prepare($query_atividade);

// Atribuir valores aos parâmetros da consulta
$cad_atividade->bindParam(':ord', $dados['ord']);
$cad_atividade->bindParam(':produto', $dados['produto']);
$cad_atividade->bindParam(':quantidade', $dados['quantidade']);
$cad_atividade->bindParam(':data', $dados['data']);
$cad_atividade->bindParam(':hora', $dados['hora']);
$cad_atividade->bindParam(':solicitante_cliente', $dados['solicitante_cliente']);
$cad_atividade->bindParam(':documento', $dados['documento']);

// Verificar se o campo elaborado_por está vazio
if (!empty($dados['elaborado_por'])) {
    // Decodificar o JSON recebido de elaborado_por
    $selectedUsers = json_decode($dados['elaborado_por']);
    
    // Converter o array de nomes em uma string separada por vírgulas
    $elaborado_por = implode(',', $selectedUsers);
} else {
    // Caso esteja vazio, inserir um valor padrão ou NULL (dependendo da sua lógica de negócios)
    $elaborado_por = ''; // ou NULL, dependendo do seu requisito
}

$cad_atividade->bindParam(':elaborado_por', $elaborado_por);
$cad_atividade->bindParam(':tipo', $dados['tipo']);
$cad_atividade->bindParam(':criado_por', $id_usuario_logado); // Usando o ID do usuário logado

$cad_atividade->execute();

if($cad_atividade->rowCount()){
    $retorna = ['erro' => false, 'msg' => "Atividade cadastrada"];
}else{
    $retorna = ['erro' => true, 'msg' => "Atividade não cadastrada"];
}

echo json_encode($retorna);

?>
