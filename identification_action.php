<?php

include_once('constantes.php');
include_once('librairies/lib_BD.php');
include_once('librairies/lib_TWIG.php');

class Identification {
	
	var $DB = null;
	var $DBerrors = array();
	
  function Identification(){
		$this->DB = new connexionBD(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NOM);
		$this->DB->connecter($this->DBerrors);
	}


  function identifier_Utilisateur($login, $password){
    $loginOK = false;
//    session_start();
    
    // On va chercher les informations de ce login
    $sql = 'SELECT * FROM domonet_utilisateur WHERE login = "'.$login.'"';
 		$res = $this->DB->executer($sql, $this->DBerrors);
		$tableau = $this->DB->getArray($res, $this->DBerrors);
    
//    $req = mysql_query($sql) or die('Erreur SQL : <br />'.$sql);
   
    // On vérifie que l'utilisateur existe bien
    if (count($tableau) > 0) {
       $data = $tableau[0];

     
      // On vérifie que son mot de passe est correct
      if (md5($password) == $data['password']) {
        $loginOK = true;
      }
//      echo $data['password'];
//      die();
    }
  
    // Si le login a été validé on met les données en sessions
    if ($loginOK) {
      $_SESSION['connecte'] = true;
      $_SESSION['utilisateur'] = $data;
      
      var_dump($_SESSION);
    }
    else
    {
    
      if (isset($_SESSION['nombreEssais']))
        $nombreEssais = $_SESSION['nombreEssais']+1;
      else
        $nombreEssais = 1;

      // On écrase le tableau de session
      $_SESSION = array();

      $_SESSION['connecte'] = false;
      
      $_SESSION['nombreEssais'] = $nombreEssais;
      
      // On détruit la session
      // session_destroy();
    }
  }
}

$identification = new Identification();       


if(isset($_POST['button_Connexion'])){
  if ((!empty($_POST['login'])) && (!empty($_POST['password']))) {
    $identification->identifier_Utilisateur($_POST['login'], $_POST['password']);
  }
}