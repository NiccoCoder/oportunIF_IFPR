<?php
    echo "Paginas:";
    include_once("config.php");

    $sql ="select * from TB_DISCENTE";

    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
    <body>
        <br>
        <a href = "./config.php">Testar conexão com o BD</a>
        <br>
        <a href="./cadastroDocente.php">Cadastro Docente</a>
        <br>
        <a href = "./cadastroDiscente.php">Cadastro Discente</a> 

        <?php
    echo "oi";
         while ($user_data = mysqli_fetch_assoc($result)) {
            # code...
            echo "<tr>";
            echo "<td>".$user_data["ID"]."</td>";
         }
        ?>
    </body>
<html>