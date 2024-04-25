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
    <title>Afastamentos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <style>
        .box {
            margin: 50px 0px 50px 0px;
            width: 460px;
            height: auto;
            margin: 80px auto;
            border-radius: 10px;
            padding-top: 30px;
            padding-bottom: 20px;
            background: rgba(0, 0, 0, 0.18);
            padding-left: 30px;
        }

        .box h2 {
            text-align: center;
        }

        .inputAfastamentos {
            background-color: #fbfbfb;
            width: 408px;
            height: 40px;
            border-radius: 10px;
            border-style: solid;
            border-width: 1px;
            border-color: blue;
            margin-bottom: 20px;
        }

        .enviar {
            height: 45px;
            text-transform: uppercase;
            border-radius: 10px;
            width: 420px;
            cursor: pointer;
            color: white;
        }

        .titulo_afastamentos {
            background-color: #333;
            padding: 12px;
            border-top-right-radius: 20px;
            font-weight: bolder;
            letter-spacing: .1em;
            color: white;
            font-family: monospace;
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

<div class="container">
        <div class="row mt-4">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <div>
                    <h4>Afastamentos</h4>
                </div>
            </div>
        </div>
        <hr>

        <span id="msgAlerta"></span>

        <!-- Formulário de Afastamentos -->
        <div class="box">

            <h2>Criar Novo Afastamento</h2>

            <form id="form" method="POST">

                <div class="inputWrapp">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="inputAfastamentos" required>
                </div>

                <div class="inputWrapp">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" class="inputAfastamentos" required>
                </div>


                <p>color:</p>
                <select name="color" class="inputAfastamentos" id="color">
                    <option value="#0d7909">Verde</option>
                </select>

                <div class="inputWrapp">
                    <label for="start">Start</label>
                    <input type="datetime-local" name="start" id="start" class="inputAfastamentos" required>
                </div>

                <div class="inputWrapp">
                    <label for="end">End</label>
                    <input type="datetime-local" name="end" id="end" class="inputAfastamentos" required>
                </div>

                <button type="submit" class="enviar btn btn-primary">enviar</button>
            </form>
        </div>

        <!-- Tabela de Afastamentos -->
        <div class="container ">
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div>
                        <h1 class="titulo_afastamentos">Tabela Afastamentos</h1>
                    </div>
                </div>
            </div>

            <div class="row ">

                <div class="col-lg-12">

                    <span class="listar_missions"></span>

                </div>

            </div>

        </div>

        <!-- Modal para visualizar afastamento -->
        <div class="modal fade" id="visualizarReunioes" tabindex="-1" aria-labelledby="visualizarReunioes" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="visualizarReunioes">Detalhes Afastamento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="msgAlertaErroVis"></span>
                        <dl class="row">
                            <dt class="col-sm-3">ID:</dt>
                            <dd class="col-sm-9"><span id="idId"></span></dd>
                            <dt class="col-sm-3">Afastamento:</dt>
                            <dd class="col-sm-9"><span id="idTitle"></span></dd>
                            <dt class="col-sm-3">Cor:</dt>
                            <dd class="col-sm-9"><span id="idColor"></span></dd>
                            <dt class="col-sm-3">Início:</dt>
                            <dd class="col-sm-9"><span id="idStart"></span></dd>
                            <dt class="col-sm-3">Término:</dt>
                            <dd class="col-sm-9"><span id="idEnd"></span></dd>
                            <dt class="col-sm-3">Nome:</dt>
                            <dd class="col-sm-9"><span id="idNome"></span></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar afastamento -->
        <div class="modal fade" id="editReunioesModal" tabindex="-1" aria-labelledby="editReunioesModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editReunioesModalLabel">Editar Afastamento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <form id="edit-reunioes-form">
                            <span id="msgAlertaErroEdit"></span>

                            <input type="hidden" name="id" id="editid">

                            <div class="mb-3">
                                <label for="title" class="col-form-label">Título:</label>
                                <input type="text" name="title" class="form-control" id="editTitle" placeholder="Digite o título">
                            </div>

                            <div class="mb-3">
                                <label for="nome" class="col-form-label">Nome:</label>
                                <input type="text" name="nome" class="form-control" id="editNome" placeholder="Digite o nome">
                            </div>

                            <div class="mb-3">
                                <label for="start" class="col-form-label">Início:</label>
                                <input type="text" name="start" class="form-control" id="editStart" onfocus="this.type='datetime-local'" onblur="if (!this.value) this.type='text'">
                            </div>

                            <div class="mb-3">
                                <label for="end" class="col-form-label">Fim:</label>
                                <input type="text" name="end" class="form-control" id="editEnd" onfocus="this.type='datetime-local'" onblur="if (!this.value) this.type='text'">
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

        <!-- JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        
        <script src="./js/bootstrap5/index.global.min.js"></script>

        <script>
            const msgAlerta = document.getElementById("msgAlerta");
            const editForm = document.getElementById("edit-reunioes-form");
            const msgAlertaErroEdit = document.getElementById("msgAlertaErroEdit");
            
            // JavaScript para enviar formulário
            const form = document.querySelector('#form');
            
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                const formData = new FormData(form);
                
                formData.append("add", 1);

                const response = await fetch("cadastrarAfastamentos.php", {
                    method: "POST",
                    body: formData,
                });

                const data = await response.json();
                console.log(data);
            });

            const tbody = document.querySelector(".listar_missions");

            const listarMissions = async (pagina) => {
                const data = await fetch("./tabelaAfastamentos.php?pagina=" + pagina);
                const resposta = await data.text();
                tbody.innerHTML = resposta;
            }

            listarMissions(1);

            // JavaScript para visualizar afastamento da tabela
            async function visualizarReunioes(id){
                const data = await fetch("visualizarAfastamentos.php?id=" + id);
                const resposta = await data.json();
                console.log(resposta);

                if(resposta['erro']){
                    msgAlerta.innerHTML = resposta['msg']
                } else {
                    const viswModal = new bootstrap.Modal(document.getElementById("visualizarReunioes"));
                    viswModal.show();

                    document.getElementById("idId").innerHTML = resposta['dados'].id;
                    document.getElementById("idTitle").innerHTML = resposta['dados'].title;
                    document.getElementById("idColor").innerHTML = resposta['dados'].color;
                    document.getElementById("idStart").innerHTML = resposta['dados'].start;
                    document.getElementById("idEnd").innerHTML = resposta['dados'].end;
                    document.getElementById("idNome").innerHTML = resposta['dados'].nome;
                }
            }

            // JavaScript para editar afastamento
            async function editReunioes(id){
                const data = await fetch("visualizarAfastamentos.php?id=" + id);
                const resposta = await data.json();
                
                if(resposta['erro']){
                    alert('Erro: Afastamento não encontrado');
                } else {
                    const editModal = new bootstrap.Modal(document.getElementById("editReunioesModal"));
                    editModal.show();

                    document.getElementById("editid").value = resposta['dados'].id;
                    document.getElementById("editTitle").value = resposta['dados'].title;
                    document.getElementById("editStart").value = resposta['dados'].start;
                    document.getElementById("editEnd").value = resposta['dados'].end;
                    document.getElementById("editNome").value = resposta['dados'].nome;
                }
            }

            editForm.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(editForm);

                const response = await fetch("editAfastamentos.php", {
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
                const confirmar = confirm("Tem certeza que deseja deletar o afastamento?");

                if (confirmar == true){
                    const data = await fetch('apagarAfastamentos.php?id=' + id);
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

    </div>

</body>

</html>

