<?php

    include_once('../config.php');

    $id = $_POST['id'];

    $sql = "INSERT INTO TB_CURSO (NOME_CURSO) VALUE (?);";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $id);
        
    $stmt->execute();
    $result = $stmt->get_result();


    $conexao->close();