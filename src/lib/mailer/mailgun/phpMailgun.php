<?php
/**
 * Created by PhpStorm.
 * User: davidson
 * Date: 08/03/16
 * Time: 09:24
 */

require_once $_SERVER['DOCUMENT_ROOT'] . "/init.php";

use Mailgun\Mailgun;

use classes\Classes\Object;

class phpMailgun extends classes\Classes\Object implements mailer {
    //classe mailgun
    private $mailgun;
    protected $assunto;
    protected $corpo;
    protected $email_remetente;
    protected $nome_remetente;
    protected $destinatario = array();
    protected $destinatarioRecipient = array();

    private function __construct() {
        $this->mailgun = new Mailgun(MAILGUN_KEY);
    }

    static private $instance;

    public static function getInstanceOf() {
        $class_name = __CLASS__;
        if (!isset(self::$instance))
            self::$instance = new $class_name;

        return self::$instance;
    }

    public function configure($assunto, $corpo, $email_remetente, $nome_remetente) {
        $this->assunto = $assunto;
        $this->corpo = $corpo;
        $this->email_remetente = $email_remetente;
        $this->nome_remetente = $nome_remetente;
    }

    private $is_private = true;

    public function privacidade() {
        $this->is_private = false;
    }

    /**
     * adiciona um novo endereço, pode receber um array de enderecos ou somente 1 destinatario
     *
     * caso seja enviado array, deverá possuir a seguinte estrutura todos valores:
     * array("email" => "name")
     *
     * @param $destinatario
     */
    public function AddAddress($destinatario) {

        if (is_array($destinatario)) {

            // ajusta as informaçoes do contato(email e nome) para se poder utilizar ambas informaçoes
            foreach ($destinatario as $email => $nome) {

                $email = utf8_decode($email);

                $this->destinatario[] = $email;
                $this->destinatarioRecipient[$email] = array( 'first' => $nome, 'id' => $email );
            }
        } else {
            if ($destinatario == "")
                $destinatario = MAIL_EMAIL;

            // atribui apenas o email enviado
            $this->destinatario[] = utf8_decode($destinatario);
        }
    }

    public function AddAttachment($file_name, $newname) {
    }

    public function send() {
        //Checamos se a mensagem foi enviada ou se teve algum erro...
        try {

            $domain = MAILGUN_DOMINIO;

            $enviado = $this->mailgun->sendMessage("$domain",
                array(
                    'from'                => $this->nome_remetente . ' <' . $this->email_remetente . '>',
                    'to'                  => implode(",", $this->destinatario),
                    'subject'             => $this->assunto,// 'Hey %recipient.first%'
                    'html'                => $this->corpo,
                    'recipient-variables' => json_encode($this->destinatarioRecipient)
                ));

            if (!$enviado) {

                //Verificar mensagens de erro
                $this->setErrorMessage($enviado->http_response_body->message);

                return false;
            }

            return true;
        } catch (Exception $e) {
            $msg = ($e->getMessage() != "") ? $e->getMessage() : "Não possível enviar o email, erro no servidor!";
            $this->setErrorMessage($msg);

            return false;
        }
    }
}