<?php
include_once('config.php');
include_once('usuarioFuncoes.php');

if (isset($_POST['submit'])) {

    $nome = $_POST['nomeDiscente'];
    $email = $_POST['emailDiscente'];
    $senha = $_POST['senhaDiscente'];
    $curso = $_POST['cursoDiscente'];

    if (!$nome || !$email || !$senha || !$curso) {
        header("Location: ../frontend/pages/cadastroAluno.html?error=" . urlencode('Todos os campos são obrigatórios'));
        exit();
    }

    $resultado = cadastrarDiscente($nome, $email, $senha, $curso, $conexao);

    // Verificar o resultado e redirecionar ou exibir erro
    if (is_array($resultado) && isset($resultado['status']) && $resultado['status']) {

        $tipoUsuario = 'Discente';
        $chave = $resultado['chave'];

        $resposta = enviarEmail($nome, $email, $chave, $tipoUsuario);

        if (is_array($resposta) && isset($resposta['status']) && $resposta['status']) {
            header("Location: ../frontend/pages/login.html");
        } else {
            header("Location: ../frontend/pages/cadastroAluno.html" . urlencode($resposta['message']));
        }
    } else {
        header("Location: ../frontend/pages/cadastroAluno.html?error=" . urlencode($resultado['message']));
    }
} else {
    header("Location: ../frontend/pages/cadastroAluno.html");
}
?>
