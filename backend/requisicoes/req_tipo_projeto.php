<?php

    include_once('../config.php');

    $sql = "SELECT * FROM TB_TIPO_PROJETO";
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
