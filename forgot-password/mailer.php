<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php'; // Make sure this path is correct

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com";
$mail->Port = 587;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Username = "nelchrimson@gmail.com";           // Replace this with your Gmail address
$mail->Password = "divc ntot qbkm fqmm";              // Replace this with your Gmail App Password

$mail->isHTML(true);

return $mail;
