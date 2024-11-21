<?php
session_start(); // Certifique-se de iniciar a sessão
include_once('config.php'); // Conexão já configurada
include_once('projetoFuncoes.php');

// Verifica se a sessão está ativa e se o usuário é um docente
if (isset($_SESSION['id']) && isset($_SESSION['tipoUsuario'])) {
    $id_docente = $_SESSION['id'];
    $tipoUsuario = $_SESSION['tipoUsuario'];

    // Verifica se o usuário é um docente
    if ($tipoUsuario !== 'docente') {
        $response['message'] = 'Acesso negado. Apenas docentes podem notificar alunos.';
        echo json_encode($response);
        exit();
    }

    // Verifica se o ID do projeto está na sessão
    if (!isset($_SESSION['id_projeto'])) {
        header('Location: ../frontend/pages/docenteVisualizar.html');
        exit();
    }
    
    $id_projeto = $_SESSION['id_projeto'];
    $cursoSelecionado = isset($_GET['curso']) ? $_GET['curso'] : 'todos';

    // Obtém o título do projeto
    $tituloProjetoQuery = "SELECT TITULO FROM TB_PROJETO WHERE ID_PROJETO = ?";
    $stmt = $conexao->prepare($tituloProjetoQuery);
    $stmt->bind_param("i", $id_projeto);
    $stmt->execute();

    $resultado = $stmt->get_result();
    if ($resultado->num_rows === 0) {
        header('Location: ../frontend/pages/docenteVisualizar.html');
        exit();
    }

    $tituloProjeto = $resultado->fetch_assoc()['TITULO'];
    $stmt->close();

    // Chama a função de notificação
    $resultadoNotificacao = notificarAlunos($conexao, $tituloProjeto, $cursoSelecionado);

    // Verifica se algum e-mail foi enviado
    if (!$resultadoNotificacao['success'] || empty($resultadoNotificacao['emailsEnviados'])) {
        header('Location: ../frontend/pages/docenteVisualizar.html');
        exit();
    }

    // Redireciona após sucesso
    header('Location: ../frontend/pages/docenteVisualizar.html');
    exit();
} else {
    header('Location: ../frontend/pages/docenteVisualizar.html');
    exit();
}
?>
