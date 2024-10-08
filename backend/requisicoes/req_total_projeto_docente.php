<?php
    session_start();
    include_once('../config.php');

    $idDocente = $_SESSION['id'];

    $sql = "
       SELECT 
        `TB_PROJETO`.`ID_DOCENTE` AS `ID_DOCENTE`,
        COUNT(0) AS `NUMERO_PROJETOS`
    FROM
        `TB_PROJETO`
    WHERE
        (`TB_PROJETO`.`ID_DOCENTE` = ?)
    GROUP BY `TB_PROJETO`.`ID_DOCENTE`
    ";
    $stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $idDocente);

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