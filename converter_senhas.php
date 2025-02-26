<?php
//converter_senhas.php
require_once('./conexao.php');

$query = "SELECT id, senha FROM policiais";
$stmt = $conn->query($query);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['id'];
    $senhaAtual = '123';  // Senha padrão a ser usada para regeneração
    $senhaHash = password_hash($senhaAtual, PASSWORD_DEFAULT);

    $updateQuery = "UPDATE policiais SET senha = :senhaHash WHERE id = :id";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bindParam(':senhaHash', $senhaHash);
    $updateStmt->bindParam(':id', $id);
    $updateStmt->execute();
}
echo "Senhas convertidas com sucesso.";
?>

