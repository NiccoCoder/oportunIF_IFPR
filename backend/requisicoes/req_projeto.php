<?php

    include_once('../config.php');

    $sql = "SELECT 
        `tb_projeto`.`ID_PROJETO` AS `ID_PROJETO`,
        `tb_docente`.`NOME` AS `NOME`,
        `tb_projeto`.`TITULO` AS `TITULO`,
        `tb_projeto`.`POSSUI_BOLSA` AS `POSSUI_BOLSA`,
        `tb_tipo_projeto`.`NOME_TIPO_PROJETO` AS `NOME_TIPO_PROJETO`,
        `tb_projeto`.`RESUMO` AS `RESUMO`
    FROM
        ((`tb_docente`
        JOIN `tb_projeto`)
        JOIN `tb_tipo_projeto`)
    WHERE
        ((`tb_docente`.`ID_DOCENTE` = `tb_projeto`.`ID_DOCENTE`)
            AND (`tb_tipo_projeto`.`ID_TIPO_PROJETO` = `tb_projeto`.`ID_TIPO_PROJETO`))";
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
