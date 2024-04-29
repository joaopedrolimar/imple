<?php
// Conexão com o banco de dados (substitua com suas credenciais)
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "celke";

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta para obter dados das missões (substitua com sua consulta SQL)
$sql = "SELECT MONTH(start) AS mes, COUNT(*) AS total_missoes FROM missoes GROUP BY MONTH(start)";

$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    // Formata os dados em um array associativo
    while($row = $result->fetch_assoc()) {
        $data[$row["mes"]] = $row["total_missoes"];
    }
}

// Retorna os dados no formato JSON
echo json_encode($data);

// Fecha conexão com o banco de dados
$conn->close();
?>
