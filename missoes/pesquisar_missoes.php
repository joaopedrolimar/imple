<?php
include_once "../conexao.php";

$termo = filter_input(INPUT_GET, "termo", FILTER_UNSAFE_RAW);


if (!empty($termo)) {
    $query_missions = "SELECT m.id, m.tipo, m.start, m.end, m.funcao, m.motivacao, m.participantes, 
                       COALESCE(p.username, 'Não informado') AS elaborado_por
                       FROM missoes m
                       LEFT JOIN policiais p ON m.elaborado_por = p.id
                       WHERE CAST(m.id AS CHAR) LIKE :termo 
                       OR m.motivacao LIKE :termo
                       OR m.participantes LIKE :termo
                       OR p.username LIKE :termo
                       ORDER BY m.id ASC";

    $resultado_missions = $conn->prepare($query_missions);
    $termoPesquisa = "%" . $termo . "%";
    $resultado_missions->bindParam(':termo', $termoPesquisa, PDO::PARAM_STR);
    $resultado_missions->execute();

    // Verifica se encontrou resultados
    if ($resultado_missions->rowCount() > 0) {
        $dados_missions = "<div class='table-responsive'>
        <table class='table table-striped table-bordered table-dark'>
            <thead>
                <tr>
                    <th scope='col'>ID</th>
                    <th scope='col'>TIPO</th>
                    <th scope='col'>Início</th>
                    <th scope='col'>Término</th>
                    <th scope='col'>Motivação</th>
                    <th scope='col'>Participantes</th>
                    <th scope='col'>Elaborado por</th>
                    <th scope='col'>Função</th>
                    <th scope='col'>Editar</th>
                </tr>
            </thead>
            <tbody>";

        while ($row_missions = $resultado_missions->fetch(PDO::FETCH_ASSOC)) {
            extract($row_missions);
            $dados_missions .= "<tr>
                <td>$id</td>
                <td>$tipo</td>
                <td>$start</td>
                <td>$end</td>
                <td>$motivacao</td>
                <td>$participantes</td>
                <td>$elaborado_por</td>
                <td>$funcao</td>
                <td>
                    <div class='btn-group' role='group' aria-label='Ações'>
                        <button class='btn btn-success btn-sm' onclick='visualizarMissoes($id)'>Visualizar</button>
                        <button class='btn btn-warning btn-sm' onclick='editMissoes($id)'>Editar</button>
                        <button class='btn btn-danger btn-sm' onclick='apagarMissoes($id)'>Deletar</button>
                    </div>
                </td>
            </tr>";
        }

        $dados_missions .= "</tbody></table></div>";
        echo $dados_missions;
    } else {
        echo "<div class='alert alert-warning' role='alert'>Nenhuma missão encontrada.</div>";
    }
} else {
    echo "<div class='alert alert-danger' role='alert'>Digite um termo para pesquisar.</div>";
}
?>
