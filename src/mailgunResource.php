<?php
/**
 * Created by PhpStorm.
 * User: davidson
 * Date: 04/03/16
 * Time: 16:18
 * @see https://github.com/mailgun/mailgun-php
 */

if (!defined("MAILGUN")) define("MAILGUN", 'mailgun');

class mailgunResource extends \classes\Interfaces\resource {
    private $mailgun = null;
    public $dir = "";

    public function __contruct() {
        $this->dir = dirname(__FILE__);
        parent::__contruct();
    }

    public function load() {

        $class = "phpMailgun";
        $this->dir = dirname(__FILE__);
        $this->LoadResourceFile("/classes/mailer.php");
        $this->LoadResourceFile("/lib/mailer/mailgun/$class.php");
        $this->mailgun = $class::getInstanceOf();
    }

    private static $instance = null;

    public static function getInstanceOf() {
        $class_name = __CLASS__;
        if (!isset(self::$instance)) {
            $obj = new $class_name();
            $obj->load();
            self::$instance = $obj;
        }

        return self::$instance;
    }

    private $configs;

    public function configure($assunto, $corpo, $email_remetente, $nomeRemetente) {
        $this->configs = array( 'assunto' => $assunto, 'conteudo' => $corpo, 'email' => $email_remetente, 'remetente' => $nomeRemetente );
        $this->mailgun->configure($assunto, $corpo, $email_remetente, $nomeRemetente);
    }

    private $destinatario = array();

    public function AddAddress($destinatario) {
        $this->destinatario = $destinatario;
        if (!is_array($this->destinatario)) {
            $this->destinatario = array( $this->destinatario );
        }
        $this->mailgun->AddAddress($destinatario);
    }

    public function send() {
        if (false === $this->mailgun->send()) {
            $this->setErrorMessage($this->mailgun->getErrorMessage());
            $conteudo =
                "<hr/>"
                . "<b>De:</b> {$this->configs['remetente']}<br>"
                . "<b>Assunto:</b> {$this->configs['assunto']}<br>"
                . "<a href='mailto:{$this->configs['email']}'>Responder</a><br/><br/><br/>" . $this->configs['conteudo'] . "<hr/>";
            $assunto = $this->configs['assunto'];
            foreach ($this->destinatario as $dest) {
                \classes\Utils\Log::save("error_mail/$dest/{$this->configs['email']}/$assunto", $conteudo);
            }

            return false;
        }

        return true;
    }

    public function AddAtachment($anexo) {
        if (!empty ($anexo)) {
            return;
        }
        foreach ($anexo as $an) {
            $this->mailgun->AddAttachment($an['tmp_name'], $an['name']);
        }
    }

    public function privacidade() {
        $this->mailgun->privacidade();
    }

    public function sendMail($assunto, $corpo, $destinatarios,
                             $email_remetente = "", $nomeRemetente = "", $anexo = array()
    ) {
        if (trim($email_remetente) == "") {
            $email_remetente = (MAIL_RESPONDER != '') ? MAIL_RESPONDER : 'no-reply@' . $_SERVER['HTTP_HOST'];
        }
        if (trim($nomeRemetente) == "") {
            $nomeRemetente = (MAIL_REMETENTE != '') ? MAIL_REMETENTE : SITE_NOME;
        }
        $this->configure($assunto, $corpo, $email_remetente, $nomeRemetente);
        $this->AddAtachment($anexo);
        $this->AddAddress($destinatarios);

        return @$this->send();
    }
}