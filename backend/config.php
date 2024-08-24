<?php
$servername = getenv('DB_HOST');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

//Executar consulta
$sql = "SHOW TABLES";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mostrar tabelas
    while($row = $result->fetch_assoc()) {
        echo "Tabela: " . $row["Tables_in_$dbname"] . "<br>";
    }
} else {
    echo "Nenhuma tabela encontrada.";
}

// $sql = "SELECT * FROM db_oportunif.TB_DISCENTE";
// $result = $conn->query($sql);
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
 
$conn->close();
?>
