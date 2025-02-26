<?php
// processar_esqueci_senha.php
session_start();
include_once "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"])) {
        $username = $_POST["username"];

        // Verificar se o usuário existe e buscar as perguntas de segurança
        $query_check = "SELECT id, question1, question2 FROM policiais WHERE username = :username";
        $stmt_check = $conn->prepare($query_check);
        $stmt_check->bindParam(':username', $username);
        $stmt_check->execute();
        $user = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['user_id'] = $user['id']; // Armazenar o ID do usuário na sessão para uso posterior
            $_SESSION['username'] = $username;
            $_SESSION['question1'] = $user['question1'];
            $_SESSION['question2'] = $user['question2'];

            // Redirecionar para a página de resposta das perguntas de segurança
            header("Location: responder_perguntas.php");
            exit();
        } else {
            // Nome de usuário inválido
            header("Location: esqueci_senha.php?error=invalid");
            exit();
        }
    } else {
        // Nome de usuário não fornecido
        header("Location: esqueci_senha.php?error=missing");
        exit();
    }
} else {
    // Método de requisição inválido
    header("Location: esqueci_senha.php?error=invalid_method");
    exit();
}
?>
