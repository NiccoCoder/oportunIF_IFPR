<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

function enviarEmailReport($data, $titulo, $descricao) {
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';

    try {
        // Configurações do servidor
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Host do Gmail
        $mail->SMTPAuth = true;
        $mail->Username = getenv('REPORT_USERNAME'); // Usuário do e-mail que envia
        $mail->Password = getenv('REPORT_PASSWORD'); // Senha do e-mail que envia
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Remetente e destinatário
        $mail->setFrom(getenv('REPORT_SEND_FROM'), getenv('REPORT_SEND_FROM_NAME'));
        $mail->addAddress('oportunif@gmail.com'); // Email que receberá o report

        // Assunto do e-mail
        $assunto = 'Novo Report: ' . $titulo;
        
        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = $assunto;
        $mail->Body = '
            <h3>Detalhes do Report</h3>
            <strong>Data:</strong> ' . htmlspecialchars($data) . '<br>
            <strong>Título:</strong> ' . htmlspecialchars($titulo) . '<br>
            <strong>Descrição:</strong><br>' . nl2br(htmlspecialchars($descricao)) . '<br>
        ';

        $mail->AltBody = 'Detalhes do Report\n' .
                         'Data: ' . htmlspecialchars($data) . '\n' .
                         'Título: ' . htmlspecialchars($titulo) . '\n' .
                         'Descrição: ' . htmlspecialchars($descricao) . '\n';

        // Envio do e-mail
        $mail->send();
        return ['status' => true, 'message' => 'E-mail de report enviado com sucesso!'];
    } catch (Exception $e) {
        return ['status' => false, 'message' => 'Erro ao enviar o e-mail: ' . $mail->ErrorInfo];
    }
}
