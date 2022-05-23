<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use Dotenv\Dotenv as Dotenv;

$dotenv = Dotenv::createImmutable('../includes/.env');
$dotenv->safeLoad();

class Email
{
    public $name;
    public $email;
    public $token;

    public function __construct($name, $email, $token)
    {
        $this->name = $name;
        $this->email = $email;
        $this->token = $token;
    }

    public function sendConfirmation()
    {
        // Create email object (info from Mailtrap)
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USER'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = $_ENV['MAIL_PORT'];

        $mail->setFrom('info@appsalon.com');
        $mail->addAddress('info@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Confirm your Account';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $content = "<html>";
        $content .= "<p><strong>Hello " . $this->name . "</strong>we need you to confirm your account before creating it:</p>";
        $content .=
            "<p>Click here: <a href='" . $_ENV['SERVER_HOST'] . "confirm-account?token=" . $this->token . "'>Confirm Account </a> </p>";
        $content .= "<p>If you didn't register at AppSalon, you may ignore this message</p>";
        $content .= "</html>";

        $mail->Body = $content;

        // Send email
        $mail->send();
    }

    public function sendInstructions()
    {
        // Create email object (info from Mailtrap)
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USER'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = $_ENV['MAIL_PORT'];

        $mail->setFrom('info@appsalon.com');
        $mail->addAddress('info@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Reset your Password';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $content = "<html>";
        $content .= "<p><strong>Hello " . $this->name . "</strong> You've requested to reset your password, click on the following link to proceed.</p>";
        $content .=
            "<p><a href='" . $_ENV['SERVER_HOST'] . "reset?token=" . $this->token . "'>Reset Password</a> </p>";
        $content .= "<p>If you didn't register at AppSalon, you may ignore this message</p>";
        $content .= "</html>";

        $mail->Body = $content;

        // Send email
        $mail->send();
    }
}
