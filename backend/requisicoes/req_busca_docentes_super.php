<?php
    session_start();
    include_once('../config.php');

    $busca = $_POST['busca'];

    $sql = "SELECT 
    ID_DOCENTE AS ID_DOCENTE,
    EMAIL AS EMAIL,
    SITUACAO AS SITUACAO,
    NOME AS NOME
    FROM 
    TB_DOCENTE WHERE NOME LIKE '%$busca%'";
    $stmt = $conexao->prepare($sql);

if ($stmt->execute()) {
    $result = $stmt->get_result();

    $dados = array();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $dados[] = $row;
        }
    }
} else {
    // Tratar erro de execução da consulta
    echo json_encode(['error' => 'Erro ao executar a consulta']);
    exit;
}

header('Content-Type: application/json');
echo json_encode($dados);

$conexao->close();