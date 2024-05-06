<?php
// Inclua o arquivo de conexão
include_once "./conexao.php";

// Verifique se o nome do usuário foi enviado por meio do método GET
if (isset($_GET['userName'])) {
    $userName = $_GET['userName'];

    // Consulta SQL para selecionar as missões em que o nome do usuário está presente na coluna 'participantes'
    $query = "SELECT * FROM missoes WHERE participantes LIKE :userName";
    $stmt = $conn->prepare($query);
    $stmt->execute(array(':userName' => "%$userName%")); // Use % para corresponder a qualquer parte do nome
    $missaoData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Agora você tem os dados da missão para o usuário clicado na variável $missaoData

    // Envie os dados de volta para o cliente (JavaScript) para serem usados na renderização do gráfico
    echo json_encode($missaoData);
} else {
    // Se o nome do usuário não foi enviado, retorne um erro
    echo json_encode(array('error' => 'Nome de usuário não especificado.'));
}
?>

