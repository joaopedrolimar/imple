<?php
session_start();
include_once "./conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Consulta para selecionar o usuário com o username fornecido
    $query = "SELECT id, username, senha, permissao FROM policiais WHERE username = :username AND aprovado = 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verifica se a senha digitada corresponde ao hash armazenado no banco de dados
        if (password_verify($password, $user["senha"])) {
            // Login bem-sucedido: inicializa a sessão
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["permissao"] = $user["permissao"]; // Adicionando a permissão do usuário na sessão
            header("Location: pagina_protegida.php");
            exit();
        } else {
            // Senha incorreta
            header("Location: login.php?error=1");
            exit();
        }
    } else {
        // Usuário não encontrado ou não aprovado
        header("Location: login.php?error=2");
        exit();
    }
}
?>


