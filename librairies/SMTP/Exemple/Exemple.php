<?php
/*******************************************************************************
*
* Nom de la source :
*       Class SMTP
* Nom du fichier par défaut :
*       Exemple.php
* Auteur :
*       Nuel Guillaume alias Immortal-PC
* Site Web :
*       http://immortal-pc.info/
*
*******************************************************************************/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Exemple de formulaire de contact avec envoie en SMTP et une pièce jointe</title>

</head>
<body>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
<?php
//**********************************************************************
// Variables à modifier
//**********************************************************************
// Dossier temporaire
$file_dir = './';

// Paramètres du serveur SMTP
$smtp_serveur = 'smtp.serveur.fr';
$smtp_login = 'login';
$smtp_passe = '*******';
$smtp_domain = 'monserveur.com';

// Adresse de destination ( votre e-mail pour tester )
$mail_to = 'webmaster@server.com';




// ON vérifit si les données du formulaire ont été envoyés
if(IsSet($_POST['name'], $_POST['email'], $_POST['sujet'], $_POST['msg'])){
	// On vérifit qu' il y a bien tout les champss minimum
	if($_POST['name'] && $_POST['email'] && $_POST['sujet'] && $_POST['msg']){
		$no_empty_champs = 1;
	}else{
		echo '<div style="color:#FF0000;">Please, Complet all field !</div>';
		$no_empty_champs = 0;
	}
 
	// On vérifit s' il y a un fichier à uploader
	if(trim($_FILES['file_up']['name']) !== '' && $no_empty_champs){
        if(!($up = move_uploaded_file($_FILES['file_up']['tmp_name'], $file_dir.$_FILES['file_up']['name'])) || !is_file($file_dir.$_FILES['file_up']['name'])){
            echo '<div style="color:#FF0000;">The file can&#39; t be upload !</div>';
        }
        // On définit où est le fichier
        $file_up = $file_dir.$_FILES['file_up']['name'];
	}else{
		// Upload ok
		$up = 1;
		$file_up = 0;
	}

	// On vérifit que l' on a uploader le fichier
	if($up && $no_empty_champs){
		// On inclut la class
		include('./Class.SMTP.php');
		
		// On definit les paramètres
		$smtp = new SMTP($smtp_serveur, $smtp_login, $smtp_passe, 25, $smtp_domain);
		
		// Initialisation du propriétaire
		$smtp->set_from($_POST['name'], $_POST['email']);
		
		if($file_up){
			// On joint le fichier
			$smtp->add_file($file_up);
		}
		
		// Contenu du mail (texte, html...) (txt , html, txt/html)
		$smtp->ContentType = 'txt';
		
		// Envoie du mail
		$smtp->smtp_mail($mail_to, $_POST['sujet'], $_POST['msg']);
		
		// On vérifit que le mail a été envoyé correctement
		if(!$smtp->erreur){
	    	echo '<div style="text-align:center; color:#008000;">Your mail as been send.</div>',"\r\n";
	    	if($file_up){
		    	// Suppresion du fichier temporaire
		    	unlink($file_up);
	    	}
		}else{// Affichage d' erreur(s)
		    echo $smtp->erreur;
		}	
	}
}
?>

<label for="name">Name : </label><input type="text" name="name" id="name" /><br />
<label for="email">E-mail : </label><input type="text" name="email" id="email" /><br />
<label for="sujet">Subject : </label><input type="text" name="sujet" id="sujet" /><br />
<label for="msg">Message : </label><br />
<textarea cols="60" rows="10" name="msg" id="msg"></textarea><br />
<label for="file_up">Attach file : </label><input type="file" name="file_up" id="file_up" /><br />
<input type="submit" value="Send" />
</form>
</body></html>