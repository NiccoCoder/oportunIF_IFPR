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
    d.NOME AS NOME,
    c.NOME_CURSO AS CURSO
FROM
    TB_DISCENTE d
JOIN 
    TB_CURSO c ON d.ID_CURSO = c.ID_CURSO";

// Executa a consulta
$result = $conexao->query($sql);

$dados = array();

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $dados[] = $row;
    }
}

// Retorna os dados em formato JSON
header('Content-Type: application/json');
echo json_encode($dados);

$conexao->close();
