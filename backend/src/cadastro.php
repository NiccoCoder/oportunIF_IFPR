
<?php
    if(isset($_POST['submit'])){
/*
    {
        print_r();
        print_r($_POST['email']);
        print_r($_POST['genero']);
        print_r($_POST['senha']);
    }
    
*/

        include_once('config.php');
        $nome = $_POST['userNome'];
        $genero = $_POST['Genero'];
        $email = $_POST['userEmail'];
        $senha = $_POST['userSenha'];
        $tipo = $_POST['tipo'];


        
        print($tipo);
            //Criptografia da senha
        $senha_cripto = password_hash($senha, PASSWORD_DEFAULT);
            //Execusão do banco de dados de inserção
        $result = mysqli_query($conexao, "INSERT INTO tb_usuario(nome_usuario ,email_usuario ,genero_usuario ,senha_usuario, tipo_usuario) VALUES ('$nome','$email','$genero','$senha_cripto', '$tipo[0]')");
        $foto = mysqli_query($conexao, "INSERT INTO tb_foto(path, tb_usuario_email_usuario) VALUES ('arquivos/Default.png','$email')");

        switch ($tipo) {
            case "e":
                $result_tipo = mysqli_query($conexao, "INSERT INTO tb_aluno(tb_usuario_email_usuario) VALUES('$email')");
                echo "aluno po";
                break;
            case 'd':
                $result_tipo = mysqli_query($conexao, "INSERT INTO tb_docente(tb_usuario_email_usuario) VALUES('$email')");
                break;
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="validationEmail.js"></script>
</head>
<body>
    
    <form action="#" method="POST" id="userRegister" onsubmit= validarEmailDocente(this.id)>
        <label for="nome">Nome</label> <br>
        <input type="text" name="userNome"> <br>
        <label for="email">Email Docente</label><br>
        <input type="text" id='userEmail' name="userEmail" onchange="validarEmailDocente(this.id)" required autofocus> <br>
        <label for="nome">Senha</label><br>
        <input type="senha" name="userSenha"> <br>

        <input type="submit" name="submit" value="Enviar">
    </form>
    <br>
    <form action="#" method="POST" id="userRegister" onsubmit= validarEmailDicente(this.id)>
        <label for="nome">Nome</label> <br>
        <input type="text" name="userNome"> <br>
        <label for="email">Email Discente</label><br>
        <input type="text" id='userEmail' name="userEmail" onchange="validarEmailDiscente(this.id)" required autofocus> <br>
        <label for="nome">Senha</label><br>
        <input type="senha" name="userSenha"> <br>

        <input type="submit" name="submit" value="Enviar">
    </form>
    
</body>
</html>

