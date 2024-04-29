<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./css/login2.css">
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
    <title>Criar Conta</title>
</head>
<body>
<div id="topo-login">
    <div class="logo-login">
        <a href="./login.php"><img src="https://intranet.sipam.gov.br/templates/shaper_helix3/images/logo-cnmp.png" alt="intranet inteligencia"></a>
    </div>

    <div class="texto-login">
        <span>INTRANET</span>
    </div>

</div>


<div class="data-login">
    <p>Brasília - Segunda, 29 de Abril de 2024</p>
</div>

<section id="sp-componentes">
    <div class="container">
        <div class="row">
            <div id="sp-component" class="col-sm-12 col-md-12">
                <div class="sp-column ">
                    <div id="system-message-container">
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-sm-offset-4 text-center">
                            <div class="login">

                                <form action="processar_criar_conta.php" method="post" class="form-validate">


                                    <div class="form-group">
                                        <div class="group-control">
                                            <input type="text"   class="validate-username required" size="25" id="username" name="username" placeholder="Usuário"  required aria-required="true" autofocus />
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <div class="group-control">
                                            <input type="email" id="email" name="email"  placeholder="Email" class="validate-password required" size="25" maxlength="99" required aria-required="true" />
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <div class="group-control">
                                            <input type="password" name="password" id="password"  placeholder="Senha" class="validate-password required" size="25" maxlength="99" required aria-required="true" />
                                        </div>
                                       
                                    </div>

                                    <div class="form-group botoes-login">

                                        <button type="button" class="btn-login-limpar">
                                            Limpar
                                        </button>

                                        <button type="submit" class="btn-login">
                                            Criar
                                        </button>
                                    </div>

                                    <div class="links">
                                        <a href="./login.php">Já tem uma conta? Faça login</a>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

</body>
</html>



