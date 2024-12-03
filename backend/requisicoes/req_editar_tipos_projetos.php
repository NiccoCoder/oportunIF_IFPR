<?php

include_once('../config.php');

$idTipoProjeto = $_POST['id'];
$nomeTipoProjeto = $_POST['nome'];

$sql = "UPDATE TB_TIPO_PROJETO SET NOME_TIPO_PROJETO = ? WHERE ID_TIPO_PROJETO = ?;";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("si", $nomeTipoProjeto, $idTipoProjeto);

$stmt->execute();
$conexao->close();

?>
