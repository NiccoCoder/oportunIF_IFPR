<?php
    session_start();
    include_once('../config.php');

    $busca = $_POST['busca'];

    $sql = "SELECT 
        `TB_PROJETO`.`ID_PROJETO` AS `ID_PROJETO`,
        `TB_DOCENTE`.`NOME` AS `NOME`,
        `TB_PROJETO`.`TITULO` AS `TITULO`,
        `TB_PROJETO`.`POSSUI_BOLSA` AS `POSSUI_BOLSA`,
        `TB_TIPO_PROJETO`.`NOME_TIPO_PROJETO` AS `NOME_TIPO_PROJETO`,
        `TB_PROJETO`.`RESUMO` AS `RESUMO`,
        `TB_PROJETO`.`CRITERIOS_SELECAO` AS `CRITERIOS`,
        `TB_PROJETO`.`BOLSA_DESCRICAO` AS `DESCRICAO`,
        `TB_PROJETO`.`BOLSA_REQUISITOS` AS `REQUISITOS`,
        `TB_DOCENTE`.`EMAIL` AS `EMAIL`
    FROM
        ((`TB_DOCENTE`
        JOIN `TB_PROJETO` ON ((`TB_DOCENTE`.`ID_DOCENTE` = `TB_PROJETO`.`ID_DOCENTE`)))
        JOIN `TB_TIPO_PROJETO` ON ((`TB_TIPO_PROJETO`.`ID_TIPO_PROJETO` = `TB_PROJETO`.`ID_TIPO_PROJETO`)))
    WHERE
        (`TB_PROJETO`.`TITULO` LIKE '%$busca%') or
        (`TB_DOCENTE`.`NOME` LIKE '%$busca%')";
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