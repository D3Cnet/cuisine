<?php
/*******************************************************************************
*
* Nom de la source :
*       Class SMTP
* Nom du fichier par d�faut :
*       Version envoie complex.php
* Auteur :
*       Nuel Guillaume alias Immortal-PC
* Site Web :
*       http://immortal-pc.info/
*
*******************************************************************************/
include('./Class.SMTP.php');

// Remplissez le champs login et pass si vous avez besoin de vous identifi�
// SMTP('smtp.serveur.fr', 'login', 'pass', 'port', 'nom de domaine', 'Debug; 0 d�sactiv�, 1 activ�');

// SMTP sans authentification
// $smtp = new SMTP('smtp.serveur.fr', '', '', 25, 'nom de domaine', 'Debug; 0 d�sactiv�, 1 activ�');

$smtp = new SMTP('smtp.serveur.fr', 'login', 'mot de passe', 25, 'immortalpc.info', 0);

// De Qui
$smtp->set_from('Immortal-PC', 'me@serveur.com');

// A Qui
// espacez les e-mail avec des virgules -> toto@email.com,titi@email.com
//$smtp->Bcc = 'toyou@serveur.com';// Pour une copie cach�e
//$smtp->Cc = 'toyou@serveur.com';// Pour copie simple

// Priorit� : 1 Urgent, 3 Normal, 6 Lent
$smtp->Priority = 3;

// Encodage
$smtp->ContentType = 'text/txt';//Contenu du mail (texte, html...)

// Confirmation de reception
$smtp->Confimation_reception = '';// Entrez l' adresse o� sera renvoy� la confirmation

//smtp_mail('toyou@serveur.com', 'sujet', 'message', 'ent�te')
if($smtp->smtp_mail('toyou@serveur.com', 'sujet', 'message')){
    echo '<div style="text-align:center; color:#008000;">Votre mail a bien �t� envoy�.</div>',"\r\n";
}else{// Affichage des erreurs
    echo $smtp->erreur;
}
?>
