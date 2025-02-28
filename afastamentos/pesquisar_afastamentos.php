<!--/afastamentos/pesquisar_afastamentos.php/-->
<?php
include_once "../conexao.php";

$termo = filter_input(INPUT_GET, "termo", FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);


if (!empty($termo)) {
    $query_afastamentos = "SELECT id, color, DATE(start) AS start, DATE(end) AS end, nome, motivacao, observacao, tipo 
                           FROM afastamentos 
                           WHERE nome LIKE :termo OR motivacao LIKE :termo 
                           ORDER BY id ASC";
                           
    $resultado_afastamentos = $conn->prepare($query_afastamentos);
    $resultado_afastamentos->bindValue(':termo', '%' . $termo . '%', PDO::PARAM_STR);
    $resultado_afastamentos->execute();

    if ($resultado_afastamentos->rowCount() > 0) {
        $dados = "<table class='table table-striped table-bordered table-dark'>
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

        while ($row = $resultado_afastamentos->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $dados .= "<tr>
                        <td>$id</td>
                        <td>$tipo</td>
                        <td>$color</td>
                        <td>" . date('d/m/Y', strtotime($start)) . "</td>
                        <td>" . date('d/m/Y', strtotime($end)) . "</td>
                        <td>$motivacao</td>
                        <td>$nome</td>
                        <td>$observacao</td>
                        <td>
                            <button class='btn btn-success btn-sm' onclick='visualizarAfastamentos($id)'>Visualizar</button>
                            <button class='btn btn-warning btn-sm' onclick='editAfastamentos($id)'>Editar</button>
                            <button class='btn btn-danger btn-sm' onclick='apagarAfastamentos($id)'>Deletar</button>
                        </td>
                    </tr>";
        }

        $dados .= "</tbody></table>";
    } else {
        $dados = "<div class='alert alert-danger' role='alert'>Nenhum afastamento encontrado!</div>";
    }
    echo $dados;
}
?>
