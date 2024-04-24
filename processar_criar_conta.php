<?php
session_start();
include_once "./conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Verificar se o usuário ou email já existem
    $query_check = "SELECT * FROM policiais WHERE username = :username OR email = :email";
    $stmt_check = $conn->prepare($query_check);
    $stmt_check->bindParam(':username', $username);
    $stmt_check->bindParam(':email', $email);
    $stmt_check->execute();
    $existing_user = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if ($existing_user) {
        // Usuário ou email já existem
        header("Location: cadastro_erro.php");
        exit();
    } else {
        // Realizar o cadastro do novo usuário na tabela notificacoes
        $query_cadastro = "INSERT INTO notificacoes (username, email, senha, aprovado) VALUES (:username, :email, :senha, 0)";
        $stmt_cadastro = $conn->prepare($query_cadastro);
        $stmt_cadastro->bindParam(':username', $username);
        $stmt_cadastro->bindParam(':email', $email);
        $stmt_cadastro->bindParam(':senha', $password);
        $stmt_cadastro->execute();

        // Redirecionar para a página de cadastro realizado com sucesso
        header("Location: cadastro_sucesso.php");
        exit();
    }
}
?>


