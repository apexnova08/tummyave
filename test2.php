<?php

$name = $_POST["name"];
$email = $_POST["email"];
$subject = $_POST["subject"];
$message = $_POST["message"];

require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true);

// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

$mail->Username = "Tummyavenue02@gmail.com";
$mail->Password = "lgyu ylwv duvb qwnb";

$mail->setFrom($email, $name);
$mail->addAddress("tonydiesta08@gmail.com", "Dave");

$mail->Subject = $subject;
$mail->Body = $message;

$mail->send();

exit ("sex");