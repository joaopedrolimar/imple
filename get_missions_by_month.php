<?php
include 'conexao.php';
header('Content-Type: application/json');

$ano = filter_input(INPUT_GET, 'ano', FILTER_SANITIZE_NUMBER_INT);
$sql = "SELECT MONTH(start) AS mes, COUNT(*) AS total FROM missoes WHERE YEAR(start) = :ano GROUP BY MONTH(start)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':ano', $ano);
$stmt->execute();

$dados = array_fill(1, 12, 0); // Janeiro a Dezembro

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $dados[(int)$row['mes']] = (int)$row['total'];
}

echo json_encode($dados);
