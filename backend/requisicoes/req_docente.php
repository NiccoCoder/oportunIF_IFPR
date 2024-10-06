<?php

include_once('../config.php');

// Verifica se a conexão foi estabelecida
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// SQL para buscar docentes
$sql = "SELECT 
    d.ID_DOCENTE AS ID_DOCENTE,
    d.EMAIL AS EMAIL,
    d.SITUACAO AS SITUACAO,
    d.NOME AS NOME,
    COUNT(dp.ID_PROJETO) AS TOTAL_PROJETOS
FROM
    TB_DOCENTE d
LEFT JOIN 
    TB_PROJETO dp ON d.ID_DOCENTE = dp.ID_DOCENTE
GROUP BY 
    d.ID_DOCENTE, d.NOME, d.EMAIL, d.SITUACAO";

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
