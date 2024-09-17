<?php

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

include_once('config.php');

function cadastrarDiscente($nome, $email, $senha, $curso, $conexao) {
    // Criptografia da senha
    $senha_cripto = password_hash($senha, PASSWORD_DEFAULT);

    // Query para inserir os valores na tabela de discentes
    $insert_script = "INSERT INTO TB_DISCENTE (NOME, EMAIL, SENHA, ID_CURSO) VALUES (?, ?, ?, ?)";

    // Preparar e executar a query de forma segura
    $stmt = $conexao->prepare($insert_script);
    $stmt->bind_param("sssi", $nome, $email, $senha_cripto, $curso);
    
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

    // Criptografia da senha
    $senha_cripto = password_hash($senha, PASSWORD_DEFAULT);

    // Query para inserir os valores na tabela de discentes
    $insert_script = "INSERT INTO TB_DOCENTE (NOME, EMAIL, SENHA) VALUES (?, ?, ?)";

    // Preparar e executar a query de forma segura
    $stmt = $conexao->prepare($insert_script);
    $stmt->bind_param("sss", $nome, $email, $senha_cripto);
    
    if ($stmt->execute()) {
        return ['status' => true, 'message' => 'Cadastro realizado com sucesso'];
    } else {
        return ['status' => false, 'message' => 'Falha ao registrar docente: ' . $stmt->error];
    }
}

function enviarEmail($email, $assunto) {
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
        $mail->addAddress('nicolasczaikowski@gmail.com');
        
        // Links de confirmação
        $link_rejeitar = 'https://seusite.com/rejeitar?email=' . urlencode($email); // Defina o link correto
        $link_confirmar = 'https://seusite.com/confirmar?email=' . urlencode($email); // Defina o link correto
        
        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = $assunto;
        $mail->Body = '
        Olá, Usuário!<br><br>
        Seja bem-vindo ao OportunIF! Recebemos uma tentativa de criação de conta com o e-mail ' . htmlspecialchars($email) . '. Por favor, confirme se foi você quem fez essa solicitação.<br><br>
        <a href="' . htmlspecialchars($link_rejeitar) . '">Rejeitar</a><br>
        <a href="' . htmlspecialchars($link_confirmar) . '">Confirmar</a>
        ';

        $mail->AltBody = 'Olá, Usuário!\n\n' .
        'Seja bem-vindo ao OportunIF! Recebemos uma tentativa de criação de conta com o e-mail ' . htmlspecialchars($email) . '. Por favor, confirme se foi você quem fez essa solicitação.\n\n' .
        'Rejeitar: ' . htmlspecialchars($link_rejeitar) . '\n' .
        'Confirmar: ' . htmlspecialchars($link_confirmar);

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
    $query = "SELECT senha, situacao FROM TB_DISCENTE WHERE EMAIL = ?";
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
    if ($row['situacao'] === 'Pendente') {
        return ['status' => false, 'message' => 'Seu cadastro está pendente.'];
    }

    // Verifica se a senha está correta
    if (password_verify($senha, $row['senha'])) {
        return ['status' => true];
    } else {
        return ['status' => false, 'message' => 'Senha incorreta'];
    }
}

function verificarCredenciaisDocente($email, $senha, $conexao) {
    // Prepara a consulta SQL para buscar a senha e a situação
    $query = "SELECT senha, situacao FROM TB_DOCENTE WHERE EMAIL = ?";
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
    if ($row['situacao'] === 'Pendente') {
        return ['status' => false, 'message' => 'Seu cadastro está pendente.'];
    }

    // Verifica se a senha está correta
    if (password_verify($senha, $row['senha'])) {
        return ['status' => true];
    } else {
        return ['status' => false, 'message' => 'Senha incorreta'];
    }
}

?>
