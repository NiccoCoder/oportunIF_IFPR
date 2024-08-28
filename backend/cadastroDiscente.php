<?php
    if(isset($_POST['submit'])){

        include_once('config.php');

        $nome = $_POST['nomeDiscente'];
        $email = $_POST['emailDiscente'];
        $senha = $_POST['senhaDiscente'];
        $curso = $_POST['cursoDiscente'];

        if (!$nome || !$email || !$senha || !curso) {
            // $_SESSION['message'] = 'Todos os campos são obrigatórios';
            header("Location: ../frontend/pages/cadastroAluno.html?error=Todos os campos são obrigatórios");
            exit;
        }

        //Criptografia da senha
        $senha_cripto = password_hash($senha, PASSWORD_DEFAULT);

        // Query responsavel por armazenar os valores e inserir na tabelas de Discentes
        $insert_script = "INSERT INTO TB_DISCENTE (NOME ,EMAIL, SENHA, CURSO) VALUES ('$nome', '$email', '$senha_cripto', '$curso')";

        //Execução do banco de dados de inserção
        $result = mysqli_query($conexao, $insert_script);

        if($result) {
            header("Location: ../frontend/pages/logindiscente.html");
            exit();
        } else {
            echo 'Falha ao registrar discente: ' . mysql_error($conexao);;
        }
         
    } else {
        header("Location: ../frontend/pages/cadastroAluno.html");
        // $nome = $_POST['nomeDiscente'];
        // $email = $_POST['emailDiscente'];
        // $senha = $_POST['senhaDiscente'];
        // $curso = $_POST['cursoDiscente'];d
        
        // echo ' nome =>' . $nome;
        // echo ' email =>' . $email;
        // echo ' senha =>' . $senha;
        // echo ' curso =>' . $curso;
        // echo 'Nova senha =>' . $senha_cripto;
        exit();
    }

?>


