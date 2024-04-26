<?php

include_once "../conexao.php";

$pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_NUMBER_INT);

if (!empty($pagina)) {

    // Calcular o início de visualização
    $qnt_reunioes_pg = 10; // Quantidade de tabelas visualizadas por página
    $inicio = ($pagina * $qnt_reunioes_pg) - $qnt_reunioes_pg;

    $query_reunioes = "SELECT  id, tipo,  color, start, end, motivacao, participantes FROM reunioes ORDER BY id ASC LIMIT $inicio, $qnt_reunioes_pg";
    $resultado_reunioes = $conn->prepare($query_reunioes);
    $resultado_reunioes->execute();

    $dados_reunioes = "<div class='table-responsive'>
        <table class='table table-striped table-bordered table-bordered border-white table-dark'>
            <thead>
                <tr>
                    <th scope='col'>ID</th>
                    <th scope='col'>TIPO</th>
                    <th scope='col'>Cor</th>
                    <th scope='col'>Início</th>
                    <th scope='col'>Fim</th>
                    <th scope='col'>Motivação</th>
                    <th scope='col'>Participantes</th>
                    <th scope='col'>Editar</th>
                </tr>
            </thead>
            <tbody>";

    while ($row_reunioes = $resultado_reunioes->fetch(PDO::FETCH_ASSOC)) {

        extract($row_reunioes);

        $dados_reunioes .= "<tr>
            <td>$id</td>
            <td>$tipo</td>
            <td>$color</td>
            <td>$start</td>
            <td>$end</td>
            <td>$motivacao</td>
            <td>$participantes</td>

            <td>
            <div class='btn-group-vertical' role='group' aria-label='Ações'>
                <button id='<?php echo $id; ?>' class='btn btn-success btn-sm' onclick='visualizarReunioes($id)'>Visualizar</button>
                <button id='<?php echo $id; ?>' class='btn btn-warning btn-sm' onclick='editReunioes($id)'>Editar</button>
                <button id='<?php echo $id; ?>' class='btn btn-danger btn-sm' onclick='apagarReunioes($id)'>Deletar</button>
            </div>
            </td>
        </tr>";
    }

    $dados_reunioes .= "
            </tbody>
        </table>
    </div>";

    // Paginação
    $query_paginas = "SELECT COUNT(id) AS num_result FROM reunioes";
    $result_paginas = $conn->prepare($query_paginas);
    $result_paginas->execute();
    $row_paginas = $result_paginas->fetch(PDO::FETCH_ASSOC);

    // Quantidade de páginas
    $quantidade_paginas = ceil($row_paginas['num_result'] / $qnt_reunioes_pg);

    // Máximo de páginas que podem ir para frente de 1 em 1
    $max_links = 2;

    $dados_reunioes .= '<nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">';

    $dados_reunioes .= "<li class='page-item '>
        <a class='page-link' href='#' onClick ='listarMissions(1)'>Primeira</a></li>";

    for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
        if ($pag_ant < 1) {
            $dados_reunioes .= "";
        } else {
            $dados_reunioes .= "<li class='page-item'><a class='page-link' onclick ='listarMissions($pag_ant)'href='#'>$pag_ant</a></li>";
        }
    }

    $dados_reunioes .= "<li class='page-item active '><a class='page-link' href='#'>$pagina</a></li>";

    for ($pag_post = $pagina + 1; $pag_post <= $pagina + $max_links; $pag_post++) {
        if ($pag_post <= $quantidade_paginas) {
            $dados_reunioes .= "<li class='page-item'><a class='page-link' href='#' onclick ='listarMissions($pag_post) '>$pag_post</a></li>";
        } else {
            $dados_reunioes .= "";
        }
    }

    $dados_reunioes .= "<li class='page-item'><a class='page-link' href='#' onclick ='listarMissions($quantidade_paginas) ' >Última<a></li>";

    $dados_reunioes .= '</ul></nav>';

    echo $dados_reunioes;
} else {
    echo "
    <div class='alert alert-danger' role='alert'>
        Nenhuma página encontrada
    </div>
    ";
}

?>
