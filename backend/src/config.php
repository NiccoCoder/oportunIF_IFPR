<?php
// Informações para o acesso no BD que devem sser encontradas no .env

$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$database = getenv('DB_NAME');

//... = getenv(Nome da Variavel); temos os valores das variaveis de ambiente
$conn = new mysqli($host, $user, $password, $database);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
