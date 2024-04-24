<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./css/login.css">
    <title>Criar Conta</title>
</head>
<body>
<div class="container ring ">
    <i style="--clr:#1F438C;"></i>
    <i style="--clr:#1B8C42;"></i>
    <i style="--clr:#39A7BF;"></i>
    <form class="login" action="processar_criar_conta.php" method="POST">
        <h2>Criar Conta</h2>
        <div class="form-group inputBx ">
            <input type="text" class="form-control" id="username" name="username" placeholder="Usuário" required>
        </div>
        <div class="form-group inputBx ">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group inputBx ">
            <input type="password" class="form-control" id="password" name="password" placeholder="Senha" required>
        </div>
        <div class="inputBx">
            <input type="submit"  class="btn btn-primary" value="Criar Conta">
        </div>
        <div class="links">
            <a href="./login.php">Já tem uma conta? Faça login</a>
        </div>
    </form>
</div>

</body>
</html>
