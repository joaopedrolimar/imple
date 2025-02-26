<?php
// redefinir_senha.php
session_start();
include_once "../conexao.php";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Consultar o token na tabela reset_tokens para validar sua existência e obter o ID do usuário
    $query_token = "SELECT user_id FROM reset_tokens WHERE token = :token AND created_at >= NOW() - INTERVAL 1 HOUR";
    $stmt_token = $conn->prepare($query_token);
    $stmt_token->bindParam(':token', $token);
    $stmt_token->execute();
    $reset_token = $stmt_token->fetch(PDO::FETCH_ASSOC);

    if ($reset_token) {
        // Token válido, continuar com o formulário de redefinição de senha
        $_SESSION['reset_token'] = $token; // Armazenar o token na sessão para uso posterior
        ?>

        <!DOCTYPE html>
        <html>
        <head>
            <title>Redefinir Senha</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <style>
                body {
                    padding: 20px;
                    background-color: #f8f9fa;
                }
                .container {
                    max-width: 400px;
                    background-color: #fff;
                    padding: 30px;
                    border-radius: 5px;
                    box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
                }
                h2 {
                    margin-bottom: 30px;
                    text-align: center;
                    color: #007bff;
                }
                form {
                    margin-top: 20px;
                }
                label {
                    font-weight: bold;
                }
                input[type=password] {
                    width: 100%;
                    padding: 10px;
                    margin-bottom: 20px;
                    border: 1px solid #ced4da;
                    border-radius: 5px;
                }
                button[type=submit] {
                    background-color: #007bff;
                    color: white;
                    border: none;
                    padding: 10px 20px;
                    border-radius: 5px;
                    cursor: pointer;
                }
                button[type=submit]:hover {
                    background-color: #0056b3;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h2>Redefinir Senha</h2>
                <form action="processar_redefinir_senha.php" method="post">
                    <input type="hidden" name="token" value="<?php echo urlencode($token); ?>">
                    <div class="form-group">
                        <label for="password">Nova Senha:</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Redefinir Senha</button>
                </form>
            </div>

            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>
        </html>

        <?php
        exit();
    } else {
        echo "Token inválido ou expirado. Por favor, solicite uma nova redefinição de senha.";
        exit();
    }
} else {
    echo "Token não fornecido.";
    exit();
}
?>
