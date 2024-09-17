<?php

include_once('config.php');
include_once('funcoes.php');

// Verificar se o formulário foi enviado
if (isset($_POST['submit'])) {
    // Receber os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $tipoUsuario = $_POST['tipoUsuario']; // Receber o tipo de usuário

    // Verificar credenciais com base no tipo de usuário
    if ($tipoUsuario === 'discente') {
        $resultado = verificarCredenciaisDiscente($email, $senha, $conexao);
    } elseif ($tipoUsuario === 'docente') {
        $resultado = verificarCredenciaisDocente($email, $senha, $conexao);
    } else {
        // Tipo de usuário não reconhecido
        header("Location: ../frontend/pages/login.html?error=" . urlencode('Tipo de usuário não reconhecido.'));
        exit();
    }

    if ($resultado['status']) {
        // Iniciar a sessão e redirecionar
        session_start();
        $_SESSION['email'] = $email;
        header("Location: ../frontend/pages/paginavisitante.html");
    } else {
        // Redirecionar com a mensagem de erro
        header("Location: ../frontend/pages/login.html?error=" . urlencode($resultado['message']));
    }
} else {
    header("Location: ../frontend/pages/login.html");
    exit();
}

?>
