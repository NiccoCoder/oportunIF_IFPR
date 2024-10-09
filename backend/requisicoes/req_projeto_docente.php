<?php
    session_start();
    include_once('../config.php');

    $idDocente = $_SESSION['id'];

    $sql = "
        SELECT 
        `TB_PROJETO`.`ID_PROJETO` AS `ID_PROJETO`,
        `TB_PROJETO`.`ID_DOCENTE` AS `ID_DOCENTE`,
        `TB_PROJETO`.`ID_TIPO_PROJETO` AS `ID_TIPO_PROJETO`,
        `TB_PROJETO`.`TITULO` AS `TITULO`,
        `TB_PROJETO`.`CRITERIOS_SELECAO` AS `CRITERIOS_SELECAO`,
        `TB_PROJETO`.`RESUMO` AS `RESUMO`,
        `TB_PROJETO`.`POSSUI_BOLSA` AS `POSSUI_BOLSA`,
        `TB_PROJETO`.`BOLSA_DESCRICAO` AS `BOLSA_DESCRICAO`,
        `TB_PROJETO`.`BOLSA_REQUISITOS` AS `BOLSA_REQUISITOS`
    FROM
        `TB_PROJETO`
    WHERE
        (`TB_PROJETO`.`ID_DOCENTE` = ?)
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