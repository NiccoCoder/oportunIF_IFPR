<?php

    include_once('../config.php');

    $sql = "SELECT
    (SELECT COUNT(*) FROM TB_DISCENTE) AS NUMERO_DISCENTES,
    (SELECT COUNT(*) FROM TB_DOCENTE) AS NUMERO_DOCENTE,
    (SELECT COUNT(*) FROM TB_PROJETO) AS NUMERO_PROJETOS;";
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
