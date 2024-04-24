<?php

// Incluir o arquivo com a conexão com banco de dados
include_once './conexao.php';

// Consulta para recuperar os eventos
$query_events = "SELECT id, title, color, start, end FROM events";

// Prepara a consulta para eventos
$result_events = $conn->prepare($query_events);

// Executa a consulta para eventos
$result_events->execute();

// Consulta para recuperar as reuniões
$query_reunioes = "SELECT id, title, color, start, end FROM reunioes";

// Prepara a consulta para reuniões
$result_reunioes = $conn->prepare($query_reunioes);

// Executa a consulta para reuniões
$result_reunioes->execute();

// Consulta para recuperar os afastamentos
$query_afastamentos = "SELECT id, title, color, start, end FROM afastamentos";

// Prepara a consulta para afastamentos
$result_afastamentos = $conn->prepare($query_afastamentos);

// Executa a consulta para afastamentos
$result_afastamentos->execute();

// Criar o array que receberá os eventos, reuniões e afastamentos
$eventos = [];

// Percorre os resultados dos eventos
while($row_events = $result_events->fetch(PDO::FETCH_ASSOC)){
    extract($row_events);
    $eventos[] = [
        'id' => $id,
        'title' => $title,
        'color' => $color,
        'start' => $start,
        'end' => $end,
        'tipo' => 'evento' // Adiciona um campo 'tipo' para distinguir eventos de reuniões e afastamentos
    ];
}

// Percorre os resultados das reuniões
while($row_reunioes = $result_reunioes->fetch(PDO::FETCH_ASSOC)){
    extract($row_reunioes);
    $eventos[] = [
        'id' => $id,
        'title' => $title,
        'color' => $color,
        'start' => $start,
        'end' => $end,
        'tipo' => 'reuniao' // Adiciona um campo 'tipo' para distinguir eventos de reuniões e afastamentos
    ];
}

// Percorre os resultados dos afastamentos
while($row_afastamentos = $result_afastamentos->fetch(PDO::FETCH_ASSOC)){
    extract($row_afastamentos);
    $eventos[] = [
        'id' => $id,
        'title' => $title,
        'color' => $color,
        'start' => $start,
        'end' => $end,
        'tipo' => 'afastamento' // Adiciona um campo 'tipo' para distinguir eventos de reuniões e afastamentos
    ];
}

// Codifica o array completo de eventos, reuniões e afastamentos como JSON e envia como resposta HTTP
echo json_encode($eventos);
