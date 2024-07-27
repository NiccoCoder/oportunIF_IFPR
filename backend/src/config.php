<?php
        //Dados basicos[NOME DO HOST,NOME DO USUARIO, SENHA DO BANCO, NOME DO BANCO]
    $dbHost = 'Localhost';
    $dbUserName = 'root';
    $dbPassword = '';
    $dbName = 'db_pepif';
        //CONEXÂO COM O BANCO
    $conexao = new mysqli($dbHost,$dbUserName,$dbPassword,$dbName);

    /*if($conexao->connect_errno){
        echo "erro";
    }
    else{
        echo "funfou poha";
    }

    */
        //FUNÇÂO PARA EXPULSAR E DESLOGAR O USUARIO
    function expulsaUsuario(){
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            header('Location: casa.php');
    }

        //FUNÇÃO PARA VERIFICAR SE O USUARIO ESTA OU NÃO EM UMA SESSION
    function verificaUsuario(){
        if((!isset($_SESSION['email']) == true) && (!isset($_SESSION['senha']) == true)){
            expulsaUsuario();
        }
    }
?>