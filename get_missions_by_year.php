

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'conexao.php';
header('Content-Type: application/json');


$sql = "SELECT YEAR(start) AS ano, COUNT(*) AS total FROM missoes GROUP BY YEAR(start)";
$stmt = $conn->prepare($sql);
$stmt->execute();

$dados = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $dados[$row['ano']] = (int)$row['total'];
}

echo json_encode($dados);
