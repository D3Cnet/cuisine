<?php

include_once('recette_classeRecette.php');
include_once('constantes.php');
include_once('librairies/lib_BD.php');
include_once('librairies/lib_TWIG.php');

class EditionRecette {
	var $recette = null;

	var $DB = null;
	var $DBerrors = array();

	public function EditionRecette() {
		$this->DB = new connexionBD(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NOM);
		$this->DB->connecter($this->DBerrors);
		
		$this->recette = new Recette();
	}
	
	function __destruct(){
		$this->DB->deconnecter($this->DBerrors);
	}
	
	public function getListeIngredients(){
		$mesIngredients = array();
		
		$sql = 'SELECT idingredient, libelle'.
            ' FROM domonet_recette_ingredient'.
            ' ORDER BY libelle';
		
		$res = $this->DB->executer($sql, $this->DBerrors);
		$mesIngredients = $this->DB->getArray($res, $this->DBerrors);		
		
		$ar = array('*'=>' ');
		foreach($mesIngredients as $val){
			$ar[$val['idingredient']] = $val['libelle'];
		}
		return $ar;
	}
	
	public function getListeUnites(){
		$mesUnites = array();
		$sql = 'SELECT idunite, libelle'.
            ' FROM domonet_recette_unite'.
            ' ORDER BY libelle';
		
		$res = $this->DB->executer($sql, $this->DBerrors);
		$mesUnites = $this->DB->getArray($res, $this->DBerrors);

//		$ar = array('*'=>' ');
		foreach($mesUnites as $val){
			$ar[$val['idunite']] = $val['libelle'];
		}
		return $ar;
	}

	public function getListeClassements(){
		$mesClassements = array();
		$sql = 'SELECT idclassementrecette, libelle'.
            ' FROM domonet_recette_classementrecette'.
            ' ORDER BY libelle';
		
		$res = $this->DB->executer($sql, $this->DBerrors);
		$mesClassements = $this->DB->getArray($res, $this->DBerrors);

//		$ar = array('*'=>' ');
		foreach($mesClassements as $val){
			$ar[$val['idclassementrecette']] = $val['libelle'];
		}
		return $ar;
	}

	function genererOptions($valeurs, $default = '*'){
		$str = '';
		foreach($valeurs as $key=>$val){
			$str .= '<option value="'.$key.'"';
			if($default === (string)$key){
				$str .= ' selected="selected"';
			}
			$str .= '>'.htmlentities($val).'</option>';
		}
		return $str;
	}
	
	function addNouvelleLigneTableauIngredient($listeIngredients, $listeUnites, $idIngredient, $quantite, $idUnite, $numLigne, $signe, $ordre, $boutonMonter, $boutonDescendre){
		$tr = '<tr>';

		$tr .= '<td><select class="maxWidth" name="new_ingredient[]" id="new_ingredient'.$numLigne.'">';
		$tr .= $this->genererOptions($listeIngredients, $idIngredient);		
		$tr .= '</select>';
//		$tr .= '<input class="contenuBoutonForm" style="width:15px;" type="button" value="?" onclick="ajouterSaisieLibre(this)"></input>';		
		$tr .= '</td>';
		
		$tr .= '<td><input class="contenuTextForm maxWidth" name="new_quantite[]" id="new_quantite'.$numLigne.'" value="'.$quantite.'">';
		$str = '</td>';
		
		$tr .= '<td><select class="maxWidth" name="new_unite[]" id="new_unite'.$numLigne.'">';
		$tr .= $this->genererOptions($listeUnites, $idUnite);		
		$tr .= '</select>';
//		$tr .= '<input class="contenuBoutonForm" style="width:15px;" type="button" value="?" onclick="ajouterSaisieLibre(this)"></input>';		
		$str = '</td>';

		$tr .= '<td>';
		$tr .= '<input class="contenuBoutonForm" style="width:15px;" type="button" value="'.$signe.'" onclick="'.$ordre.'"></input>';
		$str = '</td>';

    if ($boutonMonter){
    	$tr .= '<td><input class="contenuBoutonForm" type="button" value="Vers le haut" onclick="monterLigneIngredient(this)"></input></td>';
    }
    else {
  		$tr .= '<td>&nbsp;</td>';
    }
    
    if ($boutonDescendre){
    	$tr .= '<td><input class="contenuBoutonForm" type="button" value="Vers le bas" onclick="descendreLigneIngredient(this)"></input></td>';
    }
    else {
  		$tr .= '<td>&nbsp;</td>';
    }
    
    
//		$tr .= '</td>';

		$tr .= '</tr>';
		
		return $tr;
	}
	
	function addLigneTableauIngredient($listeIngredients, $listeUnites){
		$tr = '';
		
		if(count($this->recette->ingredients)==0){
			$tr = $this->addNouvelleLigneTableauIngredient($listeIngredients, $listeUnites, '*', '', '*', 1, '+', 'ajoutLigneIngredient(this)', false, false);
		}
		else
		{
			$compteur = 1;
			foreach($this->recette->ingredients as $ligne){
				if ($compteur == count($this->recette->ingredients)){
					$signe = '+'; 
					$ordre = 'ajoutLigneIngredient(this)';
				} else {
					$signe = '-'; 
					$ordre = 'supprimerLigneIngredient(this)';
				}
        
        $boutonMonter = ($compteur > 1);
        $boutonDescendre = ($compteur < count($this->recette->ingredients));

				$tr .= $this->addNouvelleLigneTableauIngredient($listeIngredients, $listeUnites, $ligne['idingredient'], $ligne['quantite'], $ligne['idunite'], $compteur, $signe, $ordre, $boutonMonter, $boutonDescendre);
//				$tr = $this->addNouvelleLigneTableauIngredient($listeIngredients, $listeUnites, $ligne['idingredient'], $ligne['quantite'], $ligne['idunite'], $compteur, $signe, $ordre).$tr;
				$compteur++;
			}
		}
					
		return $tr;
	}
	
	function addNouvelleLigneTableauClassement($listeClassements, $idClassement, $numLigne, $signe, $ordre){
		$tr = '<tr>';

		$tr .= '<td><select style="width: 100%;" name="new_classement[]" id="new_classement'.$numLigne.'">';
		$tr .= $this->genererOptions($listeClassements, $idClassement);		
		$tr .= '</select></td>';     
		
		$tr .= '<td><input class="contenuBoutonForm" style="width:15px;" type="button" value="'.$signe.'" onclick="'.$ordre.'"></input></td>';
		
		$tr .= '</tr>';
		
		return $tr;
	}

	function addLigneTableauClassement($listeClassements){
		$tr = '';
		if(count($this->recette->classementRecette)==0){
			$tr = $this->addNouvelleLigneTableauClassement($listeClassements, '*', 1, '+', 'ajoutLigneClassement(this)');
		}
		else
		{
			$compteur = 1;
			foreach($this->recette->classementRecette as $ligne){
				if ($compteur == count($this->recette->classementRecette)){
					$signe = '+'; 
					$ordre = 'ajoutLigneClassement(this)';
				} else {
					$signe = '-'; 
					$ordre = 'supprimerLigneClassement(this)';
				}
				
				$tr .= $this->addNouvelleLigneTableauClassement($listeClassements, $ligne['idclassementrecette'], $compteur, $signe, $ordre);
//				$tr = $this->addNouvelleLigneTableauClassement($listeClassements, $ligne['idclassementrecette'], $compteur, $signe, $ordre).$tr;

				$compteur++;
			}
		}
		return $tr;
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

$editionRecette = new EditionRecette();

$listeIngredients = $editionRecette->getListeIngredients();
$listeUnites = $editionRecette->getListeUnites();
$listeClassements = $editionRecette->getListeClassements();

$menu=$menuRecette;


if(isset($_GET['idRecette'])){
	$editionRecette->recette->chargerRecette($_GET['idRecette'], $editionRecette->DB);
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
    $boucle = 1;
	foreach($_POST['new_classement'] as $val){
		$editionRecette->recette->classementRecette[] = array('idclassementrecette'=>$val, 'libelle'=>'INCONNU');
//	array_unshift($editionRecette->recette->classementRecette, array('idclassementrecette'=>$val, 'libelle'=>'INCONNU'));
	}
	  
	$editionRecette->recette->ingredients = array();
	$boucle = 1;
	foreach($_POST['new_ingredient'] as $key=>$val){
		$editionRecette->recette->ingredients[] = array('idingredient'=>$val, 'idunite'=>$_POST['new_unite'][$key], 'quantite'=>$_POST['new_quantite'][$key], 'indice'=>$boucle++);
//  array_unshift($editionRecette->recette->ingredients,array('idingredient'=>$val, 'idunite'=>$_POST['new_unite'][$key], 'quantite'=>$_POST['new_quantite'][$key], 'indice'=>$boucle++));
	}

	$editionRecette->recette->sauverRecette($editionRecette->DB);
	
	header("Location: recette_visualisation.php?idRecette=".$editionRecette->recette->id);
}
