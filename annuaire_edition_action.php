<?php

include_once('annuaire_classeAnnuaire.php');
include_once('constantes.php');
include_once('librairies/inc_BD.php');

class EditionAnnuaire {
	
	var $DB = null;
	var $DBerrors = array();
	
	var $annuaire = null;
	var $listeAnnuaires = array();
	
	var $liste_categories = array();

  function EditionAnnuaire(){
		$this->DB = new connexionBD(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NOM);
		$this->DB->connecter($this->DBerrors);
		
		$this->annuaire = new Annuaire();
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
	
	function getLibelleAnnuaire($idAnnuaire){
		return $this->listeAnnuaires[$idAnnuaire];
	}


	public function getListeRelations(){
		$mesRelations = array();
		
		$sql = 'SELECT idTypeRelation, libelle FROM domonet_annuaire_typerelation ORDER BY libelle';
		
		$res = $this->DB->executer($sql, $this->DBerrors);
		$mesRelations = $this->DB->getArray($res, $this->DBerrors);
		
		$ar = array('*'=>' ');
		foreach($mesRelations as $val){
			$ar[$val['idTypeRelation']] = $val['libelle'];
		}
		return $ar;
	}

}

$editionAnnuaire = new EditionAnnuaire();

$menu=$menuAnnuaire;

if(isset($_GET['idAnnuaire'])){
	$editionAnnuaire->annuaire->chargerAnnuaire($_GET['idAnnuaire'], $editionAnnuaire->DB);
}

if(isset($_POST['button_Sauver'])){

	$editionRecette->recette->id = $_POST['idRecette']; 
	$editionRecette->recette->libelle = $_POST['libelle']; 
	$editionRecette->recette->difficulte = $_POST['difficulte'];
	$editionRecette->recette->appreciation = $_POST['appreciation']; 
	$editionRecette->recette->tempsPreparation = $_POST['tempsPreparation'];
	$editionRecette->recette->tempsCuisson = $_POST['tempsCuisson'];
	$editionRecette->recette->modePreparation = $_POST['modePreparation']; 
	$editionRecette->recette->commentaire = $_POST['commentaire'];

	$editionRecette->recette->classementRecette = array();
	foreach($_POST['new_classement'] as $val){
		$editionRecette->recette->classementRecette[] = array('idclassementrecette'=>$val, 'libelle'=>'INCONNU');
	}
	  
	$editionRecette->recette->ingredients = array();
	foreach($_POST['new_ingredient'] as $key=>$val){
		$editionRecette->recette->ingredients[] = array('idingredient'=>$val, 'idunite'=>$_POST['new_unite'][$key], 'quantite'=>$_POST['new_quantite'][$key]);
	}
	  
	$editionAnnuaire->annuaire->sauverAnnuaire($editionAnnuaire->DB);
	
	header("Location: Annuaire_visualisation_vue.php?idAnnuaire=".$editionAnnuaire->annuaire->idAnnuaire);
}

