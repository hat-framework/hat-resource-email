<?php

if(!empty($_POST)){
    extract($_POST);
    
    require_once '../../../../../init.php';
    require_once '../../../classes/mailer.php';
    require_once '../../../classes/config.php';
    require_once 'phpmailerMailer.php';
    $mail = phpmailerMailer::getInstanceOf();
    $mail->configure($assunto, $mensagem, $email, $nome);
    $mail->AddAddress($email);
    $response = "Email enviado com sucesso!";
    if(!$mail->send()){
        $response = $mail->getErrorMessage();
    }
    echo $response;
}
else{
?> 
<html>
    <body>
        <form name="SendEmail01" method="post">
        <table border=0>
            <tr>
                    <td>Nome:</td>
                    <td><input type="text" name="nome" size="30"></td>
            </tr>
            <tr>
                    <td>Email:</td>
                    <td><input type="text" name="email" size="30"></td>
            </tr>
            <tr>
                    <td>Assunto:</td>
                    <td><input type="text" name="assunto" size="30"></td>
            </tr>
            <tr>
                    <td>Mensagem:</td>
                    <td><textarea rows="4" name="mensagem" cols="30"></textarea></td>
            </tr>
            <tr>
                    <td><input type="submit" name="Submit" value="Submit"></td>
            </tr>
            </table>
        </form>
    </body>
</html>
<?php }?>