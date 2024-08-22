<?php
// Informações para o acesso no BD que devem sser encontradas no .env
$dbHost = getenv('DB_HOST');
$dbUserName = getenv('DB_USER'); 
$dbPassword = getenv('DB_PASSWORD');
$dbName = getenv('DB_NAME');

//... = getenv(Nome da Variavel); temos os valores das variaveis de ambiente

// Conexão com o banco
$conexao = new mysqli($dbHost, $dbUserName, $dbPassword, $dbName);

// Verifica se houve erro na conexão
if ($conexao->connect_errno) {
    die("Erro: " . $conexao->connect_error);
} else {
    echo "Conexão bem-sucedida!";
}
?>
