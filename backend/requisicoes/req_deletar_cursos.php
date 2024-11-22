<?php

include_once('../config.php');

$idCurso = $_POST['idCurso'];

$sql = "DELETE FROM TB_CURSO WHERE ID_CURSO = ?;";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $idCurso);

$stmt->execute();
$conexao->close();

?>
