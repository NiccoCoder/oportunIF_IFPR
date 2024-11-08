<?php
session_start();
include_once('config.php');  // Inclui as configurações de banco de dados
include_once('cursoFuncoes.php');  // Inclui as funções do curso

$response = ['success' => false, 'message' => ''];

// Verifica se a sessão está ativa e se o usuário é um docente
if (isset($_SESSION['id']) && isset($_SESSION['tipoUsuario'])) {
    $id_docente = $_SESSION['id'];  // Armazena o ID do usuário
    $tipoUsuario = $_SESSION['tipoUsuario'];

    // Verifica se o usuário é um docente
    if ($tipoUsuario !== 'docente') {
        $response['message'] = 'Acesso negado. Apenas docentes podem cadastrar cursos.';
        $_SESSION['message'] = $response['message'];  // Armazena a mensagem na sessão
        header("Location: ../../frontend/pages/superUsuarioPrincipal.html");
        exit();
    }

    // Processa o formulário somente se o botão de envio foi pressionado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nomeCurso = $_POST['nomeCurso'];  // Nome do curso vindo do formulário

        // Valida os campos obrigatórios
        if (empty($nomeCurso)) {
            $response['message'] = 'O nome do curso é obrigatório.';
            $_SESSION['message'] = $response['message'];  
            header("Location: ../../frontend/pages/superUsuarioPrincipal.html");  
            exit();
        }
        
        // Cadastra o curso chamando a função cadastrarCurso()
        $resultado = cadastrarCurso($nomeCurso, $conexao);

        // Verifica o resultado do cadastro
        if ($resultado['status']) {
            // Caso de sucesso
            $_SESSION['message'] = 'Curso cadastrado com sucesso!';
            header("Location: ../../frontend/pages/superUsuarioPrincipal.html");  
            exit();
        } else {
            // Caso de falha ao cadastrar o curso
            $response['message'] = $resultado['message'];
            $_SESSION['message'] = $response['message'];  
            header("Location: ../../frontend/pages/superUsuarioPrincipal.html");  
            exit();
        }
    } else {
        $response['message'] = 'Método não permitido.';
        $_SESSION['message'] = $response['message'];  
        header("Location: ../../frontend/pages/superUsuarioPrincipal.html");  
        exit();
    }
} else {
    $response['message'] = 'Sessão não está ativa';
    $_SESSION['message'] = $response['message'];  
    header("Location: ../../frontend/pages/superUsuarioPrincipal.html");  
    exit();
}

echo json_encode($response);
?>
