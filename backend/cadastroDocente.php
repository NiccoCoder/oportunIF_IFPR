<?php
include_once('config.php');
include_once('funcoes.php');

if (isset($_POST['submit'])) {
    // Obtém os dados do formulário
    $nome = $_POST['nomeDocente'];
    $email = $_POST['emailDocente'];
    $senha = $_POST['senhaDocente'];
    
    if (!$nome || !$email || !$senha) {
        header("Location: ../frontend/pages/cadastroProfessor.html?error=Todos os campos são obrigatórios");
        exit;
    }

    // Chama a função para cadastrar o docente
    $resultado = cadastrarDocente($nome, $email, $senha, $conexao);

    // Verifica se o resultado é um array e tem a chave 'status'
    if (is_array($resultado) && isset($resultado['status']) && $resultado['status']) {
        $assunto = 'Valide sua conta';
        $resposta = enviarEmail($email, $assunto);

        // Verifica se a resposta é um array e tem a chave 'status'
        if (is_array($resposta) && isset($resposta['status']) && $resposta['status']) {
            header("Location: ../frontend/pages/login.html");
        } else {
            header("Location: ../frontend/pages/cadastroProfessor.html?error=" . urlencode($resposta['message']));
        }
    } else {
        header("Location: ../frontend/pages/cadastroProfessor.html?error=" . urlencode($resultado['message']));
    }
}
?>
