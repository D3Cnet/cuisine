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
// SMTP('smtp.server.com', 'login', 'pass');

// else
// $smtp = new SMTP('smtp.server.com');

$smtp = new SMTP('smtp.server.com', 'login', 'pass', 25, 'immortal-pc.info');

$smtp->set_from('Immortal-PC', 'me@server.com');

// Add files
$smtp->add_file('./Fichier_test.gif');
$smtp->add_file('./Fichier_test.txt');

$smtp->smtp_mail('to@you.com', 'sujet', 'message');// Envoie du mail
// To send html and plain text email :
//$smtp->ContentType = 'txt/html';
//$smtp->smtp_mail('www.immortalpc@free.fr', 'Subject', array($msg_html, $msg_txt));// Send email

if(!$smtp->erreur){
    echo '<div style="text-align:center; color:#008000;">The email have been send correctly</div>',"\r\n";
}else{// Display error
    echo $smtp->erreur;
}
?>