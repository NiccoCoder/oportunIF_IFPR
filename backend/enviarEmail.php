<?php

include_once('funcoes.php');

if (isset($_POST['submit'])) {

    $emaildiscente = $_POST['emailDiscente'];
    $emaildocente = $_POST['emailDocente']; 

    if (!$emaildiscente && !$emaildocente) {
        echo 'O email é obrigatório';
        exit();
    }

    if ($emaildiscente) {
        $resposta = validarEmail($emaildiscente);
        return $resposta;
    } else if ($emaildocente) {
        $resposta = validarEmail($emaildocente);
        return $resposta;
    }
} else {
    header("Location: ../frontend/pages/cadastroAluno.html");
    exit();
}
?>