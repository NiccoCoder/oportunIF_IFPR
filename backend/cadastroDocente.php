<?php
    if (isset($_POST['submit'])) {
        // Inclui o arquivo de configuração para conexão com o banco de dados
        include_once('config.php');

        // Obtém os dados do formulário
        $nome = $_POST['nomeDocente'];
        $email = $_POST['emailDocente'];
        $senha = $_POST['senhaDocente'];
        
        if (!$nome || !$email || !$senha) {
            // $_SESSION['message'] = 'Todos os campos são obrigatórios';
            header("Location: ../frontend/pages/cadastroAluno.html?error=Todos os campos são obrigatórios");
            exit;
        }

        // Criptografa a senha
        $senha_cripto = password_hash($senha, PASSWORD_DEFAULT);

        // Insere o docente na tabela TB_DOCENTE
        $insert_script = "INSERT INTO TB_DOCENTE (NOME, EMAIL, SENHA) VALUES ('$nome', '$email', '$senha_cripto')";
        
        //Execução do banco de dados de inserção
        $result = mysqli_query($conexao, $insert_script);
        
        if($result) {
            header("Location: ../frontend/pages/logindocente.html");
            exit();
        } else {
            echo 'Falha ao registrar docente: ' . mysql_error($conexao);
        }

    } else {
        header("Location: ../frontend/pages/cadastroProfessor.html");
        exit();
    }
?>