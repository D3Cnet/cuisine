<?php

//include_once('Recette.php');
include_once('constantes.php');
include_once('librairies/lib_BD.php');
include_once('librairies/lib_TWIG.php');

class TablesParametres {

	var $DB = null;
	var $DBerrors = array();

	public function TablesParametres() {
		$this->DB = new connexionBD(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NOM);
		$this->DB->connecter($this->DBerrors);
	}

	function __destruct(){
		$this->DB->deconnecter($this->DBerrors);
	}

	public function getListeIngredients(){
		$mesIngredients = array();
		
		$sql = 'SELECT idingredient, libelle FROM domonet_recette_ingredient ORDER BY libelle';
		
		$res = $this->DB->executer($sql, $this->DBerrors);
		$mesIngredients = $this->DB->getArray($res, $this->DBerrors);		
		
//		$ar = array('*'=>' ');
		foreach($mesIngredients as $val){
			$ar[$val['idingredient']] = $val['libelle'];
		}
		return $ar;
	}
	
	public function getListeUnites(){
		$mesUnites = array();
		$sql = 'SELECT idunite, libelle FROM domonet_recette_unite ORDER BY libelle';
		
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
		$sql = 'SELECT idclassementrecette, libelle FROM domonet_recette_classementrecette ORDER BY libelle';
		
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
	
	function ajouterParametre($libelle, $table){
		$sql = 'INSERT INTO '.$table.' (libelle) VALUES ("'.$libelle.'")';
		$res = $this->DB->executer($sql, $this->DBerrors);
	}
	
	
	function supprimerParametre($tableauParametres, $table, $nomCleTable){
		foreach($tableauParametres as $id){
			$sql = 'DELETE FROM '.$table.' WHERE '.$nomCleTable.' IN ('.implode(',', $tableauParametres).')';
			$res = $this->DB->executer($sql, $this->DBerrors);
		}
	}
}

$tablesParametres = new TablesParametres(); 

$menu=$menuRecette;


if(isset($_POST['buttonAjouterClassement'])){
	$tablesParametres->ajouterParametre($_POST['newClassement'], 'domonet_recette_classementrecette');
}

if(isset($_POST['buttonSupprimerClassement'])){
	$tablesParametres->supprimerParametre($_POST['listeClassements'], 'domonet_recette_classementrecette', 'idclassementrecette');
}

if(isset($_POST['buttonAjouterIngredient'])){
	$tablesParametres->ajouterParametre($_POST['newIngredient'], 'domonet_recette_ingredient');
}

if(isset($_POST['buttonSpprimerIngredient'])){
	$tablesParametres->supprimerParametre($_POST['listeIngredients'], 'domonet_recette_ingredient', 'idingredient');
}

if(isset($_POST['buttonAjouterUnite'])){
	$tablesParametres->ajouterParametre($_POST['newUnite'], 'domonet_recette_unite');
}

if(isset($_POST['buttonSpprimerUnite'])){
	$tablesParametres->supprimerParametre($_POST['listeUnites'], 'domonet_recette_unite', 'idunite');
}

$listeIngredients = $tablesParametres->getListeIngredients();
$listeUnites = $tablesParametres->getListeUnites();
$listeClassements = $tablesParametres->getListeClassements();





