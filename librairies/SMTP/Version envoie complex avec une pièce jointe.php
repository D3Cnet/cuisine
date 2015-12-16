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

$smtp = new SMTP('smtp.serveur.fr', 'login', 'pass', 25, 'immortal-pc.info');
$smtp2 = new SMTP('smtp.serveur_2.fr', 'login', 'pass', 25, 'immortal-pc.info');

$smtp->set_from('Immortal-PC', 'me@serveur.com', 'Site web Immortal-PC');
$smtp2->set_from('Immortal-PC', 'me@serveur.com', 'Site web Immortal-PC');

// Ajout des fichiers
$smtp->add_file('./Fichier_test.gif');
$smtp->add_file('./Fichier_test.txt');
$smtp2->add_file('./Fichier_test.gif');
$smtp2->add_file('./Fichier_test.txt');

$To = 'toyou@serveur.com';// A QUI
$Sujet = 'Sujet';// Sujet
$msg = 'Votre message ici'."\r\n".'ça marche !!';

$smtp->smtp_mail($To, $Sujet, $msg);// Envoie du mail ( Serveur 1 )
$smtp2->smtp_mail($To, $Sujet, $msg);// Envoie du mail ( Serveur 2 )

if(!$smtp->erreur){
    echo '<div style="text-align:center; color:#008000;">Votre mail a bien été envoyé. (Serveur 1)</div>',"\r\n";
}else{// Affichage des erreurs
    echo '<div style="color:#FF0000;">Serveur 1 : ',$smtp->erreur,'</div>',"\r\n",'<br />',"\r\n";
}
if(!$smtp2->erreur){
    echo '<div style="text-align:center; color:#008000;">Votre mail a bien été envoyé. (Serveur 2)</div>',"\r\n";
}else{// Affichage des erreurs
    echo '<div style="color:#FF0000;">Serveur 2 : ',$smtp2->erreur,'</div>',"\r\n",'<br />',"\r\n";
}
?>