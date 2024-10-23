<?php

    include_once('../config.php');

    $idDocente = $_POST['id'];

    $sql = "DELETE FROM TB_DOCENTE WHERE ID_DOCENTE = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $idDocente);
        
    $stmt->execute();
    $result = $stmt->get_result();


    $conexao->close();