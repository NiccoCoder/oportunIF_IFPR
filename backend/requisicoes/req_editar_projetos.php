<?php

include_once('../config.php');

$id = $_POST['id'];
$title = $_POST['title'];
$criteria = $_POST['criteria'];
$type = $_POST['type'];
$summary = $_POST['summary'];
$cBolsa = $_POST['cBolsa'];
$description = $_POST['description'];
$requirements = $_POST['requirements'];



$sql = "UPDATE TB_PROJETO SET 
TITULO = ? , 
CRITERIOS_SELECAO = ?, 
ID_TIPO_PROJETO = ?, 
RESUMO = ?, 
POSSUI_BOLSA = ?, 
BOLSA_DESCRICAO = ?, 
BOLSA_REQUISITOS = ?
	WHERE ID_PROJETO = ?;";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ssisissi",$title, $criteria, $type, $summary, $cBolsa, $description, $requirements, $id);

$stmt->execute();
$conexao->close();

?>
