<?php

require_once '../../init.php';
$obj   = new \classes\Classes\Object();
$users = $obj->LoadModel('usuario/login', 'ulog')->getWebmastersMail();
$display         = $obj->ulog->UserIsWebmaster();
if($display){define('MAIL_DEBUG', true);}

$mail            = $obj->LoadResource('email', 'mail');
$assunto         = "Send Mail Test";
$corpo           = "This is an sendmail test";
$email_remetente = (MAIL_RESPONDER != '')?MAIL_RESPONDER     :'no-reply@'.$_SERVER['HTTP_HOST'];
$nomeRemetente   = (MAIL_REMETENTE != '')?MAIL_REMETENTE:"HatFramework";

$mail->configure($assunto, $corpo, $email_remetente, $nomeRemetente);
$mail->AddAddress($users);
if(!$mail->send()){
    if($display){print_r($mail->getMessages());}
}elseif($display){echo "email send succesfuly!";}

function getSenha($senha){
    $out  = substr($senha, 0, 3);
    $len  = strlen($senha);
    while($len > 4){
        $len--;
        $out .= "*";
    }
    return $out . substr($senha, $len-2, 1);
}
$senha = getSenha(MAIL_SENHA);

$arr = array(
    'MAIL_REMETENTE'=> MAIL_REMETENTE . " (Nome que aparecerá para o usuário ao receber o email)",
    'MAIL_EMAIL'    => MAIL_EMAIL     . " (Email de onde será disparado o envio para o usuário)",
    'MAIL_RESPONDER'=> MAIL_RESPONDER . " (Email para onde os usuários enviarão a resposta)",
    
    'MAIL_DEBUG'    => MAIL_DEBUG     . " (Debugar email - nesta tela será sempre sim!)",
    'MAIL_SMTPAUTH' => MAIL_SMTPAUTH  . " (Autenticação)",
    'MAIL_USER'     => MAIL_USER      . " (Usuário de envio autenticado)",
    'MAIL_SENHA'    => $senha         . " (Senha de envio autenticado - Ocultado por motivos de segurança",
    'MAIL_SECURE'   => MAIL_SECURE    . " (Tipo de segurança)",
    
    'MAIL_PORT'     => MAIL_PORT      . " (Porta de envio de emails)",
    'MAIL_HOST'     => MAIL_HOST      . " (Host de envio de emails)",
    'CHARSET'       => CHARSET        . " (Codificação de envio de emails)",
    'DESTINATARIOS' => implode(", ", $users) 
);

if($display){
    echo "<hr/> Configurações: <br/>";
    debugarray($arr);
}