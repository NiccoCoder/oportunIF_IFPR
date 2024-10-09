<?php
session_start();
include_once('config.php');
include_once('projetoFuncoes.php');

// Verifica se a sessão está ativa e se o usuário é um docente
if (isset($_SESSION['id']) && isset($_SESSION['tipoUsuario'])) {
    $id_docente = $_SESSION['id']; // Armazena o ID do usuário
    $tipoUsuario = $_SESSION['tipoUsuario'];

    // Verifica se o usuário é um docente
    if ($tipoUsuario !== 'docente') {
        header("Location: ../frontend/pages/cadastroProjeto.html?error=" . urlencode('Acesso negado. Apenas docentes podem cadastrar projetos.'));
        exit();
    }

    // Processa o formulário somente se o botão de envio foi pressionado
    if (isset($_POST['submit'])) {
        $titulo = $_POST['titulo'];
        $id_tipo_projeto = $_POST['id_tipo_projeto'];
        $criterios_selecao = $_POST['criterios_selecao'];
        $resumo = $_POST['resumo'];

        $bolsa_disponivel = isset($_POST['bolsa_disponivel']) ? 1 : 0;
        $descricao_bolsa = $bolsa_disponivel ? $_POST['descricao_bolsa'] : null;
        $requisito_bolsa = $bolsa_disponivel ? $_POST['requisito_bolsa'] : null;
        $carga_horaria = $bolsa_disponivel ? $_POST['carga_horaria'] : null;
        $valor_bolsa = $bolsa_disponivel ? $_POST['valor_bolsa'] : null;

        // Valida os campos obrigatórios
        if (empty($titulo) || empty($id_tipo_projeto) || empty($criterios_selecao) || empty($resumo)) {
            header("Location: ../frontend/pages/cadastroProjeto.html?error=" . urlencode('Todos os campos são obrigatórios'));
            exit();
        }

        
        // Cadastra o projeto
        $resultado = cadastrarProjeto($id_docente, $titulo, $id_tipo_projeto, $criterios_selecao, $resumo, $conexao, $bolsa_disponivel, $descricao_bolsa, $requisito_bolsa, $carga_horaria, $valor_bolsa);

        // Verifica o resultado do cadastro
        if (is_array($resultado) && isset($resultado['status']) && $resultado['status']) {
            $_SESSION['message'] = 'Projeto cadastrado com sucesso!';
            header("Location: ../frontend/pages/docenteVisualizar.html");
            exit(); 
        } else {
            header("Location: ../frontend/pages/cadastroProjeto.html?error=" . urlencode($resultado['message']));
            exit();
        }
    }
} else {
    // Redireciona se a sessão não estiver ativa
    header("Location: ../frontend/pages/cadastroProjeto.html?error=" . urlencode('Sessão não está ativa'));
    exit();
}
