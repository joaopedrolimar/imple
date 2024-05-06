<?php
include_once "./conexao.php";

// Verificar se o parâmetro 'userName' está presente na solicitação
if(isset($_GET['userName'])) {
    $userName = $_GET['userName'];

    try {
        // Consulta para obter os afastamentos com base no nome
        $query_afastamentos = "SELECT COUNT(*) AS total, nome FROM afastamentos WHERE nome = :nome GROUP BY nome";
        $stmt = $conn->prepare($query_afastamentos);
        $stmt->bindParam(':nome', $userName);
        $stmt->execute();

        // Obter os dados dos afastamentos
        $afastamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retorne os dados como JSON
        echo json_encode($afastamentos);
    } catch (PDOException $e) {
        // Se ocorrer um erro, imprima a mensagem de erro
        echo json_encode(array('error' => 'Erro ao executar a consulta: ' . $e->getMessage()));
    }
} else {
    // Se o parâmetro 'userName' não estiver presente
    echo json_encode(array('error' => 'Parâmetro userName ausente.'));
}
?>




