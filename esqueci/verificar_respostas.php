<?php
// verificar_respostas.php
session_start();
include_once "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['answer1']) && isset($_POST['answer2'])) {
    $answer1 = $_POST['answer1'];
    $answer2 = $_POST['answer2'];

    // Verificar se as respostas estão corretas com base no nome de usuário armazenado na sessão
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        // Consultar as respostas de segurança na tabela policiais
        $query_respostas = "SELECT answer1, answer2 FROM policiais WHERE username = :username";
        $stmt_respostas = $conn->prepare($query_respostas);
        $stmt_respostas->bindParam(':username', $username);
        $stmt_respostas->execute();
        $result = $stmt_respostas->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Verificar se as respostas correspondem
            if ($result['answer1'] == $answer1 && $result['answer2'] == $answer2) {
                // Respostas corretas, gerar e armazenar token na tabela reset_tokens
                $token = bin2hex(random_bytes(32)); // Gerar token aleatório seguro
                
                // Armazenar o token na tabela reset_tokens
                $query_store_token = "INSERT INTO reset_tokens (token, user_id, created_at) VALUES (:token, :user_id, NOW())";
                $stmt_store_token = $conn->prepare($query_store_token);
                $stmt_store_token->bindParam(':token', $token);
                $stmt_store_token->bindParam(':user_id', $_SESSION['user_id']);
                $stmt_store_token->execute();

                // Redirecionar para a página de redefinição de senha com token
                header("Location: redefinir_senha.php?token=" . urlencode($token));
                exit();
            } else {
                echo "Respostas de segurança inválidas.";
                exit();
            }
        } else {
            echo "Usuário não encontrado.";
            exit();
        }
    } else {
        echo "Nome de usuário não encontrado na sessão.";
        exit();
    }
} else {
    echo "Por favor, preencha todas as respostas de segurança.";
    exit();
}

?>

