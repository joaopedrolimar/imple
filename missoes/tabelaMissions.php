<?php

include_once "../conexao.php";

$pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_NUMBER_INT);

if(!empty($pagina)){

    //calcular o inicio de vizualização
    $qnt_missions_pg = 10;//quantidade de tableas visualizadas por pagina
    $inicio = ($pagina * $qnt_missions_pg) - $qnt_missions_pg;
    //1 * 10 = 10 - 10 = 0
    
    


        $query_missions = "SELECT id,title,color,start,end FROM  events ORDER BY id ASC LIMIT $inicio, $qnt_missions_pg";
        $resultado_missions = $conn->prepare($query_missions);
        $resultado_missions->execute();


        $dados_missions ="<div class='table-responsive'>
        <table class='table table-striped table-bordered  table table-bordered border-white table-dark'>
            <thead>
                <tr>
                    <th scope='col'>id</th>
                    <th scope='col'>title</th>
                    <th scope='col'>color</th>
                    <th scope='col'>start</th>
                    <th scope='col'>end</th>
                    <th scope='col'>Editar</th>
                </tr>
            </thead>
            <tbody>";


        while($row_missions = $resultado_missions->fetch(PDO::FETCH_ASSOC)){
            
            extract($row_missions);
                
            $dados_missions .= "<tr>

            <td >$id</td>
            <td>$title</td>
            <td>$color</td>
            <td>$start</td>
            <td>$end</td>
            <td>
            <button id='$id' class='btn btn-success btn-sm' onclick ='visualizarUsuario($id)'>Visualizar</button>
            <button id='$id' class='btn btn-warning btn-sm' onclick ='editUsuarioDados($id)'>Editar</button>
            <button id='$id' class='btn btn-danger btn-sm' onclick ='apagarUsuarioDados($id)'>Deletar</button>
            </td>
            
            

            

            

            
            </tr> "; 
                    
        }

        $dados_missions .= "
                    </tbody>
                </table>
            </div>
        ";

        //paginação - somar a aquantidade de usários
       $query_paginas = "SELECT COUNT(id) AS num_result FROM events";
       $result_paginas = $conn->prepare($query_paginas);
       $result_paginas->execute();
       $row_paginas = $result_paginas->fetch(PDO::FETCH_ASSOC);

       //quantidade de paginas
       $quantidade_paginas = ceil($row_paginas['num_result'] / $qnt_missions_pg);

       //maximo de paginas que podes ir para frente de 1 em 1
       $max_links = 2;
        
 
                $dados_missions .= '<nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">';
                
                $dados_missions .= " <li class='page-item '>
                <a class='page-link' href='#' onClick ='listarMissions(1)'>Primeira</a></li>";


                for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
                    if($pag_ant < 1 ){
                        $dados_missions .="";
                    }else{
                        $dados_missions .= "<li class='page-item'><a class='page-link' onclick ='listarMissions($pag_ant)'href='#'>$pag_ant</a></li>";
                    }
                }


                $dados_missions .= "<li class='page-item active '><a class='page-link' href='#'>$pagina</a></li>";

                for($pag_post = $pagina + 1; $pag_post <= $pagina + $max_links; $pag_post++){
                    if($pag_post <= $quantidade_paginas){
                        $dados_missions .= "<li class='page-item'><a class='page-link' href='#' onclick ='listarMissions($pag_post) '>$pag_post</a></li>";

                    }else{
                        $dados_missions .= "";
                    }
                    

                }

               

                $dados_missions .= " <li class='page-item'><a class='page-link' href='#' onclick ='listarMissions($quantidade_paginas) ' >Última<a></li>";

                $dados_missions .= '</ul></nav>';

        echo $dados_missions;

} else {
    echo "
    <div class='alert alert-danger' role='alert'>
        Nenhuma pagina encontrada
    </div>
    ";
}

?>