<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php'; // Certifique-se de que está usando Composer para carregar as dependências

$mail = new PHPMailer(true);

try {
    // Configurações do servidor
    $mail->isSMTP();
    $mail->SMTPAuth   = true;
    $mail->Username   = 'oportunifreport@gmail.com'; // Seu e-mail
    $mail->Password   = 'Oportunif2500';           // Sua senha de e-mail ou senha de aplicativo
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Criptografia TLS
    $mail->Port       = 587; // Porta para TLS

    // Defina o remetente
    $mail->setFrom('oportunifreport@gmail.com', 'baaa');
    // Defina o destinatário
    $mail->addAddress('nicolasczaikowski@gmail.com', 'Nicolas');

    // Conteúdo da mensagem
    $mail->isHTML(true);
    $mail->Subject = 'Teste Envio de Email';
    $mail->Body    = 'Este é o corpo da mensagem <b>Olá!</b>';
    $mail->AltBody = 'Este é o corpo da mensagem para clientes de e-mail que não reconhecem HTML';

    // Enviar
    $mail->send();
    echo 'A mensagem foi enviada!';
} catch (Exception $e) {
    echo "Mensagem não pode ser enviada. Erro do Mailer: {$mail->ErrorInfo}";
}
?>
