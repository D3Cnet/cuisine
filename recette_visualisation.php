<?php

include_once('recette_classeRecette.php');
include_once('constantes.php');
include_once('librairies/lib_BD.php');
include_once('librairies/lib_TWIG.php');

class VisualisationRecette {
	
	var $DB = null;
	var $DBerrors = array();
	
	var $recette = null;
	
	var $liste_categories = array();
	var $listeRecettes = array();

    function VisualisationRecette(){
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

	function getAppreciation(){
		$boucle = 1;
		$retour = '';
		
		While ($boucle <= 5){
			if($this->recette->appreciation >=$boucle){
				$retour .= '<img alt="Appréciation" title="Appréciation" src="images/favorits_16_allume.png">';
			}
			else
			{
				$retour .= '<img alt="Appréciation" title="Appréciation" src="images/favorits_16.png">';
			}
			$boucle++;
		}
		return $retour;
	}

	function getDifficulte(){
		$boucle = 1;
		$retour = '';
		
		While ($boucle <= 5){
			if($this->recette->difficulte >=$boucle){
				$retour .= '<img alt="Difficulte" title="Difficulte" src="images/cheff_16_allume.png">';
			}
			else
			{
				$retour .= '<img alt="Difficulte" title="Difficulte" src="images/cheff_16.png">';
			}
			$boucle++;
		}
		return $retour;
	}
	
	function lireClassement(){
		$classement = array();
		
		foreach ($this->recette->classementRecette as $ligne)
		{
			$classement[] = $ligne["libelle"];
		}
		return implode(' - ', $classement); 
	}
	
	function LireIngredients(){
		$listeIngredients = '';
		
		foreach ($this->recette->ingredients as $ligne){
			$listeIngredients .='<li>';
			
			$listeIngredients .= $ligne['quantite'];
			if ($ligne['nomunite'] <> 'inconnu'){
				$listeIngredients .= ' '.$ligne['nomunite'];
			}
			$listeIngredients .= ' '.$ligne['nomingredient'];
			
			$listeIngredients .='</li>';
		}
		return $listeIngredients;
	}
	
	function genererSaisieRecette(){
        $ligne = '';

        $ligne = '<script>	$(function() { var availableTags = [';

        foreach ($this->listeRecettes as $key=>$val) {
          $ligne .= '"'.trim($val).'",';
        }

        $ligne .= '	]; $( "#liste_recettes" ).autocomplete({ source: availableTags }); }); </script>';

        return $ligne;
    }
	
	function lireID($libelleRecette){
		$sql = 'SELECT idrecette FROM domonet_recette_recette WHERE libelle="'.$libelleRecette.'"';
		$res = $this->DB->executer($sql, $this->DBerrors);
		$resultat = $this->DB->getArray($res, $this->DBerrors);
		
		if (count($resultat) > 0){
      return $resultat[0]['idrecette'];
    }
    else {
      return -1;
    }
  }
}

$visualisationRecette = new VisualisationRecette();

$visualisationRecette->listeRecettes = $visualisationRecette->getListeRecettes();

$menu=$menuRecette;

if(isset($_POST['button_AfficherRecette'])){
  $idRecette_w = $visualisationRecette->lireID($_POST['libelle_recette']);

  $visualisationRecette->recette->chargerRecette($idRecette_w, $visualisationRecette->DB);
//	$visualisationRecette->recette->chargerRecette($_POST['recette'], $visualisationRecette->DB);
}

if(isset($_GET['idRecette'])){
	$visualisationRecette->recette->chargerRecette($_GET['idRecette'], $visualisationRecette->DB);
}

if(isset($_GET['impression'])){
  ob_clean();
  include('recette_impression.php');
  imprimerRecette($visualisationRecette);
  return;
}




$g_vue = 'recette_visualisation.twig';
$twigRenderTemplate = new TwigTemplateRenderer(__DIR__);
$template = $twigRenderTemplate->_environment->loadTemplate(basename($g_vue));
$g_vue = $template->render(array(
  'recette' => $visualisationRecette->recette,
  'lireClassement' => $visualisationRecette->lireClassement(), 
  'recette_commentaire' => nl2br($visualisationRecette->recette->commentaire),
  'recette_preparation' => nl2br($visualisationRecette->recette->modePreparation),
  'script_saisie_recette' => $visualisationRecette->genererSaisieRecette(),
  'post' => $_POST,
  'get' => $_GET
));

include('enteteDePage.php');

echo $g_vue;

include('piedDePage.php');


