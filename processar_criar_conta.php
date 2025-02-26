<?php
//processar_criar_conta.php
session_start();
include_once "./conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $question1 = $_POST["question1"];
    $answer1 = $_POST["answer1"];
    $question2 = $_POST["question2"];
    $answer2 = $_POST["answer2"];

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
        // Hash da senha antes de salvar no banco de dados
        $senhaHash = password_hash($password, PASSWORD_DEFAULT);

        // Realizar o cadastro do novo usuário na tabela notificacoes
        $query_cadastro = "INSERT INTO notificacoes (username, email, senha, question1, answer1, question2, answer2, aprovado) VALUES (:username, :email, :senha, :question1, :answer1, :question2, :answer2, 0)";
        $stmt_cadastro = $conn->prepare($query_cadastro);
        $stmt_cadastro->bindParam(':username', $username);
        $stmt_cadastro->bindParam(':email', $email);
        $stmt_cadastro->bindParam(':senha', $senhaHash);
        $stmt_cadastro->bindParam(':question1', $question1);
        $stmt_cadastro->bindParam(':answer1', $answer1);
        $stmt_cadastro->bindParam(':question2', $question2);
        $stmt_cadastro->bindParam(':answer2', $answer2);
        $stmt_cadastro->execute();

        // Redirecionar para a página de cadastro realizado com sucesso
        header("Location: cadastro_sucesso.php");
        exit();
    }
}
?>


