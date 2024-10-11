<?php
include_once('config.php');
include_once('usuarioFuncoes.php');

if (isset($_POST['submit'])) {

    $nome = $_POST['nomeDocente'];
    $email = $_POST['emailDocente'];
    $senha = $_POST['senhaDocente'];
    

    if (!$nome || !$email || !$senha) {
        header("Location: ../frontend/pages/docenteCadastro.html?error=Todos os campos são obrigatórios");
        exit;
    }

    $resultado = cadastrarDocente($nome, $email, $senha, $conexao);
    
    if (is_array($resultado) && isset($resultado['status']) && $resultado['status']) {

        $tipoUsuario = 'Docente';
        $chave = $resultado['chave'];

        $resposta = enviarEmail($nome, $email, $chave, $tipoUsuario);

        if (is_array($resposta) && isset($resposta['status']) && $resposta['status']) {
            header("Location: ../frontend/pages/login.html");
        } else {
            header("Location: ../frontend/pages/docenteCadastro.html" . urlencode($resposta['message']));
        }
    } else {
        header("Location: ../frontend/pages/docenteCadastro.html?error=" . urlencode($resultado['message']));
    }
}
?>
