<?php

    include_once('../config.php');

    $idProjeto = $_POST['id'];

    $sql = "DELETE FROM TB_PROJETO WHERE ID_PROJETO = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $idProjeto);
        
    $stmt->execute();
    $result = $stmt->get_result();


    $conexao->close();