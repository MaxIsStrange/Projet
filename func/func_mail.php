<?php

use PHPMailer\PHPMailer\PHPMailer;

require '../vendor/autoload.php';
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Host = 'smtp.hostinger.fr';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = 'stagetracker@hsbay.space';
$mail->Password = 'TheEvaMax3@';
$mail->setFrom('stagetracker@hsbay.space', 'StageTracker');
$mail->addReplyTo('stagetracker@hsbay.space', 'StageTracker');
$mail->addAddress('evan.pasquon@gmail.com', 'Test');
$mail->Subject = 'Essai de PHPMailer';
$mail->msgHTML(file_get_contents('message.html'), __DIR__);
$mail->Body = 'Ceci est le contenu du message en texte clair';
//$mail->addAttachment('test.txt');
// if (!$mail->send()) {
//     echo 'Erreur de Mailer : ' . $mail->ErrorInfo;
// } else {
//     echo 'Le message a été envoyé.';
// }
