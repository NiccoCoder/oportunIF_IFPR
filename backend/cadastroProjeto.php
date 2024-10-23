<?php
session_start();
include_once('config.php');
include_once('projetoFuncoes.php');

$response = ['success' => false, 'message' => ''];

// Verifica se a sessão está ativa e se o usuário é um docente
if (isset($_SESSION['id']) && isset($_SESSION['tipoUsuario'])) {
    $id_docente = $_SESSION['id']; // Armazena o ID do usuário
    $tipoUsuario = $_SESSION['tipoUsuario'];

    // Verifica se o usuário é um docente
    if ($tipoUsuario !== 'docente') {
        $response['message'] = 'Acesso negado. Apenas docentes podem cadastrar projetos.';
        echo json_encode($response);
        exit();
    }

    // Processa o formulário somente se o botão de envio foi pressionado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titulo = $_POST['titulo'];
        $id_tipo_projeto = $_POST['id_tipo_projeto'];
        $criterios_selecao = $_POST['criterios_selecao'];
        $resumo = $_POST['resumo'];

        $bolsa_disponivel = isset($_POST['bolsa_disponivel']) ? 1 : 0;
        $descricao_bolsa = $bolsa_disponivel ? $_POST['descricao_bolsa'] : null;
        $requisito_bolsa = $bolsa_disponivel ? $_POST['requisito_bolsa'] : null;
       
        // Valida os campos obrigatórios
        if (empty($titulo) || empty($id_tipo_projeto) || empty($criterios_selecao) || empty($resumo)) {
            $response['message'] = 'Todos os campos são obrigatórios';
            echo json_encode($response);
            exit();
        }

        // Cadastra o projeto
        $resultado = cadastrarProjeto($id_docente, $titulo, $id_tipo_projeto, $criterios_selecao, $resumo, $conexao, $bolsa_disponivel, $descricao_bolsa, $requisito_bolsa);

        // Verifica o resultado do cadastro
        if (is_array($resultado) && isset($resultado['status']) && $resultado['status']) {
            $_SESSION['message'] = 'Projeto cadastrado com sucesso!';
            $_SESSION['showModal'] = true;
            header('Location: ../frontend/pages/projetoCadastro.html?showModal=true');
            exit();
        } else {
            $response['message'] = $resultado['message'] ?? 'Erro ao cadastrar o projeto.';
        }
    } else {
        $response['message'] = 'Método não permitido.';
    }
} else {
    $response['message'] = 'Sessão não está ativa';
}

// Retorna a resposta em formato JSON
echo json_encode($response);
