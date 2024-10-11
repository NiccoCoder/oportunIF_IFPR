<?php

include_once('../config.php');

// Verifica se a conexão foi estabelecida
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// SQL para buscar discentes
$sql = "SELECT 
        `tb_discente`.`ID_DISCENTE` AS `ID_DISCENTE`,
        `tb_discente`.`EMAIL` AS `EMAIL`,
        `tb_discente`.`SITUACAO` AS `SITUACAO`,
        `tb_discente`.`NOME` AS `NOME`,
        `tb_curso`.`NOME_CURSO` AS `CURSO`
    FROM
        (`tb_discente`
        JOIN `tb_curso`)
    WHERE
        (`tb_curso`.`ID_CURSO` = `tb_discente`.`ID_CURSO`)"; // Agrupando pelos campos necessários

$result = $conexao->query($sql);

$dados = array();

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $dados[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($dados);

$conexao->close();
