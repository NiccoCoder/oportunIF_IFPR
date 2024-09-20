<?php

    include_once('../config.php');

    $sql = "SELECT 
        `TB_DOCENTE`.`NOME` AS `NOME`,
        `TB_DOCENTE`.`EMAIL` AS `EMAIL`,
        (SELECT 
                COUNT(0)
            FROM
                `TB_PROJETO`
            WHERE
                (0 <> `TB_PROJETO`.`ID_DOCENTE`)) AS `NUMERO_PROJETOS`
    FROM
        `TB_DOCENTE`
    WHERE
        ((`TB_DOCENTE`.`SITUACAO` = 'confirmado')
            AND (`TB_DOCENTE`.`ID_DOCENTE` = 2))";
    $result = $conexao->query($sql);

    $dados = array();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $dados[] = $row;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($dados);

    $conexao->close();
