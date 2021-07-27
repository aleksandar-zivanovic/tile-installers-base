<?php
require_once 'config.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

//$user = new User();

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = SMTP_HOST;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = SMTP_USER;                       //SMTP username
    $mail->Password   = SMTP_PASSWORD;                       //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = SMTP_PORT;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom(FROM_EMAIL, FROM_NAME);
    $mail->addAddress($this->email, 'Resetovanje sifre');     //Add a recipient
//    $mail->addAddress('ellen@example.com');               //Name is optional
//    $mail->addReplyTo('info@example.com', 'Information');
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');

    //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Promena šifre';
    $mail->Body    = 'Zdravo '.$this->username.' !<br> Da bi završio proces promene šifre, klikni na ovaj link:  <a href="http://localhost/majstori/new_password.php?email='.$this->email.'&resetcd=' .$this->rst_code. '">http://localhost/majstori/new_password.php?email='.$this->email.'&resetcd='.$this->rst_code.'</a></b>';
    $mail->AltBody = 'Zdravo, da bi završio proces promene šifre, kopiraj link ispod: <br> http://localhost/majstori/new_password.php?email='.$this->email.'&resetcd='.$this->rst_code.' <br> u svoj internet pretraživac.';

    $mail->send();
    echo 'Message has been sent';
    $_SESSION['rst_pwd_msg'] = '<div class="h-auto alert alert-primary" role="alert">Link za promenu šifre je poslatu na email adresu koju ste uneli. Kliknite na link koji ste dobili u email-u, da biste završili proces promene šifre!</div>';
    die(header("location:../login.php"));
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}