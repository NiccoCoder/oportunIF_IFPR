<?php
    session_start();
    include_once('../config.php');

    $idDocente = $_SESSION['id'];

    $sql = "
       SELECT 
        `tb_projeto`.`ID_PROJETO` AS `ID_PROJETO`,
        `tb_docente`.`NOME` AS `NOME`,
        `tb_projeto`.`TITULO` AS `TITULO`,
        `tb_projeto`.`POSSUI_BOLSA` AS `POSSUI_BOLSA`,
        `tb_tipo_projeto`.`NOME_TIPO_PROJETO` AS `NOME_TIPO_PROJETO`,
        `tb_projeto`.`RESUMO` AS `RESUMO`,
        `tb_projeto`.`BOLSA_DESCRICAO` AS `DESCRICAO`,
        `tb_projeto`.`BOLSA_REQUISITOS` AS `REQUISITOS`,
        `tb_projeto`.`CRITERIOS_SELECAO` AS `CRITERIOS`
    FROM
        ((`tb_docente`
        JOIN `tb_projeto`)
        JOIN `tb_tipo_projeto`)
    WHERE
        ((`tb_docente`.`ID_DOCENTE` = `tb_projeto`.`ID_DOCENTE`)
            AND (`tb_tipo_projeto`.`ID_TIPO_PROJETO` = `tb_projeto`.`ID_TIPO_PROJETO`)
            AND (`tb_docente`.`ID_DOCENTE` = ?))
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