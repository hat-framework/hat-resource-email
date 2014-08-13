<?php

if(!defined('MAIL_REMETENTE')) define("MAIL_REMETENTE" , SITE_NOME);
if(!defined('MAIL_EMAIL'))     define("MAIL_EMAIL"     , "faleconosco@".$_SERVER['HTTP_HOST']);
if(!defined('MAIL_RESPONDER')) define("MAIL_RESPONDER" , SITE_EMAIL);
if(!defined('MAIL_USER'))      define("MAIL_USER"      , "faleconosco@".$_SERVER['HTTP_HOST']);
if(!defined('MAIL_SENHA'))     define("MAIL_SENHA"     , "12tm3flol");
if(!defined('MAIL_SMTPAUTH'))  define("MAIL_SMTPAUTH"  , false);
if(!defined('MAIL_DEBUG'))     define("MAIL_DEBUG"     , true);
if(!defined('MAIL_PORT'))      define("MAIL_PORT"      , "25");
if(!defined('MAIL_HOST'))      define("MAIL_HOST"      , "smtp." . $_SERVER['HTTP_HOST']);
    
?>