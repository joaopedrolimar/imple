<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Verificar se o usuário é o proprietário
$is_owner = ($_SESSION["permissao"] === "owner");


include_once "./conexao.php";

// Consulta para obter os nomes dos usuários da tabela policiais
$query_usuarios = "SELECT username FROM policiais WHERE aprovado = 1";
$result_usuarios = $conn->query($query_usuarios);
$usuarios = $result_usuarios->fetchAll(PDO::FETCH_ASSOC);

// Verificar se o usuário é o proprietário
$is_owner = ($_SESSION["permissao"] === "owner");
?>
?>




<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>

    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">


    <link rel="stylesheet" href="./css/custom.css">

    <title>Intranet Calendario</title>

    <style>
        /* Altera a cor de fundo do Calendário FullCalendar para preto */
            .fc {
                background-color: #22c1c3;
                border: solid 20px 0px 20px 0px red;
             }

                         /* Altera a cor de fundo dos cabeçalhos do calendário */
            .fc-toolbar {
                background-color: #fff; /* escolha a cor que desejar */
                padding: 30px;
                text-transform: uppercase;
            }

            /* Altera a cor dos botões no cabeçalho do calendário */
            .fc-toolbar button {
                color: white; /* cor do texto */
                background-color: #555; /* cor de fundo */
                border-color: #555; /* cor da borda */
            }

            /* Altera a cor dos links */
            a {
                color: white;
            }

            /* Altera a cor do botão de hoje */
            .fc-today-button {
                color: white;
                background-color: #555;
                border-color: #555;
            }
            .chart-container {
            max-width: 800px; /* Largura máxima para o gráfico */
            margin: 0 auto; /* Centraliza o gráfico na página */
            margin-top: 20px; /* Espaçamento superior para separar do calendário */
        }

          

    </style>
</head>

<body>

<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <a class="navbar-brand d-flex align-items-center" href="/imple/index.php">
            <img src="./img/censipamLogo2.png" alt="Logo" width=" 80" height="80" class="d-inline-block align-text-top">
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

   

    <div id="calendar-container">
      <div id='calendar' style='margin-top: 100px;'></div>
    </div>



    <div class="chart-container">
        <canvas id="missionsChart"></canvas>
    </div>


    <div class="chart-container">
        <canvas id="missionsColumnChart"></canvas>
    </div>

   


       <!-- Contêiner do calendário com largura controlada -->
       <div id="calendar-container" class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div id='calendar' style='margin-top: 100px;'></div>
            </div>
        </div>
    </div>


    <!-- Botões com os nomes dos usuários centralizados e com espaçamento -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <?php foreach ($usuarios as $usuario) : ?>
                <div class="col-auto mb-2">
                    <a href="#" class="btn btn-primary user-button"><?= $usuario['username'] ?></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div> 




    <!-- Modal Visualizar -->
    <div class="modal fade" id="visualizarModal" tabindex="-1" aria-labelledby="visualizarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="visualizarModalLabel">Visualizar o Evento</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <dl class="row">

                        <dt class="col-sm-3">ID: </dt>
                        <dd class="col-sm-9" id="visualizar_id"></dd>
                        
                        <dt class="col-sm-3">Início: </dt>
                        <dd class="col-sm-9" id="visualizar_start"></dd>

                        <dt class="col-sm-3">Fim: </dt>
                        <dd class="col-sm-9" id="visualizar_end"></dd>

                        

                    </dl>

                </div>
            </div>
        </div>
    </div>
    



   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src='./js/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./js/bootstrap5/index.global.min.js"></script>
    <script src='./js/core/locales-all.global.min.js'></script>
    <script src='./js/custom.js'></script>

    <script>
    // Função para lidar com o clique nos botões de usuário
    document.addEventListener('DOMContentLoaded', function() {
        // Selecione todos os botões de usuário
        const userButtons = document.querySelectorAll('.user-button');

        // Adicione um evento de clique a cada botão
        userButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                // Evite que o link seja seguido
                event.preventDefault();

                // Obtenha o nome do usuário clicado
                const userName = this.textContent.trim();

                // Faça uma solicitação AJAX para recuperar os dados das missões do usuário
                fetch('get_user_missions.php?userName=' + encodeURIComponent(userName))

                    .then(response => response.json())
                    .then(data => {
                        // Dados recebidos com sucesso
                        console.log(data); // Aqui você pode manipular os dados como desejar, por exemplo, renderizar um gráfico
                    })
                    .catch(error => {
                        console.error('Erro ao obter dados das missões:', error);
                    });
            });
        });
    });
// Declarar a variável missionsChart fora da função renderMissionsChart
let missionsChart;

// Função para renderizar o gráfico de missões
function renderMissionsChart(data) {
    // Verifica se o gráfico já existe, se sim, destrua-o
    if (missionsChart) {
        missionsChart.destroy();
    }

    // Obtém o contexto do canvas do gráfico
    const ctx = document.getElementById('missionsChart').getContext('2d');

    // Cria o gráfico de barras
    missionsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            // Labels para o eixo X (nomes das missões)
            labels: data.map(missao => missao.motivacao),
            datasets: [{
                label: 'Missões do Usuário',
                // Dados para o eixo Y (quantidade de missões)
                data: data.map(missao => missao.id),
                // Personalizações adicionais do gráfico
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Quando um usuário clicar em um botão com o nome do usuário
document.querySelectorAll('.user-button').forEach(button => {
    button.addEventListener('click', function() {
        const userName = this.textContent; // Obtém o nome do usuário do texto do botão

        // Faça uma solicitação AJAX para obter os dados das missões desse usuário
        fetch('get_user_missions.php?userName=' + encodeURIComponent(userName))

            .then(response => response.json())
            .then(data => {
                // Dados recebidos com sucesso, agora renderize o gráfico com os novos dados
                renderMissionsChart(data);
            })
            .catch(error => {
                console.error('Erro ao obter dados das missões:', error);
            });
    });
});

// Função para atualizar o gráfico com os novos dados do usuário selecionado
function updateChart(data) {
    // Verifica se o gráfico já existe, se sim, destrua-o
    if (missionsChart) {
        missionsChart.destroy();
    }

    // Obtém o contexto do canvas do gráfico
    const ctx = document.getElementById('missionsChart').getContext('2d');

    // Cria o novo gráfico de barras com os dados atualizados
    missionsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            // Labels para o eixo X (nomes das missões)
            labels: data.map(missao => missao.motivacao),
            datasets: [{
                label: 'Missões do Usuário',
                // Dados para o eixo Y (quantidade de missões)
                data: data.map(missao => missao.id),
                // Personalizações adicionais do gráfico
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Quando um usuário clicar em um botão com o nome do usuário
document.querySelectorAll('.user-button').forEach(button => {
    button.addEventListener('click', function() {
        const userName = this.textContent; // Obtém o nome do usuário do texto do botão

        // Faça uma solicitação AJAX para obter os dados das missões desse usuário
        fetch('get_user_missions.php?userName=' + encodeURIComponent(userName))
            .then(response => response.json())
            .then(data => {
                // Dados recebidos com sucesso, agora atualize o gráfico com os novos dados
                updateChart(data);
            })
            .catch(error => {
                console.error('Erro ao obter dados das missões:', error);
            });
    });
});

</script>


</body>

</html>