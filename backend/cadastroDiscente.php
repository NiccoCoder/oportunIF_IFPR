<?php
include_once('config.php');
include_once('funcoes.php');

// Verifica se o formulário foi enviado
if (isset($_POST['submit'])) {
    $nome = $_POST['nomeDiscente'];
    $email = $_POST['emailDiscente'];
    $senha = $_POST['senhaDiscente'];
    $curso = $_POST['cursoDiscente'];


    // Verificar se todos os campos foram preenchidos
    if (!$nome || !$email || !$senha || !$curso) {
        header("Location: ../frontend/pages/cadastroAluno.html?error=" . urlencode('Todos os campos são obrigatórios'));
        exit();
    }

    // Chamar a função para cadastrar o discente
    $resultado = cadastrarDiscente($nome, $email, $senha, $curso, $conexao);

    // Verificar o resultado e redirecionar ou exibir erro
    if ($resultado['status']) {
        // Valida o email

        $assunto = 'Valide sua conta ';
        $resposta = enviarEmail($email, $assunto);

        // Se a validação do email for bem-sucedida, redireciona para o login
        if ($resposta['status']) {
            header("Location: ../frontend/pages/login.html");
        } else {
            // Caso contrário, redireciona para a página de erro
            header("Location: ../frontend/pages/cadastroAluno.html?error=" . urlencode($resposta['message']));
        }
    } else {
        // Redirecionar caso ocorra erro no cadastro
        header("Location: ../frontend/pages/cadastroAluno.html?error=" . urlencode($resultado['message']));
    }
    exit();
} else {
    // Exibir uma mensagem se o formulário não for enviado
    echo "<p>Preencha o formulário para cadastrar um discente.</p>";
}
?>
