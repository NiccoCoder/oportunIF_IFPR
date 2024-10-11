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
        $_SESSION['id'] = $resultado['id'];
        $_SESSION['nome'] = $resultado['nome'];
        $_SESSION['email'] = $email;
        $_SESSION['tipoUsuario'] = $tipoUsuario;
        $_SESSION['super_usuario'] = $resultado['super_usuario'] ?? 0;
        $_SESSION['sessao_ativa'] = true; 
        
        // Redirecionar com base no tipo de usuário
        if ($tipoUsuario === 'discente') {
            header("Location: ../frontend/pages/discenteVisualizar.html");
        } elseif ($tipoUsuario === 'docente') {
            // Verifica se é super usuário
            if ($_SESSION['super_usuario'] == 1) {
                header("Location: ../frontend/pages/superUsuarioPrincipal.html");
            } else {
                header("Location: ../frontend/pages/docenteVisualizar.html");
            }
        }
        exit(); 
    } else {
        //Finaliza a seção e redireciona em caso de falha
        session_destroy();
        $id = isset($resultado['id']) ? $resultado['id'] : '';
        header("Location: ../frontend/pages/login.html?error=" . urlencode($resultado['message']) . "&id=" . urlencode($id));
        exit();
    }
} else {
    //Caso ocorra algum erro finaliza a seção que foi iniciada e direciona para o login
    session_destroy();
    header("Location: ../frontend/pages/login.html?error=" . urlencode('Ocorreu um erro. Porfavor tente novamente'));
    exit(); 
}
?>
