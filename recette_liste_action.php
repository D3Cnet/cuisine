<?php

include_once('recette_classeRecette.php');
include_once('constantes.php');
include_once('librairies/lib_BD.php');
include_once('librairies/lib_TWIG.php');

class ListeRecettes {
	var $DB = null;
	var $DBerrors = array();

	public function __construct() {
		$this->DB = new connexionBD(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NOM);
		$this->DB->connecter($this->DBerrors);
	}

	function __destruct(){
		$this->DB->deconnecter($this->DBerrors);
	}


	function getListeRecettes(){
		$mesRecettes = array();
		$sql = 'SELECT idrecette, libelle, difficulte, appreciation, tempsPreparation, tempsCuisson';
		$sql .=' FROM domonet_recette_recette';
		$sql .=' ORDER BY libelle';
		$res = $this->DB->executer($sql, $this->DBerrors);
		$mesRecettes = $this->DB->getArray($res, $this->DBerrors);

		return $mesRecettes;
	}

	function getAppreciation($nombre){
		$boucle = 1;
		$retour = '';

		While ($boucle <= 5){
			if($nombre >=$boucle){
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

	function getDifficulte($nombre){
		$boucle = 1;
		$retour = '';

		While ($boucle <= 5){
			if($nombre >=$boucle){
				$retour .= '<img alt="Appréciation" title="Appréciation" src="images/cheff_16_allume.png">';
			}
			else
			{
				$retour .= '<img alt="Appréciation" title="Appréciation" src="images/cheff_16.png">';
			}
			$boucle++;
		}
		return $retour;
	}

    function genererTableauRecettes($tableau){
		$ligne = '';
		$ligneEntete = '';

		$ligneEntete = '<tr>';
		$ligneEntete .= '	<th class="middle" style="width:20px;"></th>';
		$ligneEntete .= '	<th class="middle" style="width:20px;"></th>';
		$ligneEntete .= '	<th class="middle" style="width:20px;"></th>';
		$ligneEntete .= '	<th class="tableau" style="width:400px;">Nom</th>';
		$ligneEntete .= '	<th class="tableau" style="width:150px;">difficulté</th>';
		$ligneEntete .= '	<th class="tableau" style="width:150px;">Appréciation</th>';
//		$ligneEntete .= '	<th class="tableau" style="width:100px;">Prép.</th>';
//		$ligneEntete .= '	<th class="tableau" style="width:100px;">Cuisson</th>';
		$ligneEntete .= '</tr>';

		$ligne = $ligneEntete;
//		$compteurLigneEntete = 0;

		foreach ($tableau as $key=>$tabLigne){
//			if(++$compteurLigneEntete%10==1){
//				if($compteurLigneEntete != 1){
//					$ligne .= $ligneEntete;
//				}
//			}

//            idrecette, libelle, difficulte, appreciation, tempsPreparation, tempsCuisson

			$ligne .= '<tr>';

			$ligne .= ' <td class="curseurAide"><img id=VISU'.$tabLigne['idrecette'].' src="images/search_16.png" title="Visualiser la recette" alt="V"';
            $ligne .= ' onclick="window.location.href=\'recette_visualisation.php?idRecette='.$tabLigne['idrecette'].'\'" /></td>';

			$ligne .= ' <td class="curseurAide"><img id=EDIT'.$tabLigne['idrecette'].' src="images/edit_16.png" title="Editer la recette" alt="S"';
            $ligne .= ' onclick="window.location.href=\'recette_edition_vue.php?idRecette='.$tabLigne['idrecette'].'\'" /></td>';

			$ligne .= ' <td class="curseurAide"><img id=PRINT'.$tabLigne['idrecette'].' src="images/print_16.png" title="Imprimer la recette" alt="V"';
            $ligne .= ' onclick="window.location.href=\'recette_visualisation.php?impression=1&idRecette='.$tabLigne['idrecette'].'\'" /></td>';

			$ligne .= ' <td class="left tableau">'.$tabLigne['libelle'].'</td>';
			$ligne .= ' <td class="center tableau">'.$this->getDifficulte($tabLigne['difficulte']).'</td>';
			$ligne .= ' <td class="center tableau">'.$this->getAppreciation($tabLigne['appreciation']).'</td>';
//			$ligne .= ' <td class="center tableau">'.$tabLigne['tempsPreparation'].'</td>';
//			$ligne .= ' <td class="center tableau">'.$tabLigne['tempsCuisson'].'</td>';
			$ligne .= '</tr>';
		}

		return $ligne;
	}

	function genererSaisieRecette($listeRecettes){
        $ligne = '';

        $ligne = '<script>	$(function() { var availableTags = [';

        foreach ($listeRecettes as $key=>$uneligne) {
          $ligne .= '"'.trim($uneligne['libelle']).'",';
        }

        $ligne .= '	]; $( "#liste_recettes" ).autocomplete({ source: availableTags }); }); </script>';

        return $ligne;
    }



}


$listeRecettes = new ListeRecettes();

$maListeRecette = $listeRecettes->getListeRecettes();

$menu=$menuRecette;


