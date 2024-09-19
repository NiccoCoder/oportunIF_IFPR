<?php

    include_once('../config.php');

    $sql = "SELECT 
    `db_oportunif`.`tb_docente`.`NOME` AS `NOME`,
    `db_oportunif`.`tb_projeto`.`TITULO` AS `TITULO`,
    `db_oportunif`.`tb_projeto`.`RESUMO` AS `RESUMO`,
    `db_oportunif`.`tb_tipo_projeto`.`NOME_TIPO_PROJETO` AS `NOME_TIPO_PROJETO`
FROM
    ((`db_oportunif`.`tb_docente`
    JOIN `db_oportunif`.`tb_tipo_projeto`)
    JOIN `db_oportunif`.`tb_projeto`)
WHERE
    ((`db_oportunif`.`tb_docente`.`ID_DOCENTE` = `db_oportunif`.`tb_projeto`.`ID_DOCENTE`)
    AND (`db_oportunif`.`tb_tipo_projeto`.`ID_TIPO_PROJETO` = `db_oportunif`.`tb_projeto`.`ID_TIPO_PROJETO`))";
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
