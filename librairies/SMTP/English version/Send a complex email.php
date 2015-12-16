<?php
/*******************************************************************************
*
* Source Name :
*       Class SMTP
* Default file name :
*       Class.SMTP.php
* Author :
*       Nuel Guillaume alias Immortal-PC
* Web site :
*       http://immortal-pc.info/
*
* Translate by :
*		Pierre CORBEL
* Web site :
*		http://www.some-ideas.net/
*
*******************************************************************************/
include('./Class.SMTP.php');

// If the SMTP server requiere authentification
// $smtp = new SMTP('smtp.server.com', 'login', 'pass', 'port', 'domain name', 'Debug; 0 desactivate');

// SMTP without authentification
// $smtp = new SMTP('smtp.server.com', '', '', 25, 'domain name', 'Debug; 0 desactivate');

$smtp = new SMTP('smtp.server.com', 'login', 'pass', 25, 'immortalpc.info', 0);

// From
$smtp->set_from('Immortal-PC', 'me@serveur.com');

// To
// Use coma to separate e-mail -> toto@email.com,titi@email.com
//$smtp->Bcc = 'toyou@serveur.com';// For hidden copy
//$smtp->Cc = 'toyou@serveur.com';// For normal copy

// Priority : 1 Urgent, 3 Normal, 6 Slow
$smtp->Priority = 3;

// Content type
$smtp->ContentType = 'text/txt';// Content type (plain text, html...)

// Reception confirmation
$smtp->Confimation_reception = '';// Email where wil be send the confirmation

//smtp_mail('toyou@server.com', 'subject', 'message', 'header')
if($smtp->smtp_mail('toyou@server.com', 'subject', 'message')){
    echo '<div style="text-align:center; color:#008000;">The email is sended</div>',"\r\n";
}else{// Display error
    echo $smtp->erreur;
}
?>