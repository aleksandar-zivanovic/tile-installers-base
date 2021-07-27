<?php
require_once 'config.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

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
    $mail->addAddress($this->email, 'Aca test');     //Add a recipient
//    $mail->addAddress('ellen@example.com');               //Name is optional
//    $mail->addReplyTo('info@example.com', 'Information');
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');

    //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Registracija: potvrdite registraciju na sajtu majstori';
    $mail->Body    = 'Zdravo '.$this->username.' !<br> Da bi završio proces registracije na sajtu, klikni na ovaj link:  <a href="http://localhost/majstori/user_email_verification.php?email='.$this->email.'&actcd=' .$this->act_code. '">http://localhost/majstori/user_email_verification.php?email='.$this->email.'&actcd='.$this->act_code.'</a></b>';
    $mail->AltBody = 'Zdravo, da bi završio proces registracije na sajtu majstori, kopiraj link ispod: <br> http://localhost/majstori/user_email_verification.php?email='.$this->email.'&actcd='.$this->act_code.' <br> u svoj internet pretraživac.';

    $mail->send();
    echo 'Message has been sent';
    die(header("location:../register.php"));
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}