<?php
// $servername = 'Localhost';
// $username = 'root';
// $password = '';
// $dbname = 'db_oportunif';

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
// <<<<<<< HEAD
// =======
// unset($_SESSION["id"]);
// >>>>>>> 4e7b1338c7ef9c85ac774950202d9a8a2b44051f
// 

// // Query para contar o número total de registros na tabela TB_CURSO
// $query = "SELECT COUNT(*) AS total FROM TB_CURSO";

// // Execute a consulta
// $result = mysqli_query($conexao, $query);

// // Verifique se a consulta foi bem-sucedida
// if ($result) {
//     // Obtenha o resultado da consulta
//     $row = mysqli_fetch_assoc($result);
//     $total = $row['total'];

//     // Verifique se há registros na tabela
//     if ($total > 0) {
//         echo "Há $total registros na tabela TB_CURSO.";
//     } else {
//         echo "A tabela TB_CURSO está vazia.";
//     }
// } else {
//     // Se a consulta falhar, exiba o erro
//     echo "Erro na consulta: " . mysqli_error($conexao);
// }
?>
