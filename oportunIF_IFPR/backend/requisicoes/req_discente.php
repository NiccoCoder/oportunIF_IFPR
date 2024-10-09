<?php

include_once('../config.php');

// Verifica se a conexão foi estabelecida
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// SQL para buscar discentes
$sql = "SELECT 
    d.ID_DISCENTE AS ID_DISCENTE,
    d.EMAIL AS EMAIL,
    d.SITUACAO AS SITUACAO,
    d.NOME AS NOME
FROM
    TB_DISCENTE d
GROUP BY 
    d.ID_DISCENTE, d.NOME, d.EMAIL, d.SITUACAO"; // Agrupando pelos campos necessários

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
