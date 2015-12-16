<?php
/*******************************************************************************
*
* Nom de la source :
*       Class SMTP
* Nom du fichier par défaut :
*       Version envoie simple.php
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

$smtp = new SMTP('smtp.serveur.fr', 'login', 'pass');

$smtp->set_from('Immortal-PC', 'me@serveur.com');

$smtp->smtp_mail('to@you.com', 'sujet', 'message');// Envoie du mail

if(!$smtp->erreur){
    echo '<div style="text-align:center; color:#008000;">Votre mail a bien été envoyé.</div>',"\r\n";
}else{// Affichage des erreurs
    echo $smtp->erreur;
}
?>