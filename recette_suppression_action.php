<?php

include_once('recette_classeRecette.php');
include_once('constantes.php');
include_once('librairies/lib_BD.php');
include_once('librairies/lib_TWIG.php');

class SuppressionRecette {
	
	var $DB = null;
	var $DBerrors = array();

  var $listeRecettes = array();
	
	function SuppressionRecette(){
		$this->DB = new connexionBD(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NOM);
		$this->DB->connecter($this->DBerrors);
		
		$this->recette = new Recette();
	}

	function __destruct(){
		$this->DB->deconnecter($this->DBerrors);
	}
	
	function genererOptions($valeurs, $default = '*'){
		$str = '';
		foreach($valeurs as $key=>$val){
			$str .= '<option value="'.$key.'"';
			// Si c'est l'option sélectionnée (le cast et la vérification de types sont obligatoire sinon '*' == 0)
			if($default === $val){
			  $str .= ' selected="selected"';
			}
			$str .= '>'.htmlentities($val).'</option>';
		}
		return $str;
	}
	
	function getLibelleRecette($idRecette){
		return $this->listeRecettes[$idRecette];
	}
	
	function getListeRecettes(){
		$mesRecettes = array();
		$sql = 'SELECT idrecette, libelle FROM domonet_recette_recette';
		$res = $this->DB->executer($sql, $this->DBerrors);
		$mesRecettes = $this->DB->getArray($res, $this->DBerrors);
		
		$ar = array('*'=>' ');
		foreach($mesRecettes as $val){
			$ar[$val['idrecette']] = $val['libelle'];
		}
		return $ar;
	}

  function lireResultatSuppression($listeRecettesSupprimees){
  		$listeIngredients = '';
  
  		foreach ($listeRecettesSupprimees as $key=>$val){
  			$listeIngredients .='<li>';
  			$listeIngredients .= $val;
  			$listeIngredients .='</li>';
  		}
  		return $listeIngredients;
  }
}

$suppressionRecette = new SuppressionRecette();

$menu=$menuRecette;

if(isset($_POST['buttonSuppressionRecette'])){

if (isset($_POST['listeRecette'])){
  $listeRecetteRecue = $_POST['listeRecette'];
  $listeRecettesSupprimees = array(); 
  $recette = new Recette();

  foreach($listeRecetteRecue as $idRecetterecue){
    $listeRecettesSupprimees[$idRecetterecue] = $suppressionRecette->listeRecettes[$idRecetterecue]; 
    $recette->supprimerRecette($idRecetterecue, $suppressionRecette->DB);
  }
}
}

$suppressionRecette->listeRecettes = $suppressionRecette->getListeRecettes();

