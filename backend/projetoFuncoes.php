<?php

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function cadastrarProjeto($id_docente, $titulo, $id_tipo_projeto, $criterios_selecao, $resumo, $conexao, $bolsa_disponivel, $descricao_bolsa = null, $requisito_bolsa = null) {
    
    // Verificação de registros vazios com id 
    $check_docente_query = "SELECT * FROM TB_DOCENTE WHERE ID_DOCENTE = ?";
    $stmt = $conexao->prepare($check_docente_query);
    $stmt->bind_param("i", $id_docente);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows < 1) {
        return ['status' => false, 'message' => 'Este docente não está cadastrado.'];
    }
    
    // Prepare a query de inserção
    $insert_script = "INSERT INTO TB_PROJETO (ID_DOCENTE, TITULO, ID_TIPO_PROJETO, CRITERIOS_SELECAO, RESUMO, POSSUI_BOLSA, BOLSA_DESCRICAO, BOLSA_REQUISITOS) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Prepare o statement
    $stmt = $conexao->prepare($insert_script);

    // Se a bolsa estiver disponível
    if ($bolsa_disponivel == '1') {
        $stmt->bind_param("isssssss", $id_docente, $titulo, $id_tipo_projeto, $criterios_selecao, $resumo, $bolsa_disponivel, $descricao_bolsa, $requisito_bolsa);
    } else {
        // Se não há bolsa, os campos de descrição e requisitos ficam nulos
        $descricao_bolsa = null;
        $requisito_bolsa = null;
        $stmt->bind_param("isssssss", $id_docente, $titulo, $id_tipo_projeto, $criterios_selecao, $resumo, $bolsa_disponivel, $descricao_bolsa, $requisito_bolsa);
    }

    if ($stmt->execute()) {
        // Captura o ID do projeto inserido
        $id_projeto = $stmt->insert_id;
        $stmt->close(); // Fechar o stmt
        
        // Inicia a sessão, se não estiver iniciada
        $_SESSION['id_projeto'] = $id_projeto;

        return ['status' => true, 'message' => 'Projeto cadastrado com sucesso', 'id_projeto' => $id_projeto];
    } else {
        return ['status' => false, 'message' => 'Falha ao registrar projeto: ' . $stmt->error];
    } 
}
function notificarAlunos($conexao, $tituloProjeto, $cursoSelecionado) {
    // Monta a consulta para obter os alunos do curso
    if ($cursoSelecionado === 'todos') {
        $alunosQuery = "SELECT NOME, EMAIL FROM TB_DISCENTE";
        $stmt = $conexao->prepare($alunosQuery);
    } else {
        $alunosQuery = "SELECT NOME, EMAIL FROM TB_DISCENTE WHERE ID_CURSO = ?";
        $stmt = $conexao->prepare($alunosQuery);
        $stmt->bind_param("i", $cursoSelecionado);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $enviados = [];

    // Envia o e-mail para cada aluno
    while ($aluno = $result->fetch_assoc()) {
        if (enviarEmailNotificacao($aluno['NOME'], $aluno['EMAIL'], $tituloProjeto)) {
            $enviados[] = $aluno['EMAIL'];
        }
    }

    // Verifica se algum e-mail foi enviado
    if (count($enviados) > 0) {
        return ['success' => true, 'message' => 'E-mails enviados para: ' . implode(', ', $enviados)];
    } else {
        return ['success' => false, 'message' => 'Nenhum e-mail enviado.'];
    }
}

function enviarEmailNotificacao($nome, $email, $tituloProjeto) {
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

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Notificação de Projeto: ' . htmlspecialchars($tituloProjeto);
        $mail->Body = '
            Olá, ' . htmlspecialchars($nome) . '<br><br>
            Você está sendo notificado sobre o projeto: <strong>' . htmlspecialchars($tituloProjeto) . '</strong>.<br>
            Para mais informações, acesse nossa plataforma.<br><br>
            Atenciosamente,<br>
            Equipe OportunIF
        ';

        $mail->AltBody = 'Olá, ' . htmlspecialchars($nome) . '\n\n' .
                         'Você está sendo notificado sobre o projeto: ' . htmlspecialchars($tituloProjeto) . '.\n' .
                         'Para mais informações, acesse nossa plataforma.\n\n' .
                         'Atenciosamente,\n' .
                         'Equipe OportunIF';

        // Envio do e-mail
        $mail->send();
        return true; // Retorna true se o e-mail foi enviado
    } catch (Exception $e) {
        return false; // Retorna false se houve erro
    }
}

?>
