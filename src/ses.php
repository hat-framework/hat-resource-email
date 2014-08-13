<?php

error_reporting(-1);
require_once  dirname(__FILE__) . "/lib/mailer/phpmailer/PhpMailer/class.phpmailer.php";
require_once  dirname(__FILE__) . "/lib/mailer/phpmailer/PhpMailer/class.smtp.php";

//SMTP Settings

$mail = new PHPMailer();

$mail->IsSMTP();
$mail->SMTPAuth   = true; 
$mail->SMTPSecure = "tls"; 
$mail->Host       = "email-smtp.us-east-1.amazonaws.com";
$mail->Username   = "AKIAI53H6V27X2IBNUYQ";
$mail->Password   = "An1U2OVoL5ofG/DZLMSLlTWv7kgBWdFT+d2fPuhPe3uW";
//
$mail->SetFrom('contato@finance-e.com', 'DataFinancee'); //from (verified email address)
$mail->Subject = "Teste de email"; //subject

//message
$mail->MsgHTML("This is a test message.");

//recipient
$mail->AddAddress("tigredonorte3@gmail.com", "Thom"); 

//Success
if ($mail->Send()) { 
    echo "Message sent!"; die; 
}else {
    echo "Mailer Error: " . $mail->ErrorInfo; 
}