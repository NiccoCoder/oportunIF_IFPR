
<?php
    //Ve se ele foi caregado com um submit
    if(isset($_POST['submit'])){
/*
    Se quiser ver os prints
    {
        print_r();
        print_r($_POST['email']);
        print_r($_POST['genero']);
        print_r($_POST['senha']);
    }
    
*/

            //Chama o metodo de configuração do banco
        include_once('config.php');
            //Criação de variaveis dom os dados recebidos
        $nome = $_POST['userNome'];
        $genero = $_POST['Genero'];
        $email = $_POST['userEmail'];
        $senha = $_POST['userSenha'];
        $tipo = $_POST['tipo'];


        
        print($tipo);
            //Criptação da senha
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
    <script src="script.js"></script>
</head>
<body>
    
    <form action="cad.php" method="POST" id="userRegister" onsubmit=validarEmail(this.id)>
        <label for="nome">Nome</label>
        <input type="text" name="userNome"> <br>
        <label for="email">Email</label>
        <input type="text" id='userEmail' name="userEmail" onchange="validarEmail(this.id)" required autofocus>
        <label for="nome">Senha</label>
        <input type="senha" name="userSenha" required> <br>
        
        <input type="radio" id="masculino" name="genero" value="masculino">
        <label for="masculino">Masculino</label><br>
        <input type="radio" id="feminino" name="genero" value="feminino">
        <label for="feminino">Feminino</label><br>
        <input type="radio" id="javascript" name="genero" value="outro">
        <label for="outro">Outro</label><br>

        <input type="radio" name="tipo" id="estudante" value="e"> 
        <label for="estudante"> Estudante</label> <br>
        <input type="radio" name="tipo" id="docente" value="d">
        <label for="docente"> Docente</label> <br>
        <input type="submit" name="submit" value="Enviar">
    </form>
    <br>
    
</body>
</html>

