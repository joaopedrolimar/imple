<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Verificar se o usuário é o proprietário
$is_owner = ($_SESSION["permissao"] === "owner");

include_once "../conexao.php";

// Consulta para obter os nomes dos usuários da tabela policiais
$query_usuarios = "SELECT username FROM policiais WHERE aprovado = 1";
$result_usuarios = $conn->query($query_usuarios);
$usuarios = $result_usuarios->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atividades</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/css/multi-select-tag.css">

    

    

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

        .inputAtividades{
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

        .titulo_atividades {
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
            .inputAtividades {
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
                    <h4>Afastamentos</h4>
                </div>
            </div>
        </div>
        <hr>

        <span id="msgAlerta"></span>

        <!-- Formulário de Afastamentos -->
        <div class="box">

            <h2>Criar Nova Atividade</h2>

            <form id="form" method="POST">

                <div class="inputWrapp">
                    <label for="tipo">Tipo de Evento</label>
                    <input type="text" name="tipo" id="tipo" class="inputAtividades" value="Atividades" readonly>
                </div>

                <div class="inputWrapp">
                    <label for="ord">ORD:</label>
                    <input type="text" name="ord" id="ord" class="inputAtividades" required>
                </div>

                <div class="inputWrapp">
                    <label for="produto">Produto:</label>
                    <input type="text" name="produto" id="produto" class="inputAtividades" required>
                </div>

                <div class="inputWrapp">
                    <label for="quantidade">Quantidade:</label>
                    <input type="text" name="quantidade" id="quantidade" class="inputAtividades" required>
                </div>

                <div class="inputWrapp">
                    <label for="data">Data:</label>
                    <input type="date" name="data" id="data" class="inputAtividades" required>
                </div>

                <div class="inputWrapp">
                    <label for="hora">H/H:</label>
                    <input type="text" name="hora" id="hora" class="inputAtividades" required>
                </div>

                <div class="inputWrapp">
                    <label for="solicitante_cliente">Solicitane/Cliente:</label>
                    <input type="text" name="solicitante_cliente" id="solicitante_cliente" class="inputAtividades" required>
                </div>

                <div class="inputWrapp">
                    <label for="documento">Documento:</label>
                   
                    <select name="documento" id="documento" class="inputAtividades">
                        <option value="">Selecionar</option>
                        <option value="documento A">Documento A</option>
                        <option value="documento B">Documento B</option>
                        <option value="documento C">Documento C</option>
                                                <option value="documento B">Documento B</option>
                        <option value="documento C">Documento C</option>
                    </select>
                </div>

               
                <div class="inputWrapp">
                    <label for="elaborado_por">Elaborado por:</label>

                    <select class="inputAtividades" name="elaborado_por[]" id="elaborado_por"  multiple>

                        <?php foreach ($usuarios as $usuario) : ?>
                            <option value="<?php echo $usuario['username']; ?>">
                                <?php echo $usuario['username']; ?>
                            </option>
                        <?php endforeach; ?>
                        

                    </select>
                </div>
                <br>



               
                     <button type="submit" class="enviar btn btn-primary inputWrapp" name="elaborado_por" value="<?php echo $_SESSION['user_id']; ?>" >enviar</button>
               
            </form>
        </div>

        <!-- Tabela de Afastamentos -->
        <div class="container ">
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div>
                        <h1 class="titulo_atividades">Tabela Atividades</h1>
                    </div>
                </div>
            </div>

            <div class="row ">

                <div class="col-lg-12">

                    <span class="listar_atividades"></span>

                </div>

            </div>

        </div>

        <!-- Modal para visualizar atividaes -->
        <div class="modal fade" id="visualizarAtividades" tabindex="-1" aria-labelledby="visualizarAtividades" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="visualizarAtividades">Detalhes Atividades</h5>
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
                            <dt class="col-sm-3">Produto:</dt>
                            <dd class="col-sm-9"><span id="idProduto"></span></dd>
                            <dt class="col-sm-3">Quantidade:</dt>
                            <dd class="col-sm-9"><span id="idQuantidade"></span></dd>
                            <dt class="col-sm-3">Data:</dt>
                            <dd class="col-sm-9"><span id="idData"></span></dd>
                            <dt class="col-sm-3">H/H:</dt>
                            <dd class="col-sm-9"><span id="idHora"></span></dd>
                            <dt class="col-sm-3">Solicitante:</dt>
                            <dd class="col-sm-9"><span id="idSolicitante_cliente"></span></dd>
                            <dt class="col-sm-3">Documento:</dt>
                            <dd class="col-sm-9"><span id="idDocumento"></span></dd>
                            <dt class="col-sm-3">Elaborado por:</dt>
                            <dd class="col-sm-9"><span id="idElaborado_por"></span></dd>

                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar atividades -->
        <div class="modal fade" id="editAtividadesModal" tabindex="-1" aria-labelledby="editAtividadesModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAtividadesModalLabel">Editar Afastamento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <form id="edit-reunioes-form">
                            <span id="msgAlertaErroEdit"></span>

                            <input type="hidden" name="id" id="editid">

                            <div class="mb-3">
                                <label for="ord" class="col-form-label">ORD:</label>
                                <input type="text" name="ord" class="form-control" id="editOrd" placeholder="Digite a ORD">
                            </div>
                            
                            <div class="mb-3">
                                <label for="produto" class="col-form-label">Produto:</label>
                                <input type="text" name="produto" class="form-control" id="editProduto" placeholder="Digite o Produto">
                            </div>

                            <div class="mb-3">
                                <label for="quantidade" class="col-form-label">Quantidade:</label>
                                <input type="text" name="quantidade" class="form-control" id="editQuantidade" placeholder="Digite o Quantidade">
                            </div>

                            <div class="mb-3">
                                <label for="data" class="col-form-label">Data:</label>
                                <input type="date" name="data" class="form-control" id="editData">
                            </div>

                            <div class="mb-3">
                                <label for="hora" class="col-form-label">H/H:</label>
                                <input type="text" name="hora" class="form-control" id="editHora" >
                            </div>

                            <div class="mb-3">
                                <label for="solicitante_cliente" class="col-form-label">Solicitante:</label>
                                <input type="text" name="solicitante_cliente" class="form-control" id="editSolicitante_cliente" placeholder="Digite o nome">
                            </div>

                            <div class="mb-3">
                                <label for="documento" class="col-form-label">Documento:</label>
                                    <select name="documento" id="editDocumento" class="form-control">
                                        <option value="documento A">Documento A</option>
                                        <option value="documento B">Documento B</option>
                                        <option value="documento C">Documento C</option>
                                    </select>
                            </div>

                            <div class="mb-3">
                                <label for="elaborado_por" class="col-form-label">Elaborado por:</label>
                                <input type="text" name="elaborado_por" class="form-control" id="editElaborado_por" placeholder="Digite o nome">
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
        
        <script src="../js/bootstrap5/index.global.min.js"></script>


        <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/js/multi-select-tag.js"></script>
        <script>
            new MultiSelectTag  ('elaborado_por')  // id
        </script>

        

        <script>
            const msgAlerta = document.getElementById("msgAlerta");
            const editForm = document.getElementById("edit-reunioes-form");
            const msgAlertaErroEdit = document.getElementById("msgAlertaErroEdit");
            
            const form = document.querySelector('#form');
            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const formData = new FormData(form);

                // Converter os valores selecionados em um array
                const selectedUsers = Array.from(formData.getAll('elaborado_por[]'));

                // Substituir o valor de elaborado_por com o array de usuários selecionados
                formData.set('elaborado_por', JSON.stringify(selectedUsers));

                formData.append("add", 1);

                const response = await fetch("cadastrarAtividades.php", {
                    method: "POST",
                    body: formData,
                });

                const data = await response.json();

                // Recarregar a página após o envio do formulário
                if (!data.erro) {
                    window.location.reload();
                }
            });


            const tbody = document.querySelector(".listar_atividades");

            const listarMissions = async (pagina) => {
                const data = await fetch("./tabelaAtividades.php?pagina=" + pagina);
                const resposta = await data.text();
                tbody.innerHTML = resposta;
            }

            listarMissions(1);

            // JavaScript para visualizar atividades da tabela
            async function visualizarAtividades(id){
                const data = await fetch("visualizarAtividades.php?id=" + id);
                const resposta = await data.json();
                console.log(resposta);

                if(resposta['erro']){
                    msgAlerta.innerHTML = resposta['msg']
                } else {
                    const viswModal = new bootstrap.Modal(document.getElementById("visualizarAtividades"));
                    viswModal.show();

                    document.getElementById("idType").innerHTML = resposta['dados'].tipo;
                    document.getElementById("idId").innerHTML = resposta['dados'].id;
                    document.getElementById("idOrd").innerHTML = resposta['dados'].ord;
                    document.getElementById("idProduto").innerHTML = resposta['dados'].produto;
                    document.getElementById("idQuantidade").innerHTML = resposta['dados'].quantidade;
                    document.getElementById("idData").innerHTML = resposta['dados'].data;
                    document.getElementById("idHora").innerHTML = resposta['dados'].hora;
                    document.getElementById("idSolicitante_cliente").innerHTML = resposta['dados'].solicitante_cliente;
                    document.getElementById("idDocumento").innerHTML = resposta['dados'].documento;
                    document.getElementById("idElaborado_por").innerHTML = resposta['dados'].elaborado_por;
            


                }
            }

 // JavaScript para editar atividades
 async function editAtividades(id){
                const data = await fetch("visualizarAtividades.php?id=" + id);
                const resposta = await data.json();
                
                if(resposta['erro']){
                    alert('Erro: Afastamento não encontrado');
                } else {
                    const editModal = new bootstrap.Modal(document.getElementById("editAtividadesModal"));
                    editModal.show();

                    document.getElementById("editid").value = resposta['dados'].id;
                    document.getElementById("editOrd").value = resposta['dados'].ord;
                    document.getElementById("editProduto").value = resposta['dados'].produto;
                    document.getElementById("editQuantidade").value = resposta['dados'].quantidade;
                    document.getElementById("editData").value = resposta['dados'].data;
                    document.getElementById("editHora").value = resposta['dados'].hora;
                    document.getElementById("editSolicitante_cliente").value = resposta['dados'].solicitante_cliente;
                    document.getElementById("editDocumento").value = resposta['dados'].documento;
                    document.getElementById("editElaborado_por").value = resposta['dados'].elaborado_por;
                    

                }
            }

            editForm.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(editForm);

                const response = await fetch("editAtividades.php", {
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

            // JavaScript para apagar atividades
            async function apagarAtividades(id){
                const confirmar = confirm("Tem certeza que deseja deletar a atividade?");

                if (confirmar == true){
                    const data = await fetch('apagarAtividades.php?id=' + id);
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

