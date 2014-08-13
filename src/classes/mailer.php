<?php

interface mailer{

        //configura os atributos da mensagem, como assunto, corpo, etc
	public function configure($assunto, $corpo, $email_remetente, $nomeRemetente);
	
        //recebe uma string ou um array com os emails dos destinatarios
	public function AddAddress($destinatario);
        
        //adiciona um anexo a mensagem, $file pode ser um array ou uma string que indica o diretório do arquivo
        public function AddAttachment($file, $newname);
	
        //envia o email
	public function send();
	
}

?>