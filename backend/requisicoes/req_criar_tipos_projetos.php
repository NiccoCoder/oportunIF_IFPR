<?php

include_once('../config.php');

$nomeTipoProjeto = $_POST['nomeTipoProjeto'];

$sql = "INSERT INTO TB_TIPO_PROJETO (NOME_TIPO_PROJETO) VALUES (?);";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $nomeTipoProjeto);

$stmt->execute();
$conexao->close();

?>
