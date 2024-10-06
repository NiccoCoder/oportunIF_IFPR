<?php

$servername = getenv('DB_HOST');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');

// Criar conexão
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Desativa relatórios de erros
try {
	$conexao = new mysqli($servername, $username, $password, $dbname);
	$conexao->set_charset("utf8mb4");
} catch (Exception $e) {
	error_log($e->getMessage());
	exit('Alguma coisa estranha aconteceu...');
}
?>
