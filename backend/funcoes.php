<?php

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function validarEmail($email) {

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
        
        $assunto = 'Código de verificação';
        $codigoSeguranca = '123456'; 
        $mensagem = '
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Confirmação de E-mail</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap.min.css" 
            integrity="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" 
            integrity="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <div class="container p-3">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 mt-5">
                    <div class="bg-white p-5 rounded-3 shadow-sm border">
                        <div class="text-center">
                            <p class="text-success" style="font-size: 5.5rem;"><i class="fa-solid fa-envelope-circle-check"></i></p>
                            <p class="h5">Olá, Usuário!</p>
                            <p class="text-muted">Seja bem-vindo ao Oportunif! Recebemos uma tentativa de criação de conta com o e-mail ' . htmlspecialchars($email) . '. Por favor, confirme se foi você quem fez essa solicitação.</p>
                            <div class="row pt-5">
                                <div class="col-6">
                                    <a href="' . $link_rejeitar . '" class="btn btn-outline-danger w-100">Rejeitar</a>
                                </div>
                                <div class="col-6">
                                    <a href="' . $link_confirmar . '" class="btn btn-success w-100">Confirmar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>';

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = $assunto;
        $mail->Body = $mensagem; 
        $mail->AltBody = strip_tags($mensagem);

        // Envia o e-mail
        $mail->send();
        return "E-mail enviado com sucesso!";
    } catch (Exception $e) {
        return "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }
}
?>
