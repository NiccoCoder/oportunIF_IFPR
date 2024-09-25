<?php

    include_once('../config.php');

    $sql = "SELECT 
        `d`.`ID_DOCENTE` AS `ID_DOCENTE`,
        `d`.`EMAIL` AS `EMAIL`,
        `d`.`SITUACAO` AS `SITUACAO`,
        `d`.`NOME` AS `NOME`,
        COUNT(0) AS `TOTAL_PROJETOS`
    FROM
        (`TB_DOCENTE` `d`
        JOIN `TB_PROJETO` `dp` ON ((`d`.`ID_DOCENTE` = `dp`.`ID_DOCENTE`)))
    GROUP BY `d`.`ID_DOCENTE` , `d`.`NOME`";
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