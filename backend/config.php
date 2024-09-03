<?php
$servername = getenv('DB_HOST');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');

// Criar conexão
$conexao = new mysqli($servername, $username, $password, $dbname);

// Checar conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// //Executar consulta
// $sql = "SHOW TABLES";
// $result = $conexao->query($sql);

// if ($result->num_rows > 0) {
//     // Mostrar tabelas
//     while($row = $result->fetch_assoc()) {
//         echo "Tabela: " . $row["Tables_in_$dbname"] . "<br>";
//     }
// } else {
//     echo "Nenhuma tabela encontrada.";
// }

// // Nome da tabela que você deseja consultar
// $tabela = 'TB_DISCENTE';

// // Executar consulta para obter colunas da tabela
// $sql = "SHOW COLUMNS FROM $tabela";
// $result = $conexao->query($sql);

// if ($result->num_rows > 0) {
//     // Mostrar colunas
//     while ($row = $result->fetch_assoc()) {
//         echo "Coluna: " . $row["Field"] . "<br>";
//     }
// } else {
//     echo "Nenhuma coluna encontrada na tabela $tabela.";
// }

// $sql = "SELECT * FROM db_oportunif.TB_DISCENTE";
// $result = $conexao->query($sql);
// 
// if ($result->num_rows > 0) {
    // echo "<h2>Dados da Tabela TB_DISCENTE:</h2>";
    // echo "<table border='1'><tr><th>ID</th><th>NOME</th><th>EMAIL</th><th>SENHA</th><th>TURMA</th></tr>";
    // while($row = $result->fetch_assoc()) {
        // echo "<tr>";
        // echo "<td>" . $row["ID"] . "</td>";
        // echo "<td>" . $row["NOME"] . "</td>";
        // echo "<td>" . $row["EMAIL"] . "</td>";
        // echo "<td>" . $row["SENHA"] . "</td>";
        // echo "<td>" . $row["TURMA"] . "</td>";
        // echo "</tr>";
    // }
    // echo "</table>";
// } else {
    // echo "Nenhum dado encontrado na tabela TB_DISCENTE.";
// }
?>
