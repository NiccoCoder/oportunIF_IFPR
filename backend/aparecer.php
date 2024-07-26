<?php
    //Chama a conexão com o banco
    include_once('config.php');
    //Mostra os usuarios :v
    $sql = "SELECT * FROM tb_usuario";
    //Resultado da consulta
    $result = $conexao->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>email</th>
                <th>nome</th>
                <th>genero</th>
            </tr>

        </thead>
        <tbody>
            <?php 
                while($user_data = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo "<td>".$user_data['email_usuario']."</td>";
                    echo "<td>".$user_data['nome_usuario']."</td>";
                    echo "<td>".$user_data['genero_usuario']."</td>";
                }
            ?>
        </tbody>

    </table>
</body>
</html>