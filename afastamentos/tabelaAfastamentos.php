<?php

include_once "../conexao.php";

$pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_NUMBER_INT);

if (!empty($pagina)) {

    // Calcular o início de visualização
    $qnt_afastamentos_pg = 10; // Quantidade de afastamentos visualizados por página
    $inicio = ($pagina * $qnt_afastamentos_pg) - $qnt_afastamentos_pg;

    $query_afastamentos = "SELECT id, title, color, start, end,nome FROM afastamentos ORDER BY id ASC LIMIT $inicio, $qnt_afastamentos_pg";
    $resultado_afastamentos = $conn->prepare($query_afastamentos);
    $resultado_afastamentos->execute();

    $dados_afastamentos = "<div class='table-responsive'>
        <table class='table table-striped table-bordered table-bordered border-white table-dark'>
            <thead>
                <tr>
                    <th scope='col'>ID</th>
                    <th scope='col'>Título</th>
                    <th scope='col'>Cor</th>
                    <th scope='col'>Início</th>
                    <th scope='col'>Fim</th>
                    <th scope='col'>Nome</th>
                    <th scope='col'>Editar</th>
                </tr>
            </thead>
            <tbody>";

    while ($row_afastamentos = $resultado_afastamentos->fetch(PDO::FETCH_ASSOC)) {

        extract($row_afastamentos);

        $dados_afastamentos .= "<tr>
            <td>$id</td>
            <td>$title</td>
            <td>$color</td>
            <td>$start</td>
            <td>$end</td>
            <td>$nome</td>
            
            <td>
                <button id='$id' class='btn btn-success btn-sm' onclick ='visualizarReunioes($id)'>Visualizar</button>
                <button id='$id' class='btn btn-warning btn-sm' onclick ='editReunioes($id)'>Editar</button>
                <button id='$id' class='btn btn-danger btn-sm' onclick ='apagarReunioes($id)'>Deletar</button>
            </td>
        </tr>";
    }

    $dados_afastamentos .= "
            </tbody>
        </table>
    </div>";

    // Paginação
    $query_paginas = "SELECT COUNT(id) AS num_result FROM afastamentos";
    $result_paginas = $conn->prepare($query_paginas);
    $result_paginas->execute();
    $row_paginas = $result_paginas->fetch(PDO::FETCH_ASSOC);

    // Quantidade de páginas
    $quantidade_paginas = ceil($row_paginas['num_result'] / $qnt_afastamentos_pg);

    // Máximo de páginas que podem ir para frente de 1 em 1
    $max_links = 2;

    $dados_afastamentos .= '<nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">';

    $dados_afastamentos .= "<li class='page-item '>
        <a class='page-link' href='#' onClick ='listarMissions(1)'>Primeira</a></li>";

    for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
        if ($pag_ant < 1) {
            $dados_afastamentos .= "";
        } else {
            $dados_afastamentos .= "<li class='page-item'><a class='page-link' onclick ='listarMissions($pag_ant)'href='#'>$pag_ant</a></li>";
        }
    }

    $dados_afastamentos .= "<li class='page-item active '><a class='page-link' href='#'>$pagina</a></li>";

    for ($pag_post = $pagina + 1; $pag_post <= $pagina + $max_links; $pag_post++) {
        if ($pag_post <= $quantidade_paginas) {
            $dados_afastamentos .= "<li class='page-item'><a class='page-link' href='#' onclick ='listarMissions($pag_post) '>$pag_post</a></li>";
        } else {
            $dados_afastamentos .= "";
        }
    }

    $dados_afastamentos .= "<li class='page-item'><a class='page-link' href='#' onclick ='listarMissions($quantidade_paginas) ' >Última<a></li>";

    $dados_afastamentos .= '</ul></nav>';

    echo $dados_afastamentos;
} else {
    echo "
    <div class='alert alert-danger' role='alert'>
        Nenhuma página encontrada
    </div>
    ";
}

?>
