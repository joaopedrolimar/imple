<?php
session_start();
include_once "./conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT id, username, senha, permissao FROM policiais WHERE username = :username AND senha = :senha AND aprovado = 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':senha', $password);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["permissao"] = $user["permissao"]; // Adicionando a permissão do usuário na sessão
        header("Location: pagina_protegida.php");
        exit();
    } else {
        header("Location: login.php?error=1");
        exit();
    }
}
?>

