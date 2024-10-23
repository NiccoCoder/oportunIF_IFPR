<?php
session_start(); // Certifique-se de iniciar a sessão
include_once('config.php'); // Conexão já configurada
include_once('projetoFuncoes.php');

// Verifica se a sessão está ativa e se o usuário é um docente
if (isset($_SESSION['id']) && isset($_SESSION['tipoUsuario'])) {
    $id_docente = $_SESSION['id']; // Armazena o ID do usuário
    $tipoUsuario = $_SESSION['tipoUsuario'];

    // Verifica se o usuário é um docente
    if ($tipoUsuario !== 'docente') {
        $response['message'] = 'Acesso negado. Apenas docentes podem notificar alunos.';
        echo json_encode($response);
        exit();
    }

    // Verifica se o ID do projeto está na sessão
    if (!isset($_SESSION['id_projeto'])) {
        // Redireciona para a página docenteVisualizar.html
        header('Location: ../frontend/pages/docenteVisualizar.html');
        exit();
    }
    
    $id_projeto = $_SESSION['id_projeto']; // Obtém o ID do projeto
    $cursoSelecionado = isset($_GET['curso']) ? $_GET['curso'] : 'todos';

    // Obtém o título do projeto
    $tituloProjetoQuery = "SELECT TITULO FROM TB_PROJETO WHERE ID_PROJETO = ?";
    $stmt = $conexao->prepare($tituloProjetoQuery);
    $stmt->bind_param("i", $id_projeto);
    $stmt->execute();
    
    // Verifica se o projeto foi encontrado
    $resultado = $stmt->get_result();
    if ($resultado->num_rows === 0) {
        // Redireciona para a página docenteVisualizar.html
        header('Location: ../frontend/pages/docenteVisualizar.html');
        exit();
    }

    $tituloProjeto = $resultado->fetch_assoc()['TITULO'];
    $stmt->close();

    // Chama a função de notificação
    $resultadoNotificacao = notificarAlunos($conexao, $tituloProjeto, $cursoSelecionado);

    // Verifica o resultado da notificação
    if ($resultadoNotificacao['success']) {
        // Redireciona para a página inicial dos docentes
        header('Location: ../frontend/pages/docenteVisualizar.html'); // Ajuste para o caminho correto
        exit();
    } else {
        $response['message'] = $resultadoNotificacao['message'] ?? 'Nenhum e-mail enviado.';
    }
} else {
    $response['message'] = 'Sessão não está ativa';
}

// Retorna a resposta em formato JSON
echo json_encode($response);
?>
