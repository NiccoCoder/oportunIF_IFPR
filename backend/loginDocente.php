<?php
    if(isset($_POST['submit'])){
        include_once('config.php');

        $email = $_POST['emailDocente'];
        $senha = $_POST['senhaDocente'];

        if (!$email || !$senha) {
            header("Location: ../frontend/pages/logindocente.html");
            exit;
        }


        $sql = "SELECT * FROM TB_DOCENTE WHERE EMAIL = '$email' LIMIT 1";

        $result = $conexao->query($sql) or die($conexao->error);

        $user = $result->fetch_assoc();

        if(password_verify($senha, $user['SENHA'])){
            $_SESSION['email'] = $email;
            header("Location: ../frontend/pages/paginavisitante.html");
        } else {
            header("Location: ../frontend/pages/logindocente.html");
        } 


        /*

        //Criptografia da senha
        $senha_cripto = password_hash($senha, PASSWORD_DEFAULT);

        // Query responsavel por comparar os valores na tabelas de Discentes
        $insert_script = "SELECT * FROM TB_DOCENTE WHERE EMAIL = '$email' and SENHA = '$senha_cripto'";

        //Execução do banco de dados de inserção
        $result = mysqli_query($conexao, $insert_script);
        $row = mysqli_fetch_array($result);
        echo '=======>'. $row;
        die ($row);
        if(mysqli_num_rows($result) > 1) {
            header("Location: ../frontend/pages/logindocente.html");
        } else {
            header("Location: ../frontend/pages/paginavisitante.html");
        }   
            */     
         
    } else {
        header("Location: ../frontend/pages/logindocente.html");
        // $nome = $_POST['nomeDiscente'];
        // $email = $_POST['emailDiscente'];
        // $senha = $_POST['senhaDiscente'];
        // $curso = $_POST['cursoDiscente'];d
        
        // echo ' nome =>' . $nome;
        // echo ' email =>' . $email;
        // echo ' senha =>' . $senha;
        // echo ' curso =>' . $curso;
        // echo 'Nova senha =>' . $senha_cripto;
        exit();
    }

?>


