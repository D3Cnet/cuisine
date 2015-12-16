<?php

include_once('annuaire_classeAnnuaire.php');
include_once('constantes.php');
include_once('librairies/inc_BD.php');

class VisualisationAnnuaire {
	
	var $DB = null;
	var $DBerrors = array();
	
	var $annuaire = null;
	var $listeAnnuaires = array();
	
	var $liste_categories = array();

  function VisualisationAnnuaire(){
		$this->DB = new connexionBD(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NOM);
		$this->DB->connecter($this->DBerrors);
		
		$this->annuaire = new Annuaire();
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
	
	function getLibelleAnnuaire($idAnnuaire){
		return $this->listeAnnuaires[$idAnnuaire];
	}

	
	function getListeAnnuaires(){
		$mesAnnuaires = array();
		$sql = 'SELECT idannuaire, nom, prenom FROM domonet_annuaire_personne';
		$res = $this->DB->executer($sql, $this->DBerrors);
		$mesAnnuaires = $this->DB->getArray($res, $this->DBerrors);
		
		$ar = array('*'=>' ');
		foreach($mesAnnuaires as $val){
			$ar[$val['idannuaire']] = $val['nom'].' '.$val['prenom'];
		}
		return $ar;
	}

	function LireRelations(){
		$listeRelations = '';
		
		foreach ($this->annuaire->listeRelations as $ligne){
			$listeRelations .='<li>';
			
			$listeRelations .= $ligne['idpersonnedestination'];
			$listeRelations .= ' '.$ligne['idtyperelation'];
			
			$listeRelations .='</li>';
		}
		return $listeRelations;
	}
}

$visualisationAnnuaire = new VisualisationAnnuaire();

$visualisationAnnuaire->listeAnnuaires = $visualisationAnnuaire->getListeAnnuaires();

$menu=$menuAnnuaire;

if(isset($_POST['button_AfficherAnnuaire'])){
	$visualisationAnnuaire->annuaire->chargerPersonne($_POST['annuaire'], $visualisationAnnuaire->DB);
}

if(isset($_GET['idAnnuaire'])){
	$visualisationAnnuaire->annuaire->chargerPersonne($_GET['idAnnuaire'], $visualisationAnnuaire->DB);
}

