<?php

include_once('../config.php');

$idCurso = $_POST['idCurso'];
$nomeCurso = $_POST['nomeCurso'];

$sql = "UPDATE TB_CURSO SET NOME_CURSO = ? WHERE ID_CURSO = ?;";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("si", $nomeCurso, $idCurso);

$stmt->execute();
$conexao->close();

?>
