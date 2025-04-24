<!--/missoes/form.php-->
<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Verificar se o usuário é o proprietário
$is_owner = ($_SESSION["permissao"] === "owner");

// Conexão com o banco
include '../conexao.php';

// Consulta para pegar os usuários cadastrados
$query = "SELECT id, username FROM policiais"; 
  // Ajuste 'usuarios' para o nome correto da tabela
$result = $conn->query($query);

// Query para campo 'elaborado_por'
$queryElaborado = "SELECT id, username FROM policiais";
$resultElaborado = $conn->query($queryElaborado);

// Query para campo 'participantes'
$queryPart = "SELECT id, username FROM policiais";
$stmtPart = $conn->prepare($queryPart);
$stmtPart->execute();
?>


<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Missões</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">

    <style>
        .box {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0px 0px 15px 0px rgba(0, 0, 0, 0.1);
        }

        .box h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .box label {
            font-weight: bold;
        }
        #color{
            font-weight: bold;
        }

        .inputAfastamentos {
            width: 100%;
            height: 40px;
            margin-bottom: 20px;
            padding: 5px 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            background-color: #f8f9fa;
        }

        .inputWrapp p {
            margin-top: 10px;
            margin-bottom: 5px;
            color: #333;
        }

        .enviar {
            width: 100%;
            height: 45px;
            text-transform: uppercase;
            border-radius: 10px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            border: none;
        }

        .enviar:hover {
            background-color: #0056b3;
        }
        .titulo_missions{
            background-color: #333;
            padding: 12px;
            border-top-right-radius: 20px;
            font-weight: bolder;
            letter-spacing: .1em;
            color: white;
            font-family: monospace;
        }
        .btn-group .btn {
                
                margin: 9px;
                display: flex; /* Exibe os botões em linha */
            }

                /* Estilos para dispositivos móveis */
                @media (max-width: 768px) {
            .box {
                width: 90%;
                padding: 20px;
            }
            .inputAfastamentos {
                width: 100%;
            }
            .btn-group {
            display: flex;
            flex-direction: column;
            }
            .btn-group .btn {
                margin-bottom: 9px; /* Adiciona uma margem entre os botões */
            }

            
        }

        .chart-container {
            max-width: 800px; /* Largura máxima para o gráfico */
            margin: 0 auto; /* Centraliza o gráfico na página */
            margin-top: 20px; /* Espaçamento superior para separar do calendário */
        }
        



    </style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

<!-- Começo do Nav -->
<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <a class="navbar-brand d-flex align-items-center" href="/imple/index.php">
            <img src="../img/censipamLogo2.png" alt="Logo" width=" 80" height="80" class="d-inline-block align-text-top">
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
<!-- Fim do Nav -->




    <a href="/imple/index.php">voltar pro calendario </a>

    

    <div class="container">
        <div class="row mt-4">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <div>
                    <h4>Missões</h4>
                </div>
            </div>
        </div>
        <hr>

        <span id="msgAlerta"></span>
    

    <!-- Formulario  missões  -->
    <div class="box">

    <h2>Criar Nova Missão</h2>

        <form id="form" method="POST">


                <div class="inputWrapp">
                    <label for="tipo">Tipo de Evento</label>
                    <input type="text" name="tipo" id="tipo" class="inputAfastamentos" value="Reuniões" readonly>
                </div>
              


                <!-- Cor-->
                <p id="color">Color:</p>
                <select name="color" class="inputAfastamentos" id="color">
                    <option value="#054F77">Verde</option>
                </select>

                <!-- Inicio-->
                <div class="inputWrapp">
                    <label for="start">Início</label>
                    <input type="date" name="start" id="start" class="inputAfastamentos" required>
                </div>

                <!--Termino -->
                <div class="inputWrapp">
                    <label for="end">Término</label>
                    <input type="date" name="end" id="end" class="inputAfastamentos" required>
                </div>

                <!-- Motivação -->
                <div class="inputWrapp">
                    <label for="motivacao">Motivação</label>
                    <input type="text" name="motivacao" id="motivacao" class="inputAfastamentos" required>
                </div>

                <!--PARTICIPANTES-->
                <div class="inputWrapp">
                    <label for="participantes">Participantes</label>
                    <select name="participantes[]" id="participantes" class="form-control" multiple>
                        <?php while ($row_part = $stmtPart->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option value="<?= $row_part['id'] ?>"><?= htmlspecialchars($row_part['username']) ?></option>
                        <?php endwhile; ?>
                    </select>
                    <small>(Segure Ctrl ou Shift para escolher vários)</small>
                </div>
                
                <!--Elaborado por -->
                <div class="inputWrapp">
                    <label for="elaborado_por">Elaborado por:</label>
                    <select name="elaborado_por" id="elaborado_por" class="form-control">
                        <option value="">Selecione um usuário</option>
                        <?php while ($row = $resultElaborado->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option value="<?= $row['id']; ?>"><?= htmlspecialchars($row['username']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!--Função -->
                <div class="inputWrapp">
                    <label for="funcao">Função</label>
                    <input type="text" name="funcao" id="funcao" class="inputAfastamentos">
                </div>

                <!--Botão de enviar- -->
                <button type="submit"  class="enviar btn btn-primary">enviar</button>
        </form>
    </div>
<!--Fim do Formulario de missoes -->

<!-- -->

    <div class="container mt-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Pesquisar missão por motivação, participantes ou elaborador..." onkeyup="pesquisarMissions()">
    </div>


    <!-- TABELA de  visualizar missões  -->
    <div class="container ">
        <div class="row mt-4">
            <div class="col-lg-12">
                <div>
                <h1 class="titulo_missions">Tabela missões</h1>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-lg-12">
                <span class="listar_missions"></span>
            </div>
        </div>
    </div>
    <!--Fim da tabela de missões- -->



    <!-- modal pra visualizar missões  -->

    <div class="modal fade" id="visualizarMissions" tabindex="-1" aria-labelledby="visualizarMissions" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visualizarMissions">Detalhes da Missão </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span id="msgAlertaErroVis"></span>
                    <dl class="row">

                        <dt class="col-sm-3">TIPO:</dt>
                        <dd class="col-sm-9"><span id="idType"></span></dd>

                        <dt class="col-sm-3">ID:</dt>
                        <dd class="col-sm-9"><span id="idId"></span></dd>


                        <dt class="col-sm-3">Cor:</dt>
                        <dd class="col-sm-9"><span id="idColor"></span></dd>
                            
                        <dt class="col-sm-3">Início:</dt>
                        <dd class="col-sm-9"><span id="idStart"></span></dd>

                        <dt class="col-sm-3">Término</dt>
                        <dd class="col-sm-9"><span id="idEnd"></span></dd>

                        <dt class="col-sm-3">Motivação:</dt>
                        <dd class="col-sm-9"><span id="idMotivacao"></span></dd>

                        <dt class="col-sm-3">Participantes:</dt>
                        <dd class="col-sm-9"><span id="idParticipantes"></span></dd>

                        <dt class="col-sm-3">Função:</dt>
                        <dd class="col-sm-9"><span id="idFuncao"></span></dd>


                    </dl>
                </div>

            </div>
        </div>
    </div>


    <!--modal pra editar usuario -->

    <div class="modal fade" id="editUsuarioModal" tabindex="-1" aria-labelledby="editUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUsuarioModalLabel">Editar Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <form id="edit-usuario-form">
                        <span id="msgAlertaErroEdit"></span>

                        <input type="hidden" name="id" id="editid">


                         <!--editar data inicio-->
                        <div class="mb-3">
                            <label for="start" class="col-form-label">Início:</label>
                            <input type="text" name="start" class="form-control" id="editStart"  onfocus="this.type='datetime-local'" 
                            onblur="if (!this.value) this.type='text'" >
                        </div>

                         <!--editar data fianla-->
                         <div class="mb-3">
                            <label for="end" class="col-form-label">Fim:</label>
                            <input type="text" name="end" class="form-control" id="editEnd"  onfocus="this.type='datetime-local'" 
                            onblur="if (!this.value) this.type='text'" >
                        </div>

                         <!--editar motivação-->
                        <div class="mb-3">
                            <label for="motivacao" class="col-form-label">Motivação:</label>
                            <input type="text" name="motivacao" class="form-control" id="editMotivacao" placeholder="Digite o nome">
                         </div>

                        <!--editar Participantes-->
                         <div class="mb-3">
                            <label for="participantes" class="col-form-label">Participantes:</label>
                            <input type="text" name="participantes" class="form-control" id="editParticipantes" placeholder="Digite o nome">
                         </div>


                         <div class="mb-3">
                            <label for="editElaboradoPor" class="col-form-label">Elaborado por:</label>
                            <select name="elaborado_por" class="form-control" id="editElaboradoPor">
                                <option value=""></option>
                                <?php
                                include "../conexao.php";
                                $query = "SELECT id, username FROM policiais";
                                $result = $conn->query($query);
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) : ?>
                                    <option value="<?= $row['id']; ?>"><?= htmlspecialchars($row['username']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!--editar Função-->
                        <div class="mb-3">
                            <label for="funcao" class="col-form-label">Função:</label>
                            <input type="text" name="funcao" class="form-control" id="editFuncao" placeholder="Digite o nome">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Fechar</button>
                            <input type="submit" class="btn btn-outline-warning btn-sm" id="edit-usuario-btn" value="Salvar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <div class="chart-container">
        <div class="card shadow rounded p-4">
            <h5 class="mb-4 text-center">📊 Missões por Mês</h5>
            <canvas id="missionsColumnChart" style="height: 300px;"></canvas>
        </div>
    </div>

    <div class="chart-container">
        <div class="card shadow rounded p-4">
            <h5 class="text-center">📅 Missões por Ano</h5>
            <canvas id="missionsByYearChart"></canvas>
        </div>
    </div>

    <div class="chart-container">
  <div class="card shadow rounded p-4">
    <h5 class="text-center">🧑‍🔧 Missões por Função</h5>
    <canvas id="missionsByFuncaoChart"></canvas>
  </div>
</div>

<div class="chart-container">
  <div class="card shadow rounded p-4">
    <h5 class="text-center">📆 Missões por Mês (Selecionar Ano)</h5>
    <select id="selectAno" class="form-select mb-3">
        <option value="2023">2023</option>
        <option value="2024" selected>2024</option>
        <option value="2025">2025</option>
    </select>
    <canvas id="missionsByMonthChart"></canvas>
  </div>
</div>

<div class="chart-container">
  <div class="card shadow rounded p-4">
    <h5 class="text-center">🤝 Elaboradas vs Participadas</h5>
    <canvas id="elaboradasVsParticipadasChart"></canvas>
  </div>
</div>
   



    <!-- JavaScript missões  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
   
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    

    <script>

function pesquisarMissions() {
    let termo = document.getElementById("searchInput").value;

    fetch(`pesquisar_missoes.php?termo=${termo}`)
        .then(response => response.text())
        .then(data => {
            document.querySelector(".listar_missions").innerHTML = data;
        })
        .catch(error => console.error("Erro ao buscar missões:", error));
}

        const msgAlerta = document.getElementById("msgAlerta");
        const editForm = document.getElementById("edit-usuario-form");
        const msgAlertaErroEdit = document.getElementById("msgAlertaErroEdit");

        
        //java pra enviar formulario
        const form = document.querySelector('#form');

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const dadosDoForm = new FormData(form);
    dadosDoForm.append("add", 1);

    try {
        const resposta = await fetch("cadastrar_missoes.php", {
            method: "POST",
            body: dadosDoForm
        });

        const resultado = await resposta.json();

        if (resultado.erro) {
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: resultado.msg.replace(/<[^>]*>/g, '')
            });
        } else {
            Swal.fire({
                icon: 'success',
                title: 'Missão cadastrada com sucesso!',
                showConfirmButton: false,
                timer: 2000,
                didClose: () => {
                    window.location.reload();
                }
            });
        }
    } catch (err) {
        Swal.fire({
            icon: 'error',
            title: 'Erro inesperado',
            text: 'Não foi possível completar a operação.'
        });
    }
});



// JavaScript para navegar na tabela de missões sem rolar para o topo
const tbody = document.querySelector(".listar_missions");

const listarMissions = async (pagina) => {
    // Salva a posição atual da rolagem
    const scrollPosition = window.scrollY || window.pageYOffset;

    // Busca os dados da tabela de missões para a página especificada
    const response = await fetch("./tabelaMissions.php?pagina=" + pagina);
    const tableHtml = await response.text();

    // Atualiza o conteúdo da tabela de missões
    tbody.innerHTML = tableHtml;

    // Restaura a posição da rolagem após a atualização da tabela
    window.scrollTo(0, scrollPosition);


};

// Chama a função para carregar a lista de missões quando a página é carregada
listarMissions(1);


        

        //javaSc para visualizar pessoa da tabela
        
        async function visualizarMissoes(id) {
    try {
        const response = await fetch(`visualizarMissions.php?id=${id}`);
        const text = await response.text(); // Captura a resposta bruta

        console.log("Resposta bruta:", text); // Veja se há HTML antes do JSON

        const data = JSON.parse(text); // Converte manualmente para JSON

        if (data.erro) {
            msgAlerta.innerHTML = data.msg;
        } else {
            const viswModal = new bootstrap.Modal(document.getElementById("visualizarMissions"));
            viswModal.show();

            document.getElementById("idId").innerHTML = data.dados.id;
            document.getElementById("idType").innerHTML = data.dados.tipo;
            document.getElementById("idStart").innerHTML = new Date(data.dados.start).toLocaleDateString('pt-BR');
document.getElementById("idEnd").innerHTML = new Date(data.dados.end).toLocaleDateString('pt-BR');

            document.getElementById("idMotivacao").innerHTML = data.dados.motivacao;
            document.getElementById("idParticipantes").innerHTML = data.dados.participantes;
            document.getElementById("idFuncao").innerHTML = data.dados.funcao;
        }
    } catch (error) {
        console.error("Erro ao processar JSON:", error);
    }
}


        //java pra editar formulario

        async function editMissoes(id) {
    try {
        const response = await fetch("visualizarMissions.php?id=" + id);
        const resposta = await response.json();

        if (resposta.erro) {
            alert("Erro: Missão não encontrada.");
            return;
        }

        const editModal = new bootstrap.Modal(document.getElementById("editUsuarioModal"));
        editModal.show();

        document.getElementById("editid").value = resposta.dados.id;
        document.getElementById("editStart").value = resposta.dados.start;
        document.getElementById("editEnd").value = resposta.dados.end;
        document.getElementById("editMotivacao").value = resposta.dados.motivacao;
        document.getElementById("editParticipantes").value = resposta.dados.participantes;
        document.getElementById("editFuncao").value = resposta.dados.funcao;

        // Preencher o campo "Elaborado por"
        const elaboradoSelect = document.getElementById("editElaboradoPor");
        elaboradoSelect.value = resposta.dados.elaborado_por_id;

    } catch (error) {
        console.error("Erro ao carregar dados para edição:", error);
    }
}




        editForm.addEventListener("submit", async (e) => {
            e.preventDefault();

            const dadosDoForm = new FormData(editForm);

           const dados = await fetch("editMissions.php", {
            method: "POST",
            body:dadosDoForm
        });

        const resposta = await dados.json();
        console.log(resposta)



        //RESPOSTA DE SE DEU CERTO OU ERRADO
       if(resposta['erro']){
            msgAlertaErroEdit.innerHTML = resposta['msg'];
        }else{
            msgAlertaErroEdit.innerHTML = resposta['msg'];
            listarMissions(1);

        }

        document.getElementById("edit-usuario-btn").value = "Salvar";


        })

        //javaScript para apagar registros
        
        async function apagarMissoes(id){
            
            //alerta perguntando se quer realmente deletar
            var confirmar = confirm("Tem certeza que deseja deletar a missão?")

            //alerta pergunando se deseja deletar
            if (confirmar == true){
                const dados = await fetch('apagar.php?id=' + id);

                const resposta = await dados.json();
                if(resposta['erro']){
                    msgAlerta.innerHTML = resposta['msg']
                }else{
                    msgAlerta.innerHTML = resposta['msg']
                    listarMissions(1);
                    }
                }

            }




    // Função para renderizar o gráfico de missões (colunas)
    function renderMissionsColumnChart(data) {
    const ctx = document.getElementById('missionsColumnChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(data),
            datasets: [{
                label: 'Missões',
                data: Object.values(data),
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                borderRadius: 5,
                barThickness: 30
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#333',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#54a0ff',
                    borderWidth: 1
                },
                title: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#333',
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    },
                    ticks: {
                        color: '#333'
                    }
                }
            }
        }
    });
}


// Solicitação AJAX para obter os dados das missões
fetch('../get_missions_data.php')
    .then(response => response.json())
    .then(data => {
        // Dados recebidos com sucesso, agora renderize o gráfico de colunas
        renderMissionsColumnChart(data);
    })
    .catch(error => {
        console.error('Erro ao obter dados das missões:', error);
    });

    // Missões por Ano
fetch("../get_missions_by_year.php")
  .then(res => res.json())
  .then(data => {
    new Chart(document.getElementById("missionsByYearChart"), {
      type: "line",
      data: {
        labels: Object.keys(data),
        datasets: [{
          label: "Missões por Ano",
          data: Object.values(data),
          backgroundColor: "rgba(75, 192, 192, 0.3)",
          borderColor: "rgba(75, 192, 192, 1)",
          fill: true,
          tension: 0.3
        }]
      }
    });
  });

// Missões por Função
fetch("../get_missions_by_funcao.php")
  .then(res => res.json())
  .then(data => {
    new Chart(document.getElementById("missionsByFuncaoChart"), {
      type: "doughnut",
      data: {
        labels: Object.keys(data),
        datasets: [{
          label: "Funções",
          data: Object.values(data),
          backgroundColor: [
            "#4e73df", "#1cc88a", "#36b9cc", "#f6c23e", "#e74a3b"
          ]
        }]
      }
    });
  });

// Missões por Mês com Filtro por Ano
const selectAno = document.getElementById("selectAno");
const renderMonthlyChart = (ano) => {
  fetch(`../get_missions_by_month.php?ano=${ano}`)
    .then(res => res.json())
    .then(data => {
      new Chart(document.getElementById("missionsByMonthChart"), {
        type: "bar",
        data: {
          labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
          datasets: [{
            label: `Missões em ${ano}`,
            data: Object.values(data),
            backgroundColor: "rgba(255, 99, 132, 0.7)"
          }]
        }
      });
    });
};
renderMonthlyChart(selectAno.value);
selectAno.addEventListener("change", e => renderMonthlyChart(e.target.value));

// Elaboradas vs Participadas
fetch("../get_elaboradas_vs_participadas.php")
  .then(res => res.json())
  .then(data => {
    const allUsers = [...new Set([...Object.keys(data.elaboradas), ...Object.keys(data.participadas)])];
    const elaboradas = allUsers.map(u => data.elaboradas[u] || 0);
    const participadas = allUsers.map(u => data.participadas[u] || 0);

    new Chart(document.getElementById("elaboradasVsParticipadasChart"), {
      type: "bar",
      data: {
        labels: allUsers,
        datasets: [
          {
            label: "Elaboradas",
            data: elaboradas,
            backgroundColor: "rgba(54, 162, 235, 0.7)"
          },
          {
            label: "Participadas",
            data: participadas,
            backgroundColor: "rgba(255, 206, 86, 0.7)"
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          tooltip: { mode: 'index', intersect: false }
        }
      }
    });
  });

        

    </script>


    
</body>

</html>
