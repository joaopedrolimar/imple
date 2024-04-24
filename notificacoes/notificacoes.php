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



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificações</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Adicione outros links CSS ou estilos personalizados aqui -->
</head>

<body>




<nav class="navbar navbar-dark bg-dark fixed-top ">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Intranet </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>
