<?php
    session_start();
    include_once('../config.php');

    $busca = $_POST['busca'];

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
    WHERE
    
		 NOME LIKE '%$busca%'
GROUP BY 
    d.ID_DOCENTE, d.NOME, d.EMAIL, d.SITUACAO";
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