<?php
session_start();
include_once('config.php');  
include_once('tipoProjetoFuncoes.php');  

$response = ['success' => false, 'message' => ''];

if (isset($_SESSION['id']) && isset($_SESSION['tipoUsuario'])) {
    $id_docente = $_SESSION['id'];  
    $tipoUsuario = $_SESSION['tipoUsuario'];

    if ($tipoUsuario !== 'docente') {
        $response['message'] = 'Acesso negado. Apenas docentes podem cadastrar tipos de projeto.';
        $_SESSION['message'] = $response['message'];
        header("Location: ../../frontend/pages/superUsuarioPrincipal.html");  
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nomeTipoProjeto = $_POST['nomeTipoProjeto'];  

        if (empty($nomeTipoProjeto)) {
            $response['message'] = 'O nome do tipo de projeto é obrigatório.';
            $_SESSION['message'] = $response['message'];  
            header("Location: ../../frontend/pages/superUsuarioPrincipal.html");  
            exit();
        }

        $resultado = cadastrarTipoProjeto($nomeTipoProjeto, $conexao);

        if ($resultado['status']) {
            $_SESSION['message'] = 'Tipo de projeto cadastrado com sucesso!';
            header("Location: ../../frontend/pages/superUsuarioPrincipal.html");  
            exit();
        } else {
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
