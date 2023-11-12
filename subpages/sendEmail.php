<?php

use PHPMailer\PHPMailer\PHPMailer;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

session_start();

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';

try {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $pagePath = $_SESSION['pagePath'];
    $pageName = $_SESSION['pageName'];

    $mail->isSMTP();
    $mail->Host = 'smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Username = 'f7eea727a3a686';
    $mail->Password = 'ac22d3263df18a'; // dane do konta na mailtrap.io, email: zborowskapati@gmail.com, hasło: Holika_123
    $mail->SMTPSecure = 'tls';
    $mail->Port = 2525;
    $mail->setFrom($email, $name);
    $mail->addAddress('holikaholikaproject@gmail.com', 'Holika Holika');
    $mail->Subject = "Nowa wiadomość - $pageName";
    $mail->isHTML(true);
    $bodyParagraphs = ["Imię: {$name}", "Email: {$email}", "Wiadomość:", nl2br($message)];
    $body = join('<br />', $bodyParagraphs);
    $mail->Body = $body;
    $mail->send();
    $_SESSION['thankYou'] = true;
    header("Location: $pagePath");
    exit();
} catch (Exception $e) {
    $error = $mail->ErrorInfo;
    $_SESSION['errorMessage'] = "Ups, coś poszło nie tak, błąd: $error";
    header("Location: $pagePath");
    exit();
}
