<?php
//aprovar.php
// Incluir o arquivo de conexão com o banco de dados
include_once "../conexao.php";

// Verificar se o ID do pedido foi passado através da URL
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Consulta para obter os detalhes do pedido com base no ID
    $query_pedido = "SELECT username, email, senha, question1, answer1, question2, answer2 FROM notificacoes WHERE id = :id";
    $stmt_pedido = $conn->prepare($query_pedido);
    $stmt_pedido->bindParam(':id', $id);
    $stmt_pedido->execute();
    $pedido = $stmt_pedido->fetch(PDO::FETCH_ASSOC);

    // Verificar se o pedido foi encontrado
    if ($pedido) {
        // Inserir o usuário aprovado na tabela policiais
        $query_aprovar = "INSERT INTO policiais (username, email, senha, permissao, aprovado, question1, answer1, question2, answer2) 
                          VALUES (:username, :email, :senha, 'usuario', 1, :question1, :answer1, :question2, :answer2)";
        $stmt_aprovar = $conn->prepare($query_aprovar);
        $stmt_aprovar->bindParam(':username', $pedido['username']);
        $stmt_aprovar->bindParam(':email', $pedido['email']);
        $stmt_aprovar->bindParam(':senha', $pedido['senha']);
        $stmt_aprovar->bindParam(':question1', $pedido['question1']);
        $stmt_aprovar->bindParam(':answer1', $pedido['answer1']);
        $stmt_aprovar->bindParam(':question2', $pedido['question2']);
        $stmt_aprovar->bindParam(':answer2', $pedido['answer2']);
        $stmt_aprovar->execute();

        // Remover o pedido da tabela notificacoes
        $query_remover = "DELETE FROM notificacoes WHERE id = :id";
        $stmt_remover = $conn->prepare($query_remover);
        $stmt_remover->bindParam(':id', $id);
        $stmt_remover->execute();

        // Redirecionar de volta para a página de notificações
        header("Location: notificacoes.php");
        exit();
    } else {
        // Se o pedido não foi encontrado, redirecionar de volta para a página de notificações
        header("Location: notificacoes.php");
        exit();
    }
} else {
    // Se o ID do pedido não foi passado, redirecionar de volta para a página de notificações
    header("Location: notificacoes.php");
    exit();
}
?>
