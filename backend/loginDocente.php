<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

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
            $_SESSION['id'] = $user['ID'];
           header("Location: ../frontend/pages/paginavisitante.html"); 
        } else {
            header("Location: ../frontend/pages/paginavisitante.html");
        } 
 
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


