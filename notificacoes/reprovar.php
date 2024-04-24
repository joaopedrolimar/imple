<?php
// Incluir o arquivo de conexão com o banco de dados
include_once "../conexao.php";

// Verificar se o ID do pedido foi passado através da URL
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Remover o pedido da tabela notificacoes
    $query_remover = "DELETE FROM notificacoes WHERE id = :id";
    $stmt_remover = $conn->prepare($query_remover);
    $stmt_remover->bindParam(':id', $id);
    $stmt_remover->execute();

    // Redirecionar de volta para a página de notificações
    header("Location: notificacoes.php");
    exit();
} else {
    // Se o ID do pedido não foi passado, redirecionar de volta para a página de notificações
    header("Location: notificacoes.php");
    exit();
}
?>
