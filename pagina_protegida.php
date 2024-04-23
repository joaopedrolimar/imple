<?php
// Verificar se o usuário está logado
session_start();
if (!isset($_SESSION["user_id"])) {
    // Se não estiver logado, redirecionar para a página de login
    header("Location: login.php");
    exit();
} else {
    // Se estiver logado, redirecionar para a página do calendário (index.php)
    header("Location: index.php");
    exit();
}
?>
