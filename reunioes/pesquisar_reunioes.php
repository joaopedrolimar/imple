<!--/reunioes/pesquisar_reunioes.php-->
<?php
include_once "../conexao.php";

$termo = filter_input(INPUT_GET, "termo", FILTER_UNSAFE_RAW);

if (!empty($termo)) {
    $query_reunioes = "SELECT id, tipo, color, DATE(start) AS start, DATE(end) AS end, motivacao, participantes
                   FROM reunioes
                   WHERE CAST(id AS CHAR) LIKE :termo
                   OR motivacao LIKE :termo
                   OR participantes LIKE :termo
                   ORDER BY id ASC";

    $resultado_reunioes = $conn->prepare($query_reunioes);
    $termoPesquisa = "%" . $termo . "%";
    $resultado_reunioes->bindParam(':termo', $termoPesquisa, PDO::PARAM_STR);
    $resultado_reunioes->execute();

    // Verifica se há resultados
    if ($resultado_reunioes->rowCount() > 0) {
        $dados_reunioes = "<div class='table-responsive'>
        <table class='table table-striped table-bordered table-dark'>
            <thead>
                <tr>
                    <th scope='col'>ID</th>
                    <th scope='col'>Tipo</th>
                    <th scope='col'>Cor</th>
                    <th scope='col'>Início</th>
                    <th scope='col'>Término</th>
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
                <td>" . date('d/m/Y', strtotime($start)) . "</td>
                <td>" . date('d/m/Y', strtotime($end)) . "</td>
                <td>$motivacao</td>
                <td>$participantes</td>
                <td>
                    <div class='btn-group' role='group'>
                        <button class='btn btn-success btn-sm' onclick='visualizarReunioes($id)'>Visualizar</button>
                        <button class='btn btn-warning btn-sm' onclick='editReunioes($id)'>Editar</button>
                        <button class='btn btn-danger btn-sm' onclick='apagarReunioes($id)'>Deletar</button>
                    </div>
                </td>
            </tr>";
        }

        $dados_reunioes .= "</tbody></table></div>";

        echo $dados_reunioes;
    } else {
        // Exibir mensagem caso não encontre registros
        echo "<div class='alert alert-warning' role='alert'>Nenhuma Reunião encontrada.</div>";
    }
} else {
    echo "<div class='alert alert-danger' role='alert'>Digite um termo para pesquisar.</div>";
}
?>
