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
        $response['message'] = 'Acesso negado. Apenas docentes podem editar projetos.';
        echo json_encode($response);
        exit();
    }

    // Processa o formulário somente se o botão de envio foi pressionado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitizando os dados recebidos
        $id_projeto = isset($_POST['id_projeto']) ? htmlspecialchars($_POST['id_projeto']) : '';
        $titulo = isset($_POST['titulo']) ? htmlspecialchars($_POST['titulo']) : '';
        $id_tipo_projeto = isset($_POST['id_tipo_projeto']) ? htmlspecialchars($_POST['id_tipo_projeto']) : '';
        $criterios_selecao = isset($_POST['criterios_selecao']) ? htmlspecialchars($_POST['criterios_selecao']) : '';
        $resumo = isset($_POST['resumo']) ? htmlspecialchars($_POST['resumo']) : '';

        // Verifica se o campo de bolsa está marcado
        $bolsa_disponivel = isset($_POST['bolsa_disponivel']) ? 1 : 0;

        // Se bolsa disponível, pega as informações adicionais
        $descricao_bolsa = $bolsa_disponivel ? (isset($_POST['descricao_bolsa']) ? htmlspecialchars($_POST['descricao_bolsa']) : null) : null;
        $requisito_bolsa = $bolsa_disponivel ? (isset($_POST['requisito_bolsa']) ? htmlspecialchars($_POST['requisito_bolsa']) : null) : null;

        // Exibindo os dados que serão passados para a função editarProjeto
        echo '<pre>';
        echo "Valores sendo passados para editarProjeto: \n";
        var_dump([
            'id_projeto' => $id_projeto,
            'id_docente' => $id_docente,
            'titulo' => $titulo,
            'id_tipo_projeto' => $id_tipo_projeto,
            'criterios_selecao' => $criterios_selecao,
            'resumo' => $resumo,
            'bolsa_disponivel' => $bolsa_disponivel,
            'descricao_bolsa' => $descricao_bolsa,
            'requisito_bolsa' => $requisito_bolsa
        ]);
        echo '</pre>';
        die(); // Impede que o script continue, permitindo a inspeção dos dados

        // Edita o projeto
        $resultado = editarProjeto($id_projeto, $id_docente, $titulo, $id_tipo_projeto, $criterios_selecao, $resumo, $conexao, $bolsa_disponivel, $descricao_bolsa, $requisito_bolsa);

        // Verifica o resultado da edição
        if (is_array($resultado) && isset($resultado['status']) && $resultado['status']) {
            $_SESSION['message'] = 'Projeto editado com sucesso!';
            $_SESSION['showModal'] = true;
            header('Location: ../frontend/pages/projetoCadastro.html?showModal=true');
            exit();
        } else {
            $response['message'] = $resultado['message'] ?? 'Erro ao editar o projeto.';
            echo json_encode($response);
            exit();
        }
    } else {
        $response['message'] = 'Método não permitido.';
        echo json_encode($response);
        exit();
    }
} else {
    $response['message'] = 'Sessão não está ativa';
    echo json_encode($response);
    exit();
}
?>
