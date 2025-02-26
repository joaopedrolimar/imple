<!--/missoes/visualizarMissions.php-->
<?php
include_once "../conexao.php";

// Impede que qualquer saída HTML interfira no JSON
header('Content-Type: application/json; charset=utf-8');
ob_clean(); // Limpa qualquer saída anterior

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {
    $query_usuario = "SELECT m.id, m.tipo, m.color, m.start, m.end, m.funcao, m.motivacao, m.participantes, 
                      COALESCE(p.username, 'Não informado') AS elaborado_por,
                      p.id AS elaborado_por_id 
                      FROM missoes m 
                      LEFT JOIN policiais p ON m.elaborado_por = p.id
                      WHERE m.id = :id LIMIT 1";

    $result_usuario = $conn->prepare($query_usuario);
    $result_usuario->bindParam(':id', $id);
    $result_usuario->execute();

    if ($row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC)) {
        echo json_encode(['erro' => false, 'dados' => $row_usuario]);
        exit();
    } else {
        echo json_encode(['erro' => true, 'msg' => "Missão não encontrada."]);
        exit();
    }
} else {
    echo json_encode(['erro' => true, 'msg' => "ID inválido ou não informado."]);
    exit();
}
?>
