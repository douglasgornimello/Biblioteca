<?php
require 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

$redirect = $_POST['redirect'];
$subject = $_POST['subject'];
$recipient = $_POST['recipient'];
$emailCliente = $_POST['email'];
foreach ($_POST as $key => $entry)
{
     if ($key == "redirect") continue;
     if ($key == "subject") continue;
     if ($key == "recipient") continue;
     if (is_array($entry))
     {
        foreach($entry as $value)
        {
           $content .= htmlspecialchars($key)." : ".htmlspecialchars($value)."<br>";
        }
     }
    else 
     {
        $content .= htmlspecialchars($key)." : ".htmlspecialchars($entry)."<br>";
     }
} 
//$mail->SMTPDebug = 3;                               // Enable verbose debug output
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = '';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = '';                 // SMTP username
$mail->Password = '';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to
$mail->setFrom('', '');

$emailList = explode(',', $recipient); //Separa a lista de email separando por virgula.
foreach ($emailList as &$value) {
	//Atribui a lista de emails.
	$mailer->AddAddress( $value );
}
unset($value);

if($emailCliente) 
$mail->addReplyTo($emailCliente);
}
// $mail->addCC('cc@example.com');
// $mail->addBCC('bcc@example.com');

$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = utf8_decode($subject);
$mail->Body = utf8_decode($content);
// $mail->Subject = 'Here is the subject';
// $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    header ("Location: $redirect");
   exit;
}