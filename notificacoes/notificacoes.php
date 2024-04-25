<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Verificar se o usuário é o proprietário
$is_owner = ($_SESSION["permissao"] === "owner");

?>


<?php
session_start();

// Verificar se o usuário está logado e é o owner
if (!isset($_SESSION["user_id"]) || $_SESSION["permissao"] !== "owner") {
    header("Location: login.php");
    exit();
}

// Aqui você pode incluir o arquivo de conexão com o banco de dados
include_once "../conexao.php";

// Consulta para obter os pedidos de criação de conta pendentes
// Substitua `tabela_notificacoes` pelo nome correto da tabela em seu banco de dados


$query_notificacoes = "SELECT id, username, email, senha FROM notificacoes WHERE aprovado = 0";
$result_notificacoes = $conn->query($query_notificacoes);
$pedidos_notificacoes = $result_notificacoes->fetchAll(PDO::FETCH_ASSOC);


$query_usuarios = "SELECT id, username FROM policiais WHERE aprovado = 1";
$result_usuarios = $conn->query($query_usuarios);
$usuarios = $result_usuarios->fetchAll(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificações</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

    <style>
        .container {
            margin-top: 70px; /* Adicione uma margem superior para afastar as tabelas do navbar */
        }
    </style>
    
</head>

<body>


<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <a class="navbar-brand d-flex align-items-center" href="/imple/index.php">
            <img src="../img/censipamLogo2.png" alt="Logo" width=" 80" height="80" class="d-inline-block align-text-top">
            <h1 class="ms-2 mb-0">Intranet</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Restante do seu código -->
    </div>
</nav>

    
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Opções</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>

      <div class="offcanvas-body">

        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">


        <li class="nav-item">
            <a class="nav-link" href="/imple/index.php">Calendario</a>
          </li>

          <li class="nav-item">
            <a class="nav-link " aria-current="page" href="/imple/missoes/form.php">Missões</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="/imple/reunioes/formReunioes.php">Reuniões</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="/imple/afastamentos/formAfastamentos.php">Afastamentos</a>
          </li>


          
          <?php if ($is_owner) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/imple/notificacoes/notificacoes.php">Notificações</a>
                    </li>
                    <?php endif; ?>

          

          <a href="/imple/logout.php" class="btn btn-danger">Sair</a>
          
        </ul>
        
      </div>
    </div>
  </div>
</nav>


<span id="msgAlerta"></span>



    <!-- Lista de novos usuarios -->
    <div class="container">
        <h1>Notificações de Novas Contas</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos_notificacoes as $pedido) : ?>
                    <tr>
                        <td><?= $pedido['id'] ?></td>
                        <td><?= $pedido['username'] ?></td>
                        <td><?= $pedido['email'] ?></td>
                        <td>
                            <a href="aprovar.php?id=<?= $pedido['id'] ?>" class="btn btn-success">Aprovar</a>
                            <a href="reprovar.php?id=<?= $pedido['id'] ?>" class="btn btn-danger">Reprovar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Tabela de usuários da intranet -->
    <div class="container mx-auto">
      <h2>Usuários da Intranet</h2>
      <table class="table ">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Username</th>
                  <th>Ações</th>
              </tr>
          </thead>
          <tbody>
              <?php foreach ($usuarios as $usuario) : ?>
                  <tr>
                      <td><?= $usuario['id'] ?></td>
                      <td><?= $usuario['username'] ?></td>
                      <td>
                          <button class="btn btn-danger" onclick="excluirUsuario(<?= $usuario['id'] ?>)">Excluir</button>
                      </td>
                  </tr>
              <?php endforeach; ?>
          </tbody>
      </table>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


    <script>
      const msgAlertaErroEdit = document.getElementById("msgAlertaErroEdit");
      async function excluirUsuario(id){
                const confirmar = confirm("Tem certeza que deseja deletar a reunião?");

                if (confirmar == true){
                    const data = await fetch('excluir_usuario.php?id=' + id);
                    const resposta = await data.json();
                    
                    if(resposta['erro']){
                        msgAlerta.innerHTML = resposta['msg'];
                    } else {
                        msgAlerta.innerHTML = resposta['msg'];
                        listarMissions(1);
                    }
                }
            }
    </script>


</body>

</html>
