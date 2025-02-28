<!--/afastamentos/tabelaAfastamentos.php-->
<?php

include_once "../conexao.php";

$pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_NUMBER_INT);

if (!empty($pagina)) {

    $qnt_afastamentos_pg = 10;
    $inicio = ($pagina * $qnt_afastamentos_pg) - $qnt_afastamentos_pg;

    $query_afastamentos = "SELECT id, color, DATE(start) AS start, DATE(end) AS end, nome, motivacao, observacao, tipo 
                           FROM afastamentos 
                           ORDER BY id ASC 
                           LIMIT $inicio, $qnt_afastamentos_pg";
    $resultado_afastamentos = $conn->prepare($query_afastamentos);
    $resultado_afastamentos->execute();

    $dados_afastamentos = "<div class='table-responsive'>
        <table class='table table-striped table-bordered table-dark'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>TIPO</th>
                    <th>Cor</th>
                    <th>Início</th>
                    <th>Término</th>
                    <th>Motivação</th>
                    <th>Nome</th>
                    <th>Observação</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>";

    while ($row_afastamentos = $resultado_afastamentos->fetch(PDO::FETCH_ASSOC)) {
        extract($row_afastamentos);

        $dados_afastamentos .= "<tr>
            <td>$id</td>
            <td>$tipo</td>
            <td>$color</td>
            <td>" . date('d/m/Y', strtotime($start)) . "</td>
            <td>" . date('d/m/Y', strtotime($end)) . "</td>
            <td>$motivacao</td>
            <td>$nome</td>
            <td>$observacao</td>
            <td>
                <div class='btn-group' role='group'>
                    <button class='btn btn-success btn-sm' onclick='visualizarAfastamentos($id)'>Visualizar</button>
                    <button class='btn btn-warning btn-sm' onclick='editAfastamentos($id)'>Editar</button>
                    <button class='btn btn-danger btn-sm' onclick='apagarAfastamentos($id)'>Deletar</button>
                </div>
            </td>
        </tr>";
    }

    $dados_afastamentos .= "</tbody></table></div>";

    // Paginação
    $query_paginas = "SELECT COUNT(id) AS num_result FROM afastamentos";
    $result_paginas = $conn->prepare($query_paginas);
    $result_paginas->execute();
    $row_paginas = $result_paginas->fetch(PDO::FETCH_ASSOC);

    $quantidade_paginas = ceil($row_paginas['num_result'] / $qnt_afastamentos_pg);
    $max_links = 2;

    $dados_afastamentos .= '<nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">';

    $dados_afastamentos .= "<li class='page-item'><a class='page-link' href='#' onClick ='listarAfastamentos(1)'>Primeira</a></li>";

    for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
        if ($pag_ant >= 1) {
            $dados_afastamentos .= "<li class='page-item'><a class='page-link' onclick ='listarAfastamentos($pag_ant)' href='#'>$pag_ant</a></li>";
        }
    }

    $dados_afastamentos .= "<li class='page-item active'><a class='page-link' href='#'>$pagina</a></li>";

    for ($pag_post = $pagina + 1; $pag_post <= $pagina + $max_links; $pag_post++) {
        if ($pag_post <= $quantidade_paginas) {
            $dados_afastamentos .= "<li class='page-item'><a class='page-link' href='#' onclick ='listarAfastamentos($pag_post)'>$pag_post</a></li>";
        }
    }

    $dados_afastamentos .= "<li class='page-item'><a class='page-link' href='#' onclick ='listarAfastamentos($quantidade_paginas)'>Última</a></li>";
    $dados_afastamentos .= '</ul></nav>';

    echo $dados_afastamentos;
} else {
    echo "<div class='alert alert-danger' role='alert'>Nenhuma página encontrada</div>";
}

?>
