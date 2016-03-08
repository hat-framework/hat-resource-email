<?php
        
class emailConfigurations extends \classes\Classes\Options{
                
    protected $files   = array(
        'email/config' => array(
            'title'        => 'Envio de Emails',
            'descricao'    => 'Configurações do envio de emails do site',
            'grupo'        => 'Emails',
            'type'         => 'resource', //config, plugin, jsplugin, template, resource
            'referencia'   => 'email/config',
            'visibilidade' => 'webmaster', //'usuario', 'admin', 'webmaster'
            'configs'      => array(
                
               /* 'MAIL_MAILER' => array(
                    'name'          => 'MAIL_MAILER',
                    'label'         => 'Serviço de envio de emails',
                    'type'          => 'enum',//varchar, text, enum
                    'options'       => "'phpmailer' => 'phpMailer', 'sendgrid' => 'SendGrid'",
                    'default'       => 'true',
                    'description'   => 'Serviço de envio de emails a ser utilizado',
                    'value'         => 'phpmailer',
                    'value_default' => 'phpmailer'
                ),*/
                
                'MAIL_REMETENTE' => array(
                    'name'          => 'MAIL_REMETENTE',
                    'label'         => 'Servidor',
                    'type'          => 'varchar',//varchar, text, enum
                    'description'   => 'Nome que aparecerá na caixa de entrada do email recebido pelo usuário do site',
                    'value'         => SITE_NOME,
                    'value_default' => SITE_NOME
                ),
                
                'MAIL_EMAIL' => array(
                    'name'          => 'MAIL_EMAIL',
                    'label'         => 'Email de Envio',
                    'type'          => 'varchar',//varchar, text, enum
                    'description'   => 'Email utilizado para enviar emails autenticados pelo site. Atenção Utilize um email
                        do próprio domínio para esta configuração!',
                    'value'         => "",
                    'value_default' => ""
                ),
                
                'MAIL_RESPONDER' => array(
                    'name'          => 'MAIL_RESPONDER',
                    'label'         => 'Email de resposta',
                    'type'          => 'varchar',//varchar, text, enum
                    'value'         => SITE_EMAIL,
                    'value_default' => SITE_EMAIL,
                    'description'   => 'Email para onde serão enviadas as respostas dos emails enviados pelo site. 
                        Pode ser qualquer email. (Gmail, Yahoo, Hotmail, Etc)',
                ),
                
                'MAIL_USER' => array(
                    'name'          => 'MAIL_USER',
                    'label'         => 'Usuário de envio autenticado',
                    'type'          => 'varchar',//varchar, text, enum
                    'value'         => '',
                    'value_default' => '',
                    'description'   => '',
                ),
                
                'MAIL_SENHA' => array(
                    'name'          => 'MAIL_SENHA',
                    'label'         => 'Senha de envio autenticado',
                    'type'          => 'varchar',//varchar, text, enum
                    'description'   => 'Senha de acesso do usuário de envio autenticado',
                    'value'         => '',
                    'value_default' => ''
                ),
                
                'MAIL_PORT' => array(
                    'name'          => 'MAIL_PORT',
                    'label'         => 'Porta de Saída',
                    'type'          => 'varchar',//varchar, text, enum
                    'description'   => 'Porta pela qual serão enviados os emails. Atenção! Segundo recomendações de profissionais,
                        utilize a porta 587!',
                    'value'         => '587',
                    'value_default' => '587'
                ),
                
                'MAIL_HOST' => array(
                    'name'          => 'MAIL_HOST',
                    'label'         => 'Host',
                    'type'          => 'varchar',//varchar, text, enum
                    'value'         => '',
                    'value_default' => '',
                    'description'   => 'Utilize smtp.seuservidor.com.br por exemplo',
                ),
                
                'MAIL_SECURE' => array(
                    'name'          => 'MAIL_SECURE',
                    'label'         => 'Protocolo de seguranca',
                    'type'          => 'varchar',//varchar, text, enum
                    'value'         => 'ssl',
                    'value_default' => 'ssl',
                    'description'   => '',
                ),
                
                'MAIL_SMTPAUTH' => array(
                    'name'          => 'MAIL_SMTPAUTH',
                    'label'         => 'Ativar autenticação',
                    'type'          => 'enum',//varchar, text, enum
                    'options'       => "'true' => 'Sim', 'false' => 'Não'",
                    'default'       => 'true',
                    'value'         => 'true',
                    'value_default' => 'true',
                    'description'   => 'Prefira utilizar envio autenticado em seu servidor, pois a chance de enviarem o seu email
                        para a pasta de spam é menor!',
                ),
                
                'MAIL_DEBUG' => array(
                    'name'          => 'MAIL_DEBUG',
                    'label'         => 'Ativar Debug ao enviar emails',
                    'type'          => 'enum',//varchar, text, enum
                    'options'       => "'true' => 'Sim', 'false' => 'Não'",
                    'default'       => 'false',
                    'value'         => 'false',
                    'value_default' => 'false',
                    'description'   => 'Esta opção permite visualizar o passo a passo ao enviar um email. Utilize-a apenas
                        se o seu servidor não está enviando emails como deveria! ',
                ),
                
            ),
        ),
        
        'email/sendgrid' => array(
            'title'        => 'Configurações do sendgrid',
            'descricao'    => 'Configurações do envio de emails do site utilizando a api do sendgrid',
            'grupo'        => 'Emails',
            'type'         => 'resource', //config, plugin, jsplugin, template, resource
            'referencia'   => 'email/sendgrid',
            'visibilidade' => 'admin', //'usuario', 'admin', 'webmaster'
            'configs'      => array(
                
                'SENDGRID_USER' => array(
                    'name'          => 'SENDGRID_USER',
                    'label'         => 'Usuário do Sendgrid',
                    'type'          => 'varchar',//varchar, text, enum
                    'description'   => 'Usuário com a conta do sendgrid http://sendgrid.com/',
                    'value'         => '',
                    'value_default' => ''
                ),
                
                'SENDGRID_PASS' => array(
                    'name'          => 'SENDGRID_PASS',
                    'label'         => 'Senha',
                    'type'          => 'varchar',//varchar, text, enum
                    'description'   => 'Senha da api do sendgrid http://sendgrid.com/',
                    'value'         => '',
                    'value_default' => ''
                ),
                
            ),
        ),
        'email/mailgun' => array(
            'title'        => 'Configurações do Mailgun',
            'descricao'    => 'Configurações do envio de emails do site utilizando a api do mailgun',
            'grupo'        => 'Emails',
            'type'         => 'resource', //config, plugin, jsplugin, template, resource
            'referencia'   => 'email/sendgrid',
            'visibilidade' => 'admin', //'usuario', 'admin', 'webmaster'
            'configs'      => array(

                'MAILGUN_KEY' => array(
                    'name'          => 'MAILGUN_KEY',
                    'label'         => 'Chave',
                    'type'          => 'varchar',//varchar, text, enum
                    'description'   => 'Chave de envio da conta do Mailgun https://mailgun.com',
                    'value'         => '',
                    'value_default' => ''
                ),

                'MAILGUN_DOMINIO' => array(
                    'name'          => 'MAILGUN_DOMINIO',
                    'label'         => 'Dominio',
                    'type'          => 'varchar',//varchar, text, enum
                    'description'   => 'Dominio cadastrado no site https://mailgun.com',
                    'value'         => '',
                    'value_default' => ''
                ),
            ),
        ),
    );
    
    public function getFiles() {
        $this->files = parent::getFiles();
        $this->files['email/config']['configs']['MAIL_EMAIL']['value'] = "faleconosco@". $_SERVER['HTTP_HOST'];
        $this->files['email/config']['configs']['MAIL_USER']['value']  = "no-reply@". $_SERVER['HTTP_HOST'];
        $this->files['email/config']['configs']['MAIL_HOST']['value']  = 'smtp.'       . $_SERVER['HTTP_HOST'];
        return $this->files;
    }
}

?>