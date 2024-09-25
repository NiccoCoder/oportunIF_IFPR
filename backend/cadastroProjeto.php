<?php
include_once('config.php');
include_once('projetoFuncoes.php');

if (isset($_POST['submit'])) {
    
    // $id_docente = $_POST['id_docente'];
    $titulo = $_POST['titulo'];
    $id_tipo_projeto = $_POST['id_tipo_projeto'];
    $criterios_selecao = $_POST['criterios_selecao'];
    $resumo = $_POST['resumo'];

    if (!$id_docente || !$titulo || !$id_tipo_projeto || !$criterios_selecao || !$resumo) {
        header("Location: ../frontend/pages/cadastroProjeto.html?error=" . urlencode('Todos os campos são obrigatórios'));
        exit();
    }

    $resultado = cadastrarProjeto($id_docente, $titulo, $id_tipo_projeto, $criterios_selecao, $resumo, $conexao);

    // Verificar o resultado e redirecionar ou exibir erro
    if (is_array($resultado) && isset($resultado['status']) && $resultado['status']) {
        $_SESSION['message'] = 'Projeto cadastrado com sucesso!';
        header("Location: ../frontend/pages/docenteVisualizar.html");
        exit(); 
    } else {
        header("Location: ../frontend/pages/cadastroProjeto.html?error=" . urlencode($resultado['message']));
        exit();
    }
} else {
    header("Location: ../frontend/pages/cadastroProjeto.html");
    exit(); 
}
?>
