<?php
session_start();

include_once('config.php');
include_once('usuarioFuncoes.php');

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $tipoUsuario = $_POST['tipoUsuario']; 

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
        // Armazenar informações do usuário na sessão
        $_SESSION['id'] = $resultado['id']; // Verifique se a chave 'id' está correta
        $_SESSION['email'] = $email;
        $_SESSION['tipoUsuario'] = $tipoUsuario;
        $_SESSION['super_usuario'] = $resultado['super_usuario'] ?? 0; // Certifique-se de que o padrão é 0

        // Redirecionar com base no tipo de usuário
        if ($tipoUsuario === 'discente') {
            header("Location: ../frontend/pages/discenteVisualizar.html");
        } elseif ($tipoUsuario === 'docente') {
            // Verifica se é super usuário
            if ($_SESSION['super_usuario'] == 1) {
                header("Location: ../frontend/pages/paginagerenciamento.html"); // Página para super usuários
            } else {
                header("Location: ../frontend/pages/docenteVisualizar.html");
            }
        }
        exit(); 
    } else {
        // Redirecionar com a mensagem de erro
        header("Location: ../frontend/pages/login.html?error=" . urlencode($resultado['message']));
        exit(); 
    }
} else {
    header("Location: ../frontend/pages/login.html");
    exit(); 
}
?>
