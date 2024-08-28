<?php
    if(isset($_POST['submit'])){
        include_once('config.php');

        $email = $_POST['emailDiscente'];
        $senha = $_POST['senhaDiscente'];

        if (!$email || !$senha) {
            header("Location: ../frontend/pages/logindiscente.html");
            exit;
        }

        //Criptografia da senha
        $senha_cripto = password_hash($senha, PASSWORD_DEFAULT);

        // Query responsavel por comparar os valores na tabelas de Discentes
        $insert_script = "SELECT * FROM TB_DISCENTE WHERE EMAIL = '$email' and SENHA = '$senha_cripto'";

        //Execução do banco de dados de inserção
        $result = mysqli_query($conexao, $insert_script);

        if(mysqli_num_rows($result) > 1) {
            header("Location: ../frontend/pages/logindiscente.html");
        } else {
            header("Location: ../frontend/pages/paginavisitante.html");
        }        
         
    } else {
        header("Location: ../frontend/pages/logindiscente.html");
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


