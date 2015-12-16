<?php

include_once('recette_classeRecette.php');
include_once('constantes.php');
include_once('librairies/lib_BD.php');
include_once('librairies/lib_TWIG.php');

class RechercheRecette {
	
	var $DB = null;
	var $DBerrors = array();

	var $resultatRecherche = array();
	var $listeRecettes = array();
	
	function RechercheRecette(){
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

	
    function getAppreciation($appreciation){
		$boucle = 1;
		$retour = '';
		
		While ($boucle <= 5){
			if($appreciation >=$boucle){
				$retour .= '<img alt="Appréciation" title="Appréciation" src="images/etoile_allumee.png">'; 
			}
			else
			{
				$retour .= '<img alt="Appréciation" title="Appréciation" src="images/etoile_eteinte.png">'; 
			}
			$boucle++;
		}
		return $retour;
	}
	
	
	
	function lancerRecherche($critere, $checkLibelle, $checkIngredients, $checkDescription){
    $this->resultatRecherche = array();
    
	    if ($checkLibelle){
		    $sql = 'SELECT idrecette, libelle, appreciation FROM domonet_recette_recette WHERE libelle like "%'.$critere.'%"';
		 		$res = $this->DB->executer($sql, $this->DBerrors);
				$tab = $this->DB->getArray($res, $this->DBerrors);
				
				foreach($tab as $ligne){
		      $this->resultatRecherche[] = array('idRecette'=>$ligne['idrecette'], 'libelle'=>$ligne['libelle'], 'appreciation'=>$ligne['appreciation'], 'provenance'=>'(Recette)');
		    }
	    }
	
	    if ($checkIngredients){
		    $sql = 'SELECT domonet_recette_recette.idrecette, domonet_recette_recette.libelle, domonet_recette_recette.appreciation FROM domonet_recette_ingredient, domonet_recette_recette_ingredient_unite, domonet_recette_recette'.
			    ' WHERE domonet_recette_ingredient.libelle like "%'.$critere.'%"'.
			    ' AND domonet_recette_recette_ingredient_unite.idrecette = domonet_recette_recette.idrecette'.
			    ' AND domonet_recette_recette_ingredient_unite.idingredient = domonet_recette_ingredient.idingredient';
		 		$res = $this->DB->executer($sql, $this->DBerrors);
				$tab = $this->DB->getArray($res, $this->DBerrors);
				
				foreach($tab as $ligne){
		      $this->resultatRecherche[] = array('idRecette'=>$ligne['idrecette'], 'libelle'=>$ligne['libelle'], 'appreciation'=>$ligne['appreciation'], 'provenance'=>'(Ingrédient)');
		    }
	    }
	
		if ($checkDescription){
			$sql = 'SELECT idrecette, libelle, appreciation FROM domonet_recette_recette WHERE modePreparation like "%'.$critere.'%"';
			$res = $this->DB->executer($sql, $this->DBerrors);
			$tab = $this->DB->getArray($res, $this->DBerrors);
				
			foreach($tab as $ligne){
				$this->resultatRecherche[] = array('idRecette'=>$ligne['idrecette'], 'libelle'=>$ligne['libelle'], 'appreciation'=>$ligne['appreciation'], 'provenance'=>'(Mode de préparation)');
			}
		}
    
	}

	function afficherResultatRecherche(){
		$resultat = '';
		foreach($this->resultatRecherche as $ligne){
			$resultat .= $this->getAppreciation($ligne['appreciation']).'&nbsp;';
			$resultat .= $ligne['provenance'].'&nbsp;';
			$resultat .= $ligne['libelle'].'&nbsp;<a href="recette_visualisation.php?idRecette='.$ligne['idRecette'].'">Visualiser</a><br></br>';
    
		}
		return $resultat;
	}

	function addOptionPourSelect($typeOption){
		$str = '';
		$numOptionSelectionne = ($typeOption == 'difficulte') ? $this->recette->difficulte : $this->recette->appreciation;
		for ($i = 0; $i <= 5; $i++) {
			$str .= '<option value="'.$i.'"';
			if($numOptionSelectionne == $i){
				$str .= ' selected="selected"';
			}
			$str .= '>'.$i.'</option>';
		}		
		return $str;		
	}
	
}

$rechercheRecette = new RechercheRecette();

$menu=$menuRecette;

if(isset($_POST['buttonRechercher'])){

	if (isset($_POST['critere'])){
		$resultatRecherche = $rechercheRecette->lancerRecherche($_POST['critere'], isset($_POST['checkLibelle']), isset($_POST['checkIngredient']), isset($_POST['checkDescription']));
	}
	
}

