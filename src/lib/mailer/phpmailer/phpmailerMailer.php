<?php

require_once  dirname(__FILE__) . "/PhpMailer/class.phpmailer.php";
require_once  dirname(__FILE__) . "/PhpMailer/class.smtp.php";

use classes\Classes\Object;
class phpmailerMailer extends classes\Classes\Object implements mailer
{
    //classe php mailer
    private $mail;

    private function __construct(){
        $this->mail = new PHPMailer($thows = true);
        //$this->teste();
    }

    static private $instance;
    public static function getInstanceOf(){
        $class_name = __CLASS__;
        if (!isset(self::$instance))
            self::$instance = new $class_name;
        return self::$instance;
    }

    public function configure($assunto, $corpo, $email_remetente, $nome_remetente){

          //$mail = new PHPMailer();//instancia a classe
        try{
          $this->mail->IsSMTP();//defini que será enviado via SMTP
          $this->mail->SMTPDebug = 0;
          if(defined('DEBUG') && DEBUG === true)$this->mail->SMTPDebug  = (MAIL_DEBUG)?2:0; //ativa o debug
          $this->mail->SMTPAuth = MAIL_SMTPAUTH; //define que será autenticado
          $this->mail->Username = MAIL_USER; //Define o nome do usuário
          $this->mail->Password = MAIL_SENHA; //define a senha o usuário
          if(MAIL_SECURE != "") $this->mail->SMTPSecure = MAIL_SECURE;
          if(MAIL_PORT   != "") $this->mail->Port       = MAIL_PORT; //altera a porta de envio
          if(MAIL_HOST   != "") $this->mail->Host       = MAIL_HOST; //define o endereço SMTP
          if(CHARSET     != "") $this->mail->CharSet    = CHARSET;
          
          //Informa o email e nome de quem está enviado
          $this->mail->AddReplyTo($email_remetente);
          $this->mail->SetFrom(MAIL_EMAIL, MAIL_REMETENTE);
          $this->mail->Subject = $assunto;//titulo da mensagem que será enviada
          $this->mail->MsgHTML($corpo);//a mensagem que está sendo enviada
        }catch(Exception $e){
            $this->setErrorMessage($e->getMessage());
            return false;
        }
    }

    private $is_private = true;
    public function privacidade(){
        $this->is_private = false;
    }
    
    //adiciona um novo endereço, pode receber um array de enderecos ou somente 1 destinatario
    public function AddAddress($destinatario){
        if(is_array($destinatario)){
            foreach($destinatario as $dest){
                if(!$this->is_private) $this->mail->AddBCC(utf8_decode($dest));
                else $this->mail->AddAddress(utf8_decode($dest));
            }
        }
        else{
            if($destinatario == "") $destinatario = MAIL_EMAIL;
            $this->mail->AddAddress(utf8_decode($destinatario));
        }
    }
    
    public function AddAttachment($file_name, $newname){
        if(file_exists($file_name))
             $this->mail->AddAttachment($file_name, $newname);
    }
    
    public function send(){
        //Checamos se a mensagem foi enviada ou se teve algum erro...
        try{
            $enviado = $this->mail->Send();
            $this->mail->ClearAllRecipients();
            $this->mail->ClearAttachments();
            if(!$enviado){
                $this->setErrorMessage($this->mail->ErrorInfo);
                return false;
            }
            return true;
        }catch (Exception $e){
            $msg = ($this->mail->ErrorInfo != "")? $this->mail->ErrorInfo: "Não possível enviar o email, erro no servidor!";
            $this->setErrorMessage($msg);
            $this->mail->ClearAllRecipients();
            $this->mail->ClearAttachments();
            return false;
        }
    }    
}

?>