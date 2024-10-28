<?php
    session_start();
    include_once('../config.php');

    $idDocente = $_SESSION['id'];

    $sql = "
       SELECT 
        `TB_PROJETO`.`ID_PROJETO` AS `ID_PROJETO`,
        `TB_PROJETO`.`TITULO` AS `TITULO`,
        `TB_DOCENTE`.`NOME` AS `NOME`,
        `TB_PROJETO`.`POSSUI_BOLSA` AS `POSSUI_BOLSA`,
        `TB_TIPO_PROJETO`.`NOME_TIPO_PROJETO` AS `NOME_TIPO_PROJETO`,
        `TB_PROJETO`.`RESUMO` AS `RESUMO`,
		`TB_PROJETO`.`CRITERIOS_SELECAO` as `CRITERIOS`,
        `TB_PROJETO`.`BOLSA_DESCRICAO` as `DESCRICAO`,
        `TB_PROJETO`.`BOLSA_REQUISITOS` as `REQUISITOS`,
        `TB_DOCENTE`.`EMAIL` as `EMAIL`
    FROM
        ((`TB_DOCENTE`
        JOIN `TB_PROJETO`)
        JOIN `TB_TIPO_PROJETO`)
    WHERE
        ((`TB_PROJETO`.`ID_DOCENTE` = ?)
            AND (`TB_TIPO_PROJETO`.`ID_TIPO_PROJETO` = `TB_PROJETO`.`ID_TIPO_PROJETO`))
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