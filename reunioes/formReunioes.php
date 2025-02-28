<!--/reunioes/formReunioes.php-->
<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Verificar se o usuário é o proprietário
$is_owner = ($_SESSION["permissao"] === "owner");

?>


<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reuniões</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">

    <style>
         /* Estilos gerais */
         body {
            background-color: #f8f9fa;
            color: #333;
        }

        /* Estilo do formulário */
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


        .titulo_reunioes {
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





    <div class="container">
        <div class="row mt-4">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <div>
                    <h4>Reuniões</h4>
                </div>
            </div>
        </div>
        <hr>

        <span id="msgAlerta"></span>

        <!-- Formulario Reuniões -->
        <div class="box">

<h2>Criar Nova Reunião</h2>

<form id="form" method="POST">

    <div class="inputWrapp">
        <label for="tipo">Tipo de Evento</label>
        <input type="text" name="tipo" id="tipo" class="inputAfastamentos" value="Reuniões" readonly>
    </div>

    <p id="color">Color:</p>
    <select name="color" class="inputAfastamentos" id="color">
        <option value="#EEAD2D">Amarelo</option>
    </select>

    <div class="inputWrapp">
        <label for="start">Início</label>
        <input type="date" name="start" id="start" class="inputAfastamentos" required>
    </div>

    <div class="inputWrapp">
        <label for="end">Término</label>
        <input type="date" name="end" id="end" class="inputAfastamentos" required>
    </div>

    <div class="inputWrapp">
        <label for="motivacao">Motivação</label>
        <input type="text" name="motivacao" id="motivacao" class="inputAfastamentos" required>
    </div>

    <div class="inputWrapp">
        <label for="participantes">Participantes</label>
        <input type="text" name="participantes" id="participantes" class="inputAfastamentos" >
    </div>

   
         <button type="submit" class="enviar btn btn-primary inputWrapp">enviar</button>
   
</form>
</div>

<input type="text" id="pesquisaReuniao" class="form-control" placeholder="Pesquisar por ID, motivação ou participantes...">
<span id="msgAlertaPesquisa"></span>


        <!-- TABELA de visualizar missões -->
        <div class="container ">
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div>
                        <h1 class="titulo_reunioes">Tabela Reuniões</h1>
                    </div>
                </div>
            </div>

            <div class="row ">

                <div class="col-lg-12">

                    <span class="listar_missions"></span>

                </div>

            </div>

        </div>

        <!-- modal pra visualizar reuniões -->

        <div class="modal fade" id="visualizarReunioes" tabindex="-1" aria-labelledby="visualizarReunioes" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="visualizarReunioes">Detalhes Reuniões</h5>
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
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal pra editar reunião -->

        <div class="modal fade" id="editReunioesModal" tabindex="-1" aria-labelledby="editReunioesModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editReunioesModalLabel">Editar Reunião</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <form id="edit-reunioes-form">
                            <span id="msgAlertaErroEdit"></span>

                            <input type="hidden" name="id" id="editid">

                            <div class="mb-3">
                                <label for="start" class="col-form-label">Início:</label>
                                <input type="date" name="start" class="form-control" id="editStart">
                            </div>

                            <div class="mb-3">
                                <label for="end" class="col-form-label">Fim:</label>
                                <input type="date" name="end" class="form-control" id="editEnd">
                            </div>

                            
                            <div class="mb-3">
                                <label for="motivacao" class="col-form-label">Motivação:</label>
                                <input type="text" name="motivacao" class="form-control" id="editMotivacao" placeholder="Digite o nome">
                            </div>


                            
                            <div class="mb-3">
                                <label for="participantes" class="col-form-label">Participantes:</label>
                                <input type="text" name="participantes" class="form-control" id="editParticipantes" placeholder="Digite o nome">
                            </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Fechar</button>
                                <input type="submit" class="btn btn-outline-warning btn-sm" id="edit-reunioes-btn" value="Salvar" />
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="chart-container">
            <canvas id="reunioesColumnChart"></canvas>
        </div>


        <!-- JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        
        <script src="./js/bootstrap5/index.global.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>

document.getElementById("pesquisaReuniao").addEventListener("keyup", async function() {
    let termo = this.value.trim();

    if (termo.length > 0) {
        const response = await fetch(`pesquisar_reunioes.php?termo=${termo}`);
        const tableHtml = await response.text();
        document.querySelector(".listar_missions").innerHTML = tableHtml;
    } else {
        listarMissions(1); // Recarrega todas as reuniões quando o campo de pesquisa estiver vazio
    }
});



            const msgAlerta = document.getElementById("msgAlerta");
            const editForm = document.getElementById("edit-reunioes-form");
            const msgAlertaErroEdit = document.getElementById("msgAlertaErroEdit");
            
            // JavaScript para enviar formulário
            const form = document.querySelector('#form');
            
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                const formData = new FormData(form);
                
                formData.append("add", 1);

                const response = await fetch("cadastrarReunioes.php", {
                    method: "POST",
                    body: formData,
                });

                const data = await response.json();
               // Recarregar a página após o envio do formulário
               if (!data.erro) {
                    window.location.reload();
                 }
            });



            
// JavaScript para navegar na tabela de missões sem rolar para o topo
const tbody = document.querySelector(".listar_missions");

const listarMissions = async (pagina) => {
    // Salva a posição atual da rolagem
    const scrollPosition = window.scrollY || window.pageYOffset;

    // Busca os dados da tabela de missões para a página especificada
    const response = await fetch("./tabelaReunioes.php?pagina=" + pagina);
    const tableHtml = await response.text();

    // Atualiza o conteúdo da tabela de missões
    tbody.innerHTML = tableHtml;

    // Restaura a posição da rolagem após a atualização da tabela
    window.scrollTo(0, scrollPosition);

    // Ou, se você quiser rolar para um elemento específico na tabela:
    // const table = document.getElementById('sua-tabela-id');
    // table.scrollIntoView({ behavior: 'smooth' });
};

// Chama a função para carregar a lista de missões quando a página é carregada
listarMissions(1);


            // JavaScript para visualizar reunião da tabela
            async function visualizarReunioes(id) {
    try {
        const response = await fetch("visualizarReunioes.php?id=" + id);
        const resposta = await response.json();

        if (resposta.erro) {
            alert(resposta.msg);
        } else {
            const viswModal = new bootstrap.Modal(document.getElementById("visualizarReunioes"));
            viswModal.show();

            document.getElementById("idType").innerHTML = resposta.dados.tipo;
            document.getElementById("idId").innerHTML = resposta.dados.id;
            document.getElementById("idColor").innerHTML = resposta.dados.color;
            document.getElementById("idStart").innerHTML = resposta.dados.start;
            document.getElementById("idEnd").innerHTML = resposta.dados.end;
            document.getElementById("idMotivacao").innerHTML = resposta.dados.motivacao;
            document.getElementById("idParticipantes").innerHTML = resposta.dados.participantes;
        }
    } catch (error) {
        console.error("Erro ao buscar dados da reunião:", error);
        alert("Erro ao carregar os dados da reunião. Tente novamente.");
    }
}


            // JavaScript para editar reunião
            async function editReunioes(id){
                const data = await fetch("visualizarReunioes.php?id=" + id);
                const resposta = await data.json();
                
                if(resposta['erro']){
                    alert('Erro: Reunião não encontrada');
                } else {
                    const editModal = new bootstrap.Modal(document.getElementById("editReunioesModal"));
                    editModal.show();

                    document.getElementById("editid").value = resposta['dados'].id;
                    document.getElementById("editStart").value = resposta['dados'].start;
                    document.getElementById("editEnd").value = resposta['dados'].end;
                    document.getElementById("editMotivacao").value = resposta['dados'].motivacao;
                    document.getElementById("editParticipantes").value = resposta['dados'].participantes;
                }
            }

            editForm.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(editForm);

                const response = await fetch("editReunioes.php", {
                    method: "POST",
                    body: formData,
                });

                const data = await response.json();

                if(data['erro']){
                    msgAlertaErroEdit.innerHTML = data['msg'];
                } else {
                    msgAlertaErroEdit.innerHTML = data['msg'];
                    listarMissions(1);
                }

                document.getElementById("edit-reunioes-btn").value = "Salvar";
            });

            // JavaScript para apagar registros
            async function apagarReunioes(id){
                const confirmar = confirm("Tem certeza que deseja deletar a reunião?");

                if (confirmar == true){
                    const data = await fetch('apagarReunioes.php?id=' + id);
                    const resposta = await data.json();
                    
                    if(resposta['erro']){
                        msgAlerta.innerHTML = resposta['msg'];
                    } else {
                        msgAlerta.innerHTML = resposta['msg'];
                        listarMissions(1);
                    }
                }
            }

    // Solicitação AJAX para obter os dados das reuniões
fetch('../get_reunioes_data.php')
 // Verifique se este caminho está correto
    .then(response => response.json())
    .then(data => {
        // Dados recebidos com sucesso, agora renderize o gráfico
        renderReunioesChart(data);
    })
    .catch(error => {
        console.error('Erro ao obter dados das reunioes:', error);
    });

    // Função para renderizar o gráfico de missões (colunas)
function renderReunioesColumnChart(data) {
    // Obtém o contexto do canvas do gráfico
    const ctx = document.getElementById('reunioesColumnChart').getContext('2d');

    // Cria o gráfico de colunas
    const reunioesColumnChart = new Chart(ctx, {
        type: 'bar',
        data: {
            // Labels para o eixo X (meses)
            labels: Object.keys(data),
            datasets: [{
                label: 'Reuniões por mês',
                // Dados para o eixo Y (número de missões)
                data: Object.values(data),
                // Personalizações adicionais do gráfico
                backgroundColor: 'rgba(240,230,140,0.9)',
                borderColor: 'rgba(255,215,0)',
                borderWidth: 1
            }]
        },
        options: {
            // Personalizações adicionais do gráfico, se necessário
        }
    });
}

// Solicitação AJAX para obter os dados das missões
fetch('../get_reunioes_data.php')
    .then(response => response.json())
    .then(data => {
        // Dados recebidos com sucesso, agora renderize o gráfico de colunas
        renderReunioesColumnChart(data);
    })
    .catch(error => {
        console.error('Erro ao obter dados das missões:', error);
    });

        


        </script>

    </div>

</body>

</html>
