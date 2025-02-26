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

          <li class="nav-item">
            <a class="nav-link" href="/imple/atividades/formAtividades.php">Atividades</a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" href="/imple/alterarSenha.php">Alterar Senha</a>
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
    

    
<div class="chart-container">
    <canvas id="missionsChart"></canvas>
</div>

<div class="chart-container">
    <canvas id="absencesChart"></canvas>
</div>

<div class="chart-container">
    <canvas id="reunioesChart"></canvas>
</div>





   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src='./js/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./js/bootstrap5/index.global.min.js"></script>
    <script src='./js/core/locales-all.global.min.js'></script>
    <script src='./js/custom.js'></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    <script>
   


/// Quando um usuário clicar em um botão com o nome do usuário
document.querySelectorAll('.user-button').forEach(button => {
    button.addEventListener('click', function() {
        const userName = this.textContent.trim(); // Obtém o nome do usuário do texto do botão

        // Faça uma solicitação AJAX para obter os dados das missões desse usuário
        fetch('get_user_missions.php?userName=' + encodeURIComponent(userName))
            .then(response => response.json())
            .then(missionsData => {
                // Dados de missões recebidos com sucesso, agora faça a solicitação para os afastamentos
                fetch('get_afastamentos_por_nome.php?userName=' + encodeURIComponent(userName))
                    .then(response => response.json())
                    .then(absencesData => {
                        // Dados de afastamentos recebidos com sucesso, agora faça a solicitação para as reuniões
                        fetch('get_reunioes_por_nome.php?userName=' + encodeURIComponent(userName))
                            .then(response => response.json())
                            .then(reuniaoData => {
                                // Dados de reuniões recebidos com sucesso, agora atualize todos os gráficos
                                updateCharts(missionsData, absencesData, reuniaoData);
                            })
                            .catch(error => {
                                console.error('Erro ao obter dados de reuniões:', error);
                            });
                    })
                    .catch(error => {
                        console.error('Erro ao obter dados de afastamentos:', error);
                    });
            })
            .catch(error => {
                console.error('Erro ao obter dados de missões:', error);
            });
    });
});

// Função para atualizar os gráficos
function updateCharts(missionsData, absencesData, reuniaoData) {
    renderMissionsChart(missionsData); // Renderiza o gráfico de missões
    renderAbsencesChart(absencesData); // Renderiza o gráfico de afastamentos
    renderMeetingsChart(reuniaoData); // Renderiza o gráfico de reuniões
}

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
                backgroundColor: 'rgba(54, 162, 235, 0.9)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label;
                        }
                    }
                }
            }
        }
    });
}

// Declarar a variável absencesChart fora da função renderAbsencesChart
let reunioesChart;

// Função para renderizar o gráfico de reuniões
function renderMeetingsChart(data) {
    // Verifica se o gráfico já existe, se sim, destrua-o
    if (reunioesChart instanceof Chart) {
        reunioesChart.destroy();
    }

    // Obtém o contexto do canvas do gráfico
    const ctx = document.getElementById('reunioesChart').getContext('2d');

    // Cria o gráfico de barras
    reunioesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            // Labels para o eixo X (nomes das reuniões)
            labels: data.map(reuniao => reuniao.motivacao), // Corrigido para 'nome' em vez de 'participantes'
            datasets: [{
                label: 'Reuniões do Usuário',
                // Dados para o eixo Y (quantidade de reuniões)
                data: data.map(reuniao => reuniao.id),
                // Personalizações adicionais do gráfico
                backgroundColor: 'rgba(240,230,140,0.9)',
                borderColor: 'rgba(255,215,0)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label;
                        }
                    }
                }
            }
        }
    });
}


// Declarar a variável absencesChart fora da função renderAbsencesChart
let absencesChart;

// Função para renderizar o gráfico de afastamentos
function renderAbsencesChart(data) {
    // Verifica se o gráfico de afastamentos já existe, se sim, destrua-o
    if (absencesChart instanceof Chart) {
        absencesChart.destroy();
    }

    // Obtém o contexto do canvas do gráfico de afastamentos
    const ctx = document.getElementById('absencesChart').getContext('2d');

    // Cria o gráfico de barras para os afasta
    absencesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.map(afastamento => afastamento.nome),
            datasets: [{
                label: 'Afastamentos do Usuário',
                data: data.map(afastamento => afastamento.total),
                backgroundColor: 'rgba(60, 179, 113, 0.9)',
                borderColor: 'rgba(60, 179, 113)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label;
                        }
                    }
                }
            }

        }
    });
}







</script>


</body>

</html>