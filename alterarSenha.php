<!--alterarSenha.php-->

<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
$is_owner = ($_SESSION["permissao"] === "owner");
include_once "./conexao.php";
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trocar Senha</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{
            background:#dcdcdc;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Trocar Senha
                    </div>
                    <div class="card-body">
                        <form id="trocarSenhaForm">
                            <div class="form-group">
                                <label for="senhaAtual">Senha Atual</label>
                                <input type="text" class="form-control" id="senhaAtual" name="senhaAtual" required>
                            </div>
                            <div class="form-group">
                                <label for="novaSenha">Nova Senha</label>
                                <input type="text" class="form-control" id="novaSenha" name="novaSenha" required>
                            </div>
                            <div  class="form-group">
                                <label for="confirmarSenha">Confirmar Nova Senha</label>
                                <input type="text" class="form-control" id="confirmarSenha" name="confirmarSenha" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Trocar Senha</button>
                            <button  class="btn btn-primary"><a style="color:white;text-decoration: none; " href="./index.php">Voltar</a></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            console.log("Página carregada.");

            $('#trocarSenhaForm').submit(function(event) {
                event.preventDefault();
                console.log("Formulário enviado.");

                $.ajax({
                    url: './trocar_senha.php',
                    type: 'POST',
                    dataType: 'json',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response.message);
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao trocar a senha:', error);
                        alert('Ocorreu um erro ao trocar a senha. Por favor, tente novamente.');
                    }
                });
            });
        });
    </script>
</body>
</html>
