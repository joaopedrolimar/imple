<?php
include 'conexao.php';
header('Content-Type: application/json');

$sql = "SELECT funcao, COUNT(*) AS total FROM missoes GROUP BY funcao";
$stmt = $conn->prepare($sql);
$stmt->execute();

$dados = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $dados[$row['funcao']] = (int)$row['total'];
}

echo json_encode($dados);
