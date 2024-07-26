<?php
        //Inclui a conexão com o banco
    include_once('config.php');
        //Inicia a sessão
    session_start();
        //Expulsa o usuario (função presente no 'config.php')
    expulsaUsuario();
?>