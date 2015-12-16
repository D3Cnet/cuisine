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

// Connect to the server with or without authentification
$smtp = new SMTP('yourserver.com', 'login', 'pass');
//$smtp = new SMTP('yourserver.com');

// To send japanese email, you should use unicode encoding like UTF8 or ISO-2022-JP
// If your subject, sender or message information is not encoded with UTF8 charset, 
// don't forget to convert it with mb_convert_encoding function
$smtp->set_encode('UTF8', 'YOURCHARSET')
// the sender
$smtp->set_from('From me', 'me@server.com');
// just for your test
$smtp->debug = true;

$smtp->ContentType = 'text/plain';
// Send email
$smtp->smtp_mail('to@you.com', 'Subject', 'Message');

// Check errors
if(!$smtp->erreur){
    echo '<div style="text-align:center; color:#008000;">The email have been send correctly</div>',"\r\n";
}else{
    echo $smtp->erreur;
}
?>