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
    <title>Missões</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

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
        .btn-group-vertical .btn {
                margin-bottom: 9px; /* Adiciona uma margem entre os botões */
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
            .btn-group-vertical {
            display: flex;
            flex-direction: column;
            }
            .btn-group-vertical .btn {
                margin-bottom: 9px; /* Adiciona uma margem entre os botões */
            }

            
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
              
                <div class="inputWrapp">
                    <label for="ord">ORD:</label>
                    <input type="text" name="ord" id="ord" class="inputAfastamentos" required>
                </div>
                
                <p id="color">Color:</p>
                <select name="color" class="inputAfastamentos" id="color">
                    <option value="#054F77">Verde</option>
                </select>

                <div class="inputWrapp">
                    <label for="start">Início</label>
                    <input type="datetime-local" name="start" id="start" class="inputAfastamentos" required>
                </div>

                <div class="inputWrapp">
                    <label for="end">Término</label>
                    <input type="datetime-local" name="end" id="end" class="inputAfastamentos" required>
                </div>

                <div class="inputWrapp">
                    <label for="motivacao">Motivação</label>
                    <input type="text" name="motivacao" id="motivacao" class="inputAfastamentos" required>
                </div>

                <div class="inputWrapp">
                    <label for="participantes">Participantes</label>
                    <input type="text" name="participantes" id="participantes" class="inputAfastamentos">
                </div>

                <div class="inputWrapp">
                    <label for="funcao">Função</label>
                    <input type="text" name="funcao" id="funcao" class="inputAfastamentos">
                </div>


                <button type="submit"  class="enviar btn btn-primary">enviar</button>
        </form>
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

                        <dt class="col-sm-3">ORD:</dt>
                        <dd class="col-sm-9"><span id="idOrd"></span></dd>

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

                        <!--editar ORD-->
                        <div class="mb-3">
                            <label for="ord" class="col-form-label">ORD:</label>
                            <input type="text" name="ord" class="form-control" id="editOrd" placeholder="Digite o titulo">
                        </div>

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

                        <!--editar Função-->
                        <div class="mb-3">
                            <label for="funcao" class="col-form-label">Função:</label>
                            <input type="text" name="funcao" class="form-control" id="editFuncao" placeholder="Digite o nome">
                         </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Fechar</button>
                            <input type="submit" class="btn btn-outline-warning btn-sm" id="edit-usuario-btn" value="Salvar" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>








    <!-- JavaScript missões  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="js/bootstrap5/index.global.min.js"></script>

    <script>
        const msgAlerta = document.getElementById("msgAlerta");
        const editForm = document.getElementById("edit-usuario-form");
        const msgAlertaErroEdit = document.getElementById("msgAlertaErroEdit");
        //java pra enviar formulario
        const form = document.querySelector('#form');
        
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const dadosDoForm = new FormData (form);
            
            dadosDoForm.append("add", 1);

            const dados = await fetch("cadastrar_missoes.php", {
                method:"POST",
                body: dadosDoForm,
        
        });

        //java pra mostrar a tabela na tela
       const resposta =  await dados.json();
        // Recarregar a página após o envio do formulário
        if (!resposta.erro) {
             window.location.reload();
         }

        });

        const tbody = document.querySelector(".listar_missions");

        const listarMissions = async (pagina) => {
          const dadosMissions =  await fetch ("./tabelaMissions.php?pagina=" + pagina);
          const respostaMissions = await dadosMissions.text();
          tbody.innerHTML = respostaMissions;

        }

        listarMissions(1);

        //javaSc para visualizar pessoa da tabela
        
        
        async function visualizarMissoes(id){
            
            const dados = await fetch("visualizarMissions.php?id=" + id);
            const resposta = await dados.json();
            console.log(resposta);

            if(resposta['erro']){
                msgAlerta.innerHTML = resposta['msg']
            }else{
                const viswModal = new bootstrap.Modal(document.getElementById("visualizarMissions"));
                viswModal.show();

                document.getElementById("idId").innerHTML = resposta['dados'].id
                document.getElementById("idOrd").innerHTML = resposta['dados'].ord;
                document.getElementById("idType").innerHTML = resposta['dados'].tipo;
                document.getElementById("idColor").innerHTML = resposta['dados'].color
                document.getElementById("idStart").innerHTML = resposta['dados'].start
                document.getElementById("idEnd").innerHTML = resposta['dados'].end
                document.getElementById("idMotivacao").innerHTML = resposta['dados'].motivacao;
                document.getElementById("idParticipantes").innerHTML = resposta['dados'].participantes;
                document.getElementById("idFuncao").innerHTML = resposta['dados'].funcao;
            }
         }
 




        //java pra editar formulario

        async function editMissoes(id){
            const dados = await fetch("visualizarMissions.php?id=" + id);
            const resposta = await dados.json();
            //console.log(resposta);
        
            if(resposta['erro']){
                alert('erro usuario não encontrado');
            }else{
                const editModal =  new bootstrap.Modal(document.getElementById("editUsuarioModal"));
                editModal.show();
                document.getElementById("editid").value = resposta['dados'].id
                document.getElementById("editOrd").value = resposta['dados'].ord;
                document.getElementById("editStart").value = resposta['dados'].start
                document.getElementById("editEnd").value = resposta['dados'].end
                document.getElementById("editMotivacao").value = resposta['dados'].motivacao;
                document.getElementById("editParticipantes").value = resposta['dados'].participantes;
                document.getElementById("editFuncao").value = resposta['dados'].funcao;
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
        


    </script>

    
</body>

</html>
