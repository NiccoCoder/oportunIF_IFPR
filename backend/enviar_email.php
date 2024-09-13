<?php

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if(isset($_POST['submit'])){
    
    function sendEmail($email) {
        $mail = new PHPMailer(true);

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
            
            $subject = 'Código de verficação';
            $codigoSeguranca = '123456'; 
            $message = '<h1>Olá!</h1><p>Você solicitou um código de verificação para seu cadastro no OportunIF.</p><p style="text-align: center; font-size: 24px; font-weight: bold;">' . $codigoSeguranca . '</p><p>Se você não solicitou este código, por favor ignore este email. Não responda a este email, ele é gerado automaticamente.</p><p>Atenciosamente,</p><p>Equipe OportunIF</p>';

            // Conteúdo do email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->AltBody = strip_tags($message);

            // Envia o e-mail
            $mail->send();
            return "Email enviado com sucesso!";
        } catch (Exception $e) {
            return "Erro ao enviar email: {$mail->ErrorInfo}";
        }
    }
    // Exemplo de chamada da função
    // $email = 'nicolasczaikowski@gmail.com';
    // echo sendEmail($email);
} else {
    header("Location: ../frontend/pages/cadastroAluno.html");
    exit();
}
?>
