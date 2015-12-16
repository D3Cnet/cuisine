<?php
/*******************************************************************************
*
* Nom de la source :
*       Class SMTP
* Nom du fichier par défaut :
*       Version envoie simple avec une pièce jointe.php
* Auteur :
*       Nuel Guillaume alias Immortal-PC
* Site Web :
*       http://immortal-pc.info/
*
*******************************************************************************/
include('./Class.SMTP.php');

// Remplissez le champs login et pass si vous avez besoin de vous identifié
// SMTP('smtp.serveur.fr', 'login', 'pass');

// SMTP sans authentification
// $smtp = new SMTP('smtp.serveur.fr');



$smtp = new SMTP('smtp.serveur.fr', 'login', 'pass', 25, 'immortal-pc.info');

$smtp->set_from('Immortal-PC', 'me@serveur.com');

// Ajout des fichiers
$smtp->add_file('./Fichier_test.gif');
$smtp->add_file('./Fichier_test.txt');

$smtp->smtp_mail('to@you.com', 'sujet', 'message');// Envoie du mail
// Pour avoir un mail en html et en texte simple :
//$smtp->ContentType = 'txt/html';
//$smtp->smtp_mail('toyou@serveur.com', 'Sujet', array($msg_html, $msg_txt));// Envoie du mail

if(!$smtp->erreur){
    echo '<div style="text-align:center; color:#008000;">Votre mail a bien été envoyé.</div>',"\r\n";
}else{// Affichage des erreurs
    echo $smtp->erreur;
}
?>
