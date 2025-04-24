<?php
include 'conexao.php';
header('Content-Type: application/json');

// Elaboradas
$sql1 = "SELECT p.username, COUNT(*) AS total FROM missoes m JOIN policiais p ON m.elaborado_por = p.id GROUP BY p.username";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute();
$elaboradas = $stmt1->fetchAll(PDO::FETCH_KEY_PAIR);

// Participadas
$sql2 = "SELECT p.username, COUNT(*) AS total 
         FROM mission_participants mp 
         JOIN policiais p ON mp.user_id = p.id 
         GROUP BY p.username";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute();
$participadas = $stmt2->fetchAll(PDO::FETCH_KEY_PAIR);

echo json_encode([
    'elaboradas' => $elaboradas,
    'participadas' => $participadas
]);
