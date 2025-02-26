
<?php
// processar_redefinir_senha.php

session_start();
include_once "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['token']) && isset($_POST['password'])) {
    $token = $_POST['token'];
    $password = $_POST['password'];

    // Consultar o token na tabela reset_tokens para validar sua existência e obter o ID do usuário
    $query_token = "SELECT user_id FROM reset_tokens WHERE token = :token AND created_at >= NOW() - INTERVAL 1 HOUR";
    $stmt_token = $conn->prepare($query_token);
    $stmt_token->bindParam(':token', $token);
    $stmt_token->execute();
    $reset_token = $stmt_token->fetch(PDO::FETCH_ASSOC);

    if ($reset_token) {
        $user_id = $reset_token['user_id'];

        // Hash da nova senha antes de salvar no banco de dados
        $novaSenhaHash = password_hash($password, PASSWORD_DEFAULT);

        // Atualizar a senha do usuário no banco de dados
        $query_update_senha = "UPDATE policiais SET senha = :senha WHERE id = :id";
        $stmt_update_senha = $conn->prepare($query_update_senha);
        $stmt_update_senha->bindParam(':senha', $novaSenhaHash);
        $stmt_update_senha->bindParam(':id', $user_id);

        if ($stmt_update_senha->execute()) {
            // Remover o token usado da tabela reset_tokens
            $query_delete_token = "DELETE FROM reset_tokens WHERE token = :token";
            $stmt_delete_token = $conn->prepare($query_delete_token);
            $stmt_delete_token->bindParam(':token', $token);
            $stmt_delete_token->execute();

            // Redirecionar para a página de login ou outra página de sucesso
            header("Location: ../login.php"); // Altere aqui para o caminho correto do seu login.php
            exit();
        } else {
            echo "Erro ao atualizar a senha. Por favor, tente novamente.";
            exit();
        }
    } else {
        echo "Token inválido ou expirado. Por favor, solicite uma nova redefinição de senha.";
        exit();
    }
} else {
    echo "Por favor, preencha todos os campos obrigatórios.";
    exit();
}
?>

