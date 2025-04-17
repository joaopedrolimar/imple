
<?php
// consulta_status.php

include_once "conexao.php";

// Ajuste o fuso horário se necessário
date_default_timezone_set('America/Sao_Paulo');
$hoje = date('Y-m-d');

// Consulta que verifica missões, afastamentos, etc.
$query = "
    SELECT p.id, p.username,
        CASE 
            WHEN EXISTS (
                SELECT 1 
                FROM afastamentos a
                WHERE a.nome = p.username
                  AND a.start <= :hoje AND a.end >= :hoje
            ) THEN 'Indisponível – Afastamento'
            
            WHEN EXISTS (
                SELECT 1 
                FROM mission_participants mp
                WHERE mp.user_id = p.id
                  AND mp.start <= :hoje AND mp.end >= :hoje
            ) THEN 'Indisponível – Em Missão'
            
            ELSE 'Disponível'
        END AS status
    FROM policiais p
    WHERE p.aprovado = 1
    ORDER BY p.username ASC
";

$stmt = $conn->prepare($query);
$stmt->bindValue(':hoje', $hoje);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retorna em JSON
header('Content-Type: application/json; charset=utf-8');
echo json_encode($usuarios);
exit();
