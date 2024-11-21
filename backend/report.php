<?php
include_once('config.php');
include_once('reportFuncoes.php');

if (isset($_POST['submit'])) {
    
    // Obtendo os dados do formulário
    $data = $_POST['report-date'];
    $titulo = $_POST['report-title'];
    $descricao = $_POST['report-description'];

    // Verificando se os campos não estão vazios
    if (!$data || !$titulo || !$descricao) {
        header("Location: ../frontend/pages/denunciar.html?error=Todos os campos são obrigatórios");
        exit;
    }
    
    // Chamada da função para enviar o e-mail de report
    $resultado = enviarEmailReport($data, $titulo, $descricao, $conexao); // Passando a conexão
    
    // Verificar o resultado do envio do e-mail
    if (is_array($resultado) && isset($resultado['status']) && $resultado['status']) {
        header("Location: ../frontend/pages/denunciar.html?success=Denuncia enviada com sucesso");
    } else {
        header("Location: ../frontend/pages/denunciar.html?error=" . urlencode($resultado['message']));
    }
}
?>
