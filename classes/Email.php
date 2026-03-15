<?php


namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    public $email;
    public $token;
    public $nombre;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        // crear el objeto de email
        $mail = new PHPMailer();

        // configurar el protocolo de envio de email SMTP
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = "TRUE";
        $mail->Username = $_ENV['USER'];
        $mail->Password = $_ENV['PASS'];
        $mail->SMTPSecure = "tls";
        $mail->Port = $_ENV['PORT'];

        // configurar el contenido del mail
        $mail->setFrom("cuentas@appsalon.com"); // el que envia el mensaje
        $mail->addAddress("cuentas@appsalon.com", "AppSalon.com"); // el que recibe lo recive
        $mail->Subject = "Confirma tu cuenta de AppSalon";

        // Habilitar el HTML
        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";


        // definir contenido
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola $this->nombre</strong>, has creado tu cuenta en AppSalon, solo debes confirmala presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aqui: <a href='" . $_ENV['PROJECT_URL'] . "/confirmar-cuenta?token=$this->token'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        // enviar el email
        $mail->send();
    }

    public function enviarIntricciones()
    {
        // crear el objeto de email
        $mail = new PHPMailer();

        // configurar el protocolo de envio de email SMTP
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = "TRUE";
        $mail->Username = $_ENV['USER'];
        $mail->Password = $_ENV['PASS'];
        $mail->SMTPSecure = "tls";
        $mail->Port = $_ENV['PORT'];

        // configurar el contenido del mail
        $mail->setFrom("cuentas@appsalon.com"); // el que envia el mensaje
        $mail->addAddress("cuentas@appsalon.com", "AppSalon.com"); // el que recibe lo recive
        $mail->Subject = "Recupera tu cuenta de AppSalon";

        // Habilitar el HTML
        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";


        // definir contenido
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola $this->nombre</strong>, has solicitado restablecer tu contraseña de tu cuenta</p>";
        $contenido .= "<p>Presiona aqui: <a href='" . $_ENV['PROJECT_URL'] . "/recuperar?token=$this->token'>Restablecer contraseña</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta recuperacion, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        // enviar el email
        $mail->send();
    }
}
