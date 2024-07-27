<?php

session_start();
    //Verifica se foi enviado o email e senha necessarios.
    if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha']))
    {
        //Acesso ao banco
        include_once('config.php');
        //Post do qual vem do login
        $email = $_POST['email']; 
        $senha = $_POST['senha'];

        $senha_cripto = password_hash($senha, PASSWORD_DEFAULT);

        //Buscando no banco de dados o usuario
        $sql = "SELECT * FROM tb_usuario WHERE email_usuario = '$email' LIMIT 1";
        //Resultado da busca
        $resultado = $conexao->query($sql) or die($conexao->error);

        //Associando uma variavel usuario ao resultado
        $usuario = $resultado->fetch_assoc();

        //Verificando se a senha é a mesma
        if(password_verify($senha, $usuario['senha_usuario'])){
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha_cripto;
            header ('Location: CD_foto.php');
        }
        else{
            expulsaUsuario();
        }
    }
    else{
        //Se não for, volta para a pagina de Login
       header('Location: login.php');
    }
?>