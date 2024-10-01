<?php

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

include_once('config.php');

function cadastrarDiscente($nome, $email, $senha, $curso, $conexao) {
    
    //Verificação de Registros duplicados com email 
    $check_email_query = "SELECT * FROM TB_DISCENTE WHERE EMAIL = ?";
    $stmt = $conexao->prepare($check_email_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        return ['status' => false, 'message' => 'Este e-mail já está cadastrado.'];
    }
    
    // Criptografia da senha
    $senha_cripto = password_hash($senha, PASSWORD_DEFAULT);
    $chave = password_hash($email . date("Y-m-d H:i:s"), PASSWORD_DEFAULT);
    
    // Criptografia da senha e criação de uma chave para a validação
    $insert_script = "INSERT INTO TB_DISCENTE (NOME, EMAIL, SENHA, ID_CURSO, CHAVE) VALUES (?, ?, ?, ?, ?)";
    
    // Preparar e executar a query de forma segura
    $stmt = $conexao->prepare($insert_script);
    $stmt->bind_param("sssis", $nome, $email, $senha_cripto, $curso, $chave);
    
    if ($stmt->execute()) {
        return ['status' => true, 'message' => 'Cadastro realizado com sucesso'];
    } else {
        return ['status' => false, 'message' => 'Falha ao registrar discente: ' . $stmt->error];
    }
}

function cadastrarDocente($nome, $email, $senha, $conexao) {
    // Verifica se o email já existe
    $check_email_query = "SELECT * FROM TB_DOCENTE WHERE EMAIL = ?";
    $stmt = $conexao->prepare($check_email_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        return ['status' => false, 'message' => 'Este e-mail já está cadastrado.'];
    }

    // Criptografia da senha e criação de uma chave para a validação
    $senha_cripto = password_hash($senha, PASSWORD_DEFAULT);
    $chave = password_hash($email . date("Y-m-d H:i:s"), PASSWORD_DEFAULT);

    // Query para inserir os valores na tabela de discentes
    $insert_script = "INSERT INTO TB_DOCENTE (NOME, EMAIL, SENHA, CHAVE) VALUES (?, ?, ?, ?)";

    // Preparar e executar a query de forma segura
    $stmt = $conexao->prepare($insert_script);
    $stmt->bind_param("ssss", $nome, $email, $senha_cripto, $chave);
    
    if ($stmt->execute()) {
        return ['status' => true, 'message' => 'Cadastro realizado com sucesso'];
    } else {
        return ['status' => false, 'message' => 'Falha ao registrar docente: ' . $stmt->error];
    }
}

function reenviarEmailValidacao($nome, $email, $chave, $tipoUsuario) {
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';

    try {
        // Configurações do servidor
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = getenv('USERNAME'); 
        $mail->Password = getenv('PASSWORD'); 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Remetente e destinatário
        $mail->setFrom(getenv('SEND_FROM'), getenv('SEND_FROM_NAME'));
        $mail->addAddress($email);
        // $mail->addAddress('nicolasczaikowski@gmail.com');
        // Link de validação
        $link = "http://localhost/backend/ativarConta.php?chave=$chave&tipoUsuario=$tipoUsuario";
        $assunto = 'Reenvio de validação de conta';
        
        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = $assunto;
        $mail->Body = '
            Olá, ' . htmlspecialchars($nome) . '<br><br>
            Recebemos uma solicitação para reenviar a validação da sua conta. Por favor, valide sua conta clicando no link abaixo:<br><br>
            <a href="' . htmlspecialchars($link) . '">Validar</a><br>
        ';

        $mail->AltBody = 'Olá, ' . htmlspecialchars($nome) . '\n\n' .
                         'Recebemos uma solicitação para reenviar a validação da sua conta. Por favor, valide sua conta clicando no link abaixo:\n\n' .
                         'Validar: ' . htmlspecialchars($link) . '\n';

        // Envio do e-mail
        $mail->send();
        return ['status' => true, 'message' => 'E-mail de validação reenviado com sucesso!'];
    } catch (Exception $e) {
        return ['status' => false, 'message' => 'Erro ao enviar o e-mail: ' . $mail->ErrorInfo];
    }
}

function enviarEmail($nome, $email, $chave, $tipoUsuario) {
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    
    try {
        // Configurações do servidor
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = getenv('USERNAME'); 
        $mail->Password = getenv('PASSWORD'); 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Remetente e destinatário
        $mail->setFrom(getenv('SEND_FROM'), getenv('SEND_FROM_NAME'));
        $mail->addAddress($email);
        // $mail->addAddress('nicolasczaikowski@gmail.com');
        
        // Links de confirmação
        $link = "http://localhost/backend/ativarConta.php?chave=$chave&tipoUsuario=$tipoUsuario"; 
        $rejeitar_link = "http://localhost/backend/rejeitarConta.php?chave=$chave&tipoUsuario=$tipoUsuario"; 
        $assunto = 'Valide sua conta';
            
        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = $assunto;
        $mail->Body = '
        Olá, ' . htmlspecialchars($nome) . ' <br><br>
        Seja bem-vindo ao OportunIF! Recebemos uma tentativa de criação de conta com o e-mail ' . htmlspecialchars($email) . '. Por favor, confirme se foi você quem fez essa solicitação.<br><br>
        <a href="' . htmlspecialchars($link) . '">Validar</a><br>
        <a href="' . htmlspecialchars($rejeitar_link) . '">Recusar</a><br>
        ';
        
        $mail->AltBody = 'Olá ,' . htmlspecialchars($nome) . '\n\n' .
        'Seja bem-vindo ao OportunIF! Recebemos uma tentativa de criação de conta com o e-mail ' . htmlspecialchars($email) . '. Por favor, confirme se foi você quem fez essa solicitação.\n\n' .
        'Validar: ' . htmlspecialchars($link) . '\n' .
        'Recusar: ' . htmlspecialchars($rejeitar_link) . '\n';
        
        $mail->send();
        return ['status' => true, 'message' => 'E-mail enviado com sucesso!'];
    } catch (Exception $e) {
        return ['status' => false, 'message' => "Erro ao enviar e-mail: {$mail->ErrorInfo}"];
    }
}

function buscarCursos($conexao) {
    $query = "SELECT ID_CURSO, NOME_CURSO FROM TB_CURSO";
    $result = mysqli_query($conexao, $query);

    // Verifica se existem cursos
    if (!$result || mysqli_num_rows($result) == 0) {
        return [];
    }

    $cursos = [];
    while ($curso = mysqli_fetch_assoc($result)) {
        $cursos[] = $curso;
    }
    return $cursos;
}

function verificarCredenciaisDiscente($email, $senha, $conexao) {
    // Prepara a consulta SQL para buscar a senha e a situação
    $query = "SELECT id_discente, senha, situacao FROM TB_DISCENTE WHERE EMAIL = ?";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Verifica se o e-mail foi encontrado
    if (!$row) {
        return ['status' => false, 'message' => 'E-mail não encontrado'];
    }

    // Verifica a situação do usuário (Pendente ou Confirmado)
    if ($row['situacao'] === 'pendente') {
        return ['status' => false, 'message' => 'Seus cadastro está pendente.', 'id' => $row['id_discente']];
    }

    // Verifica se a senha está correta
    if (password_verify($senha, $row['senha'])) {
        return [
            'status' => true,
            'id' => $row['id_discente'], // Retorna o ID do discente
        ];
    } else {
        return ['status' => false, 'message' => 'Senha incorreta'];
    }
}

function verificarCredenciaisDocente($email, $senha, $conexao) {
    // Prepara a consulta SQL para buscar a senha, situação e super usuário
    $query = "SELECT id_docente, senha, situacao, super_usuario FROM TB_DOCENTE WHERE email = ?";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Verifica se o e-mail foi encontrado
    if (!$row) {
        return ['status' => false, 'message' => 'E-mail não encontrado'];
    }

    // Verifica a situação do usuário (Pendente ou Confirmado)
    if ($row['situacao'] === 'pendente') {
        $idDocente = $row['id_docente']; // Armazena o ID
        // die("ID do Docente: " . $idDocente);
        return ['status' => false, 'message' => 'Seu cadastro está pendente.', 'id' => $idDocente];
    }

    // Verifica se a senha está correta
    if (password_verify($senha, $row['senha'])) {
        return [
            'status' => true,
            'id' => $row['id_docente'], // Pegando o ID do Docente
            'super_usuario' => $row['super_usuario'] // Pegando o status de super usuário
        ];
    } else {
        return ['status' => false, 'message' => 'Senha incorreta'];
    }
}

?>
