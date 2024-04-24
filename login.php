
<!DOCTYPE html>
<html lang="pt0-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./css/login.css">
    <title>Login</title>



</head>
<body>


<div class="container ring ">
    
    <i style="--clr:#1F438C;"></i>
    <i style="--clr:#1B8C42;"></i>
    <i style="--clr:#39A7BF;"></i>

    <form class="login" action="processar_login.php" method="POST">
    <h2>Login</h2>
        <div class="form-group inputBx ">
            <input type="text" class="form-control" id="username" name="username" required>
        </div>

        <div class="form-group inputBx ">
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="inputBx">
            <input type="submit"  class="btn btn-primary" value="Login">
        </div>

        <div class="links">
            <a href="./criar_conta.php">Criar conta</a>
        </div>


    </form>

</div>

</body>
</html>


