<?php

    include_once('../config.php');

    $idDiscente = $_POST['id'];

    $sql = "DELETE FROM TB_DISCENTE WHERE ID_DISCENTE = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $idDiscente);
        
    $stmt->execute();
    $result = $stmt->get_result();


    $conexao->close();