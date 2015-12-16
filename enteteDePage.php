<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<!--	<meta http-equiv="Content-Type" content="text/html" /> -->
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type">	
	<title>
		DomoNet
	</title>
	<!-- La feuille de styles "base.css" doit être appelée en premier. -->
	<link rel="stylesheet" type="text/css" href="styles/base.css" media="all" />
	<link rel="stylesheet" type="text/css" href="styles/modeleDomoNet.css" media="all" />
<!-- <link rel="stylesheet" type="text/css" href="styles/modele07.css" media="screen" /> -->

<link type="text/css" href="librairies/jquery-ui/css/cupertino/jquery-ui-1.8.14.custom.css" rel="Stylesheet" />	
<script type="text/javascript" src="librairies/jquery-ui/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="librairies/jquery-ui/js/jquery-ui-1.8.14.custom.min.js"></script>

</head>

<body>

<div id="global">

<?php
  session_start();

  if (isset($_GET['action'])) {
    session_destroy();
    session_start();
    $_SESSION['dateConnexion'] = date();
  }

  if(!isset($_SESSION['connecte'])){
    $_SESSION['connecte'] = false;
  }
?>

	<div id="entete">
    <div class="gauche">
  		<h1>
        <a href="index.php">
  		  	<img alt="" src="images/domonet.png" />
        </a>  
  			<span>DomoNet</span>
  		</h1>
  		<p class="sous-titre">
  			<i>Réseau d'applications domestiques</i>
      </p>
    </div>
    <div class="droite">
<?php
  if(isset($_SESSION['connecte'])){
    if ($_SESSION['connecte'] === true){
      echo $_SESSION['utilisateur']['prenom'].' '.$_SESSION['utilisateur']['nom'].' - <a href="identification_vue.php?action=deconnexion">Se déconnecter</a>';
    } 
    else {
      echo '<a href="identification_vue.php">Se connecter</a>';
    }
  }
  else {
    header("location: identification_vue.php");
  }
?>
    </div>
	</div><!-- #entete -->


<?php
  if(isset($_SESSION['connecte'])){
    if ($_SESSION['connecte'] === true){
?>
	<div id="barreaction">
	<a href="recette_visualisation.php"><img title="Gestion des recettes de cuisine" alt="Gestion des recettes de cuisine" src="images/chef.png" /></a>
	<a href="annuaire_visualisation_vue.php"><img title="Gestion du répertoire téléphonique et des amis" alt="Gestion du répertoire téléphonique et des amis" src="images/repertoire.png" /></a>
	<a href="semainier_vue.php"><img title="Gestion du semainier" alt="Gestion du semainier" src="images/semainier.png" /></a>
	<a href="calendrier_vue.php"><img title="Gestion des évènements personnels" alt="Gestion des évènements personnels" src="images/calendrier.png" /></a>
	</div><!-- #barreaction -->
<?php
    }
  }
?>
  
	<div id="centre">
		<div id="navigation">
			<ul>
        <?php if(isset($menu)) 
                echo $menu; ?>			
			</ul>
		</div><!-- #navigation -->

		<div id="contenu">