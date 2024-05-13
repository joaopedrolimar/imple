<?php

session_start(); // Inicia a sessão

include_once "../conexao.php";

$pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_NUMBER_INT);

if (!empty($pagina)) {

    // Calcular o início de visualização
    $qnt_atividades_pg = 10; // Quantidade de atividades visualizadas por página
    $inicio = ($pagina * $qnt_atividades_pg) - $qnt_atividades_pg;

    $query_atividades = "SELECT id, ord, produto, quantidade, data, hora, solicitante_cliente, documento, elaborado_por, criado_por, tipo FROM atividades ORDER BY id ASC LIMIT $inicio, $qnt_atividades_pg";
    $resultado_atividades = $conn->prepare($query_atividades);
    $resultado_atividades->execute();

    $dados_atividades = "<div class='table-responsive'>
        <table class='table table-striped table-bordered table-bordered border-white table-dark'>
            <thead>
                <tr>
                    <th scope='col'>ID</th>
                    <th scope='col'>TIPO</th>
                    <th scope='col'>Ord</th>
                    <th scope='col'>Produto</th>
                    <th scope='col'>Quantidade</th>
                    <th scope='col'>Data</th>
                    <th scope='col'>H/H</th>
                    <th scope='col'>Solicitante</th>
                    <th scope='col'>Documento</th>
                    <th scope='col'>Elaborado Por</th>
                    <th scope='col'>Ações</th>
                </tr>
            </thead>
            <tbody>";

    while ($row_atividades = $resultado_atividades->fetch(PDO::FETCH_ASSOC)) {

        extract($row_atividades);

        // Verificar se o usuário logado é o mesmo que criou a atividade
        if ($_SESSION['user_id'] == $criado_por) {
            // Se o usuário logado for o mesmo que criou a atividade
            $dados_atividades .= "<tr>
                        <td>$id</td>
                        <td>$tipo</td>
                        <td>$ord</td>
                        <td>$produto</td>
                        <td>$quantidade</td>
                        <td>$data</td>
                        <td>$hora</td>
                        <td>$solicitante_cliente</td>
                        <td>$documento</td>
                        <td>$elaborado_por</td>
                        <td>
                        <div 
                        class='btn-group' role='group' aria-label='Ações'>
                            <button id='$id' class='btn btn-success btn-sm' onclick='visualizarAtividades($id)'>Visualizar</button>

                            <button id='$id' class='btn btn-warning btn-sm' onclick='editAtividades($id)'>Editar</button>

                            <button id='$id' class='btn btn-danger btn-sm' onclick='apagarAtividades($id)'>Deletar</button>
                        </div>
                        </td>
                    </tr>";
        } else {
            // Se o usuário logado não for o mesmo que criou a atividade
            $dados_atividades .= "<tr>
                        <td>$id</td>
                        <td>$tipo</td>
                        <td>$ord</td>
                        <td>$produto</td>
                        <td>$quantidade</td>
                        <td>$data</td>
                        <td>$hora</td>
                        <td>$solicitante_cliente</td>
                        <td>$documento</td>
                        <td>$elaborado_por</td>
                        <td>
                            <button id='$id' class='btn btn-success btn-sm' onclick='visualizarAtividades($id)'>Visualizar</button>
                        </td>
                    </tr>";
        }
    }

    $dados_atividades .= "
                    </tbody>
                </table>
            </div>";


    // Paginação
    $query_paginas = "SELECT COUNT(id) AS num_result FROM atividades";
    $result_paginas = $conn->prepare($query_paginas);
    $result_paginas->execute();
    $row_paginas = $result_paginas->fetch(PDO::FETCH_ASSOC);

    // Quantidade de páginas
    $quantidade_paginas = ceil($row_paginas['num_result'] / $qnt_atividades_pg);

    // Máximo de páginas que podem ir para frente de 1 em 1
    $max_links = 2;

    $dados_atividades .= '<nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">';

    $dados_atividades .= "<li class='page-item '>
        <a class='page-link' href='#' onClick ='listarAtividades(1)'>Primeira</a></li>";

    for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
        if ($pag_ant < 1) {
            $dados_atividades .= "";
        } else {
            $dados_atividades .= "<li class='page-item'><a class='page-link' onclick ='listarAtividades($pag_ant)'href='#'>$pag_ant</a></li>";
        }
    }

    $dados_atividades .= "<li class='page-item active '><a class='page-link' href='#'>$pagina</a></li>";

    for ($pag_post = $pagina + 1; $pag_post <= $pagina + $max_links; $pag_post++) {
        if ($pag_post <= $quantidade_paginas) {
            $dados_atividades .= "<li class='page-item'><a class='page-link' href='#' onclick ='listarAtividades($pag_post) '>$pag_post</a></li>";
        } else {
            $dados_atividades .= "";
        }
    }

    $dados_atividades .= "<li class='page-item'><a class='page-link' href='#' onclick ='listarAtividades($quantidade_paginas) ' >Última<a></li>";

    $dados_atividades .= '</ul></nav>';

    echo $dados_atividades;
} else {
    echo "
    <div class='alert alert-danger' role='alert'>
        Nenhuma página encontrada
    </div>
    ";
}

?>
