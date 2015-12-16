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

// On se connect "manuellement" au serveur ( connection perssistante )
if(!$smtp->Connect_SMTP()){
	echo $smtp->erreur,'Impossible d&#39; envoyer le mail !!!<br />'."\r\n";
	exit();
}

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

// Liste des destinataires
$dest = array(
'adresse_1_@server.com',
'adresse_2_@server.com',
'adresse_3_@server.com',
'adresse_4_@server.com',
'adresse_5_@server.com',
'adresse_6_@server.com',
'adresse_7_@server.com',
'adresse_8_@server.com'
);


for($i=0;$i<count($dest); $i++){
	//smtp_mail('toyou@serveur.com', 'sujet', 'message', 'ent�te')
	if($smtp->smtp_mail($dest[$i], 'sujet', 'message')){
		echo '<div style="text-align:center; color:#008000;">Votre mail a bien �t� envoy� &agrave; <span style="font-weight:bolder;">',$dest[$i],'</span>.</div>',"\r\n";
	}else{// Affichage des erreurs
		echo $smtp->erreur;
	}
}

// On ferme la connection
if($smtp){
    $smtp->Deconnection_SMTP();
}
?>
