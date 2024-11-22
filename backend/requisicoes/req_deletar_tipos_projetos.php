<?php

include_once('../config.php');

$idTipoProjeto = $_POST['idTipoProjeto'];

$sql = "DELETE FROM TB_TIPO_PROJETO WHERE ID_TIPO_PROJETO = ?;";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $idTipoProjeto);

$stmt->execute();
$conexao->close();

?>
