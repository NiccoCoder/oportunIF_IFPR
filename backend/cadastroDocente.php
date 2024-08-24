<?php
if (isset($_POST['submit'])) {
    // Inclui o arquivo de configuração para conexão com o banco de dados
    include_once('config.php');

    // Obtém os dados do formulário
    $nome = $_POST['userNome'];
    $email = $_POST['userEmail'];
    $senha = $_POST['userSenha'];

    // Criptografa a senha
    $senha_cripto = password_hash($senha, PASSWORD_DEFAULT);

    // Insere o docente na tabela TB_DOCENTE
    $sql_docente = "INSERT INTO TB_DOCENTE (NOME, EMAIL, SENHA) VALUES ('$nome', '$email', '$senha_cripto')";
    if (mysqli_query($conn, $sql_docente)) {
        echo "Docente inserido com sucesso!";
    } else {
        echo "Erro ao inserir docente: " . mysqli_error($conn);
    }

    // Fecha a conexão
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inserir Docente</title>
</head>
<body>
    <h1>Inserir Novo Docente</h1>
    <form method="post" action="">
        Nome: <input type="text" name="userNome" required><br>
        Email: <input type="email" name="userEmail" required><br>
        Senha: <input type="password" name="userSenha" required><br>
        <input type="submit" name="submit" value="Enviar">
    </form>
</body>
</html>
