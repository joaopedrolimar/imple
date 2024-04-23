<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Missões</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <style>

        

        .box{
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

        .box h2{
            text-align: center;
        }

        
        .inputUser{
            background-color: #fbfbfb; 
            width: 408px; 
            height: 40px; 
            border-radius: 10px;  
            border-style: solid; 
            border-width: 1px; 
            border-color: blue;  
            margin-bottom: 20px; 
        }

        .enviar{
            height: 45px; 
            text-transform: uppercase;
            border-radius: 10px;	
            width: 420px;   
            cursor: pointer;
            color: white;
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


    </style>

</head>

<body>
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
                    <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="inputUser" required>
                    </div>
                

                <p>color:</p>
                <select name="color" class="inputUser" id="color">
                    
                        <option value="#1F438C">azul</option>
                </select>
                
                    <div class="inputWrapp">
                        <label for="start"  >Start</label>
                        <input type="date" name="start" id="start" class="inputUser" required>
                    </div>
                
                    

                    <div class="inputWrapp">
                        <label for="end">End</label>
                        <input type="date" name="end" id="end" class="inputUser" required>
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

                        <dt class="col-sm-3">ID:</dt>
                        <dd class="col-sm-9"><span id="idId"></span></dd>

                        <dt class="col-sm-3">Missão:</dt>
                        <dd class="col-sm-9"><span id="idTitle"></span></dd>

                        <dt class="col-sm-3">Cor:</dt>
                        <dd class="col-sm-9"><span id="idColor"></span></dd>
                        
                        <dt class="col-sm-3">Início:</dt>
                        <dd class="col-sm-9"><span id="idStart"></span></dd>

                        <dt class="col-sm-3">Término</dt>
                        <dd class="col-sm-9"><span id="idEnd"></span></dd>

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

                        <!--editar titulo-->
                        <div class="mb-3">
                            <label for="nome" class="col-form-label">titulo:</label>
                            <input type="text" name="title" class="form-control" id="editTitle" placeholder="Digite o titulo">
                        </div>

                         <!--editar data inicio-->
                        <div class="mb-3">
                            <label for="start" class="col-form-label">Início:</label>
                            <input type="text" name="start" class="form-control" id="editStart"  onfocus="this.type='date'" 
                            onblur="if (!this.value) this.type='text'" >
                        </div>

                         <!--editar data fianl-->
                         <div class="mb-3">
                            <label for="end" class="col-form-label">Fim:</label>
                            <input type="text" name="end" class="form-control" id="editEnd"  onfocus="this.type='date'" 
                            onblur="if (!this.value) this.type='text'" >
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

            const dados = await fetch("cadastrar_evento.php", {
                method:"POST",
                body: dadosDoForm,
        
        });

        //java pra mostrar a tabela na tela
       const resposta =  await dados.json();
       console.log(resposta);

        });

        const tbody = document.querySelector(".listar_missions");

        const listarMissions = async (pagina) => {
          const dadosMissions =  await fetch ("./tabelaMissions.php?pagina=" + pagina);
          const respostaMissions = await dadosMissions.text();
          tbody.innerHTML = respostaMissions;

        }

        listarMissions(1);

        //javaSc para visualizar pessoa da tabela
        
        
        async function visualizarUsuario(id){
            
            const dados = await fetch("visualizarMissions.php?id=" + id);
            const resposta = await dados.json();
            console.log(resposta);

            if(resposta['erro']){
                msgAlerta.innerHTML = resposta['msg']
            }else{
                const viswModal = new bootstrap.Modal(document.getElementById("visualizarMissions"));
                viswModal.show();

                
                document.getElementById("idId").innerHTML = resposta['dados'].id
                document.getElementById("idTitle").innerHTML = resposta['dados'].title
                document.getElementById("idColor").innerHTML = resposta['dados'].color
                document.getElementById("idStart").innerHTML = resposta['dados'].start
                document.getElementById("idEnd").innerHTML = resposta['dados'].end
            }
         }
 




        //java pra editar formulario

        async function editUsuarioDados(id){
            const dados = await fetch("visualizarMissions.php?id=" + id);
            const resposta = await dados.json();
            //console.log(resposta);
        
            if(resposta['erro']){
                alert('erro usuario não encontrado');
            }else{
                const editModal =  new bootstrap.Modal(document.getElementById("editUsuarioModal"));
                editModal.show();
                document.getElementById("editid").value = resposta['dados'].id
                document.getElementById("editTitle").value = resposta['dados'].title
                document.getElementById("editStart").value = resposta['dados'].start
                document.getElementById("editEnd").value = resposta['dados'].end
            }
        }


        editForm.addEventListener("submit", async (e) => {
            e.preventDefault();

            const dadosDoForm = new FormData(editForm);

            //console.log(dadosDoForm)

           // for ( var dados  of dadosDoForm.entries()){
            //    console.log(dados[0] + ", " + dados[1])
           // }

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
        
        async function apagarUsuarioDados(id){
            
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
