<?php

    include_once('../config.php');

    $idProjeto = $_POST['id'];

    $sql = "DELETE FROM tb_projeto WHERE ID_PROJETO = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idProjeto);
        
    $stmt->execute();
    $result = $stmt->get_result();


    $conexao->close();