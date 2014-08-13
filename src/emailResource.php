<?php

if(!defined("MAIL_MAILER")) define ("MAIL_MAILER", 'phpmailer');
//if(!defined("MAIL_MAILER")) define ("MAIL_MAILER", 'sendgrid');
class emailResource extends \classes\Interfaces\resource{

    private $mailer = NULL;
    public $dir = "";
    public function __contruct() {
        $this->dir = dirname(__FILE__);
        parent::__contruct();
    }
    
    public function load(){
        $this->dir = dirname(__FILE__);
        $this->LoadResourceFile("/classes/mailer.php");
        $class = MAIL_MAILER . "Mailer";
        //$this->LoadResourceFile("/lib/mailer/phpmailer/phpmailerMailer.php");
        //$this->mailer = phpmailerMailer::getInstanceOf();
        $this->LoadResourceFile("/lib/mailer/".MAIL_MAILER."/$class.php");
        $this->mailer = $class::getInstanceOf();
    }
    
    private static $instance = NULL;
    public static function getInstanceOf(){
        $class_name = __CLASS__;
        if (!isset(self::$instance)){
            $obj = new $class_name();
            $obj->load();
            self::$instance = $obj;
        }
        return self::$instance;
    } 
    
    private $configs;
    public function configure($assunto, $corpo, $email_remetente, $nomeRemetente){
        $this->configs = array('assunto' => $assunto, 'conteudo' => $corpo, 'email' => $email_remetente, 'remetente' => $nomeRemetente);
        $this->mailer->configure($assunto, $corpo, $email_remetente, $nomeRemetente);
    }

    private $destinatario = array();
    public function AddAddress($destinatario){
        $this->destinatario = $destinatario;
        if(!is_array($this->destinatario)){$this->destinatario = array($this->destinatario);}
        $this->mailer->AddAddress($destinatario);
    }

    public function send(){
        if(false === $this->mailer->send()){
            $this->setErrorMessage($this->mailer->getErrorMessage());
            $conteudo = "DE: {$this->configs['remetente']}-{$this->configs['email']}" . "<br/>".$this->configs['conteudo'];
            $assunto  = $this->configs['assunto'];
            foreach($this->destinatario as $dest){
                \classes\Utils\Log::save("error_mail/$dest/$assunto", $conteudo);
            }
            return false;
        }
        return true;
    }
    
    public function AddAtachment($anexo){
        if(!empty ($anexo)){return;}
        foreach($anexo as $an){
            $this->mailer->AddAttachment($an['tmp_name'], $an['name']);
        }
    }
    
    public function privacidade(){
        $this->mailer->privacidade();
    }

    public function sendMail($assunto, $corpo, $destinatarios, 
            $email_remetente = "", $nomeRemetente="", $anexo = array()
    ){
        if(trim($email_remetente) == ""){$email_remetente = (MAIL_RESPONDER != '')?MAIL_RESPONDER :'no-reply@'.$_SERVER['HTTP_HOST'];}
        if(trim($nomeRemetente)   == ""){$nomeRemetente   = (MAIL_REMETENTE != '')?MAIL_REMETENTE :SITE_NOME;}
        $this->configure($assunto, $corpo, $email_remetente, $nomeRemetente);
        $this->AddAtachment($anexo);
        $this->AddAddress($destinatarios);
        return $this->send();
    }
	
}