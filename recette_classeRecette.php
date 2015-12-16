<?php

class Recette {
	
	var $id = -1;
	var $libelle = ''; 
	var	$difficulte = 0;
	var $appreciation = 0; 
	var $tempsPreparation = '';
	var $tempsCuisson = '';
	var	$modePreparation = ''; 
	var	$commentaire = '';
	var $photo = '';

	var $classementRecette = array();
	var $ingredients = array();
	var $avis = array();
	
	public function chargerRecette($id, $DB) {
		$sql = 'SELECT * FROM domonet_recette_recette WHERE idrecette = '.$id;
		$res = $DB->executer($sql, $DBerrors);
		$maRecette = $DB->getArray($res, $DBerrors);

		foreach($maRecette as $ligne){
			$this->id = $ligne['idrecette']; 
			$this->libelle = $ligne['libelle']; 
			$this->difficulte = $ligne['difficulte']; 
			$this->appreciation = $ligne['appreciation']; 
			$this->tempsPreparation = $ligne['tempsPreparation']; 
			$this->tempsCuisson = $ligne['tempsCuisson']; 
			$this->modePreparation = $ligne['modePreparation']; 
			$this->commentaire = $ligne['commentaire'];
		}
		
		$sql =  'SELECT drcr.idclassementrecette, dcr.libelle' .
				' FROM domonet_recette_recette_classementrecette drcr, domonet_recette_classementrecette dcr' .
				' WHERE idrecette = '.$id .
				' AND drcr.idclassementrecette = dcr.idclassementrecette';
		$res = $DB->executer($sql, $DBerrors);
		$this->classementRecette = $DB->getArray($res, $DBerrors);

		$sql =  'SELECT dr.idingredient, di.libelle as nomingredient, dr.idunite, du.libelle as nomunite, dr.quantite' .
				' FROM domonet_recette_recette_ingredient_unite dr, domonet_recette_ingredient di, domonet_recette_unite du' .
				' WHERE dr.idrecette = '.$id .
				' AND dr.idingredient = di.idingredient' .
				' AND dr.idunite = du.idunite'.
        ' ORDER BY dr.indice';
		$res = $DB->executer($sql, $DBerrors);
		$this->ingredients = $DB->getArray($res, $DBerrors);
		
		$sql =  'SELECT * FROM domonet_recette_avis' .
				' WHERE idrecette = '.$id;
		$res = $DB->executer($sql, $DBerrors);
		$this->avis = $DB->getArray($res, $DBerrors);
	}


	public function sauverRecette($DB) {

//		$this->supprimerRecette($this->id, $DB);

    if ($this->id == -1){
  		$sql = 'INSERT INTO domonet_recette_recette (libelle, difficulte, appreciation, tempsPreparation, tempsCuisson, modePreparation, commentaire)' .
  				' VALUES ("'.mysql_real_escape_string($this->libelle).'",'.$this->difficulte.','.$this->appreciation.',"'.mysql_real_escape_string($this->tempsPreparation).'","'.mysql_real_escape_string($this->tempsCuisson).'","'.mysql_real_escape_string($this->modePreparation).'","'.mysql_real_escape_string($this->commentaire).'")';
  		$this->id = $DB->inserer($sql, $DBerrors);
		}
		else
		{

      $sql = 'update domonet_recette_recette SET' . 
      ' libelle ="'.mysql_real_escape_string($this->libelle).'",' . 
      ' difficulte ='.$this->difficulte.',' . 
      ' appreciation ='.$this->appreciation.',' . 
      ' tempsPreparation ="'.mysql_real_escape_string($this->tempsPreparation).'",' . 
      ' tempsCuisson ="'.mysql_real_escape_string($this->tempsCuisson).'",' . 
      ' modePreparation ="'.mysql_real_escape_string($this->modePreparation).'",' . 
      ' commentaire ="'.mysql_real_escape_string($this->commentaire).'"' .
      ' WHERE idrecette='.$this->id;
				$DB->executer($sql, $DBerrors);
    }

		if ($this->id >= 0){
			
			$this->supprimerReferencesClassement($this->id, $DB);
			foreach ($this->classementRecette as $ligne){
				$sql = 'INSERT INTO domonet_recette_recette_classementrecette (idrecette, idclassementrecette)' .
						' VALUES ('.$this->id.','.$ligne['idclassementrecette'].')';
				$DB->executer($sql, $DBerrors);
			}

			$this->supprimerReferencesIngredient($this->id, $DB);	
			foreach ($this->ingredients as $ligne){
				$sql = 'INSERT INTO domonet_recette_recette_ingredient_unite (idrecette, idingredient, idunite, quantite, indice)' .
						'VALUES ('.$this->id.','.$ligne['idingredient'].','.$ligne['idunite'].',"'.mysql_real_escape_string($ligne['quantite']).'", '.$ligne['indice'].')';
				$DB->executer($sql, $DBerrors);
			}
			
			$this->supprimerReferencesAvis($this->id, $DB);
			foreach ($this->avis as $ligne){
				$sql = 'INSERT INTO domonet_recette_avis (idrecette, avis, note, date)' .
						'VALUES ('.$this->id.',"'.mysql_real_escape_string($ligne['avis']).'",'.$ligne['note'].', NOW())';
				$DB->executer($sql, $DBerrors);
			}
		}
	}

	
	public function supprimerReferencesClassement($id, $DB){
		$sql = 'DELETE FROM domonet_recette_recette_classementrecette WHERE idrecette = '.$id;
		$DB->executer($sql, $DBerrors);
	}
	
	public function supprimerReferencesIngredient($id, $DB){
		$sql = 'DELETE FROM domonet_recette_recette_ingredient_unite WHERE idrecette = '.$id;
		$DB->executer($sql, $DBerrors);
	}
	
	public function supprimerReferencesAvis($id, $DB){
		$sql = 'DELETE FROM domonet_recette_avis WHERE idrecette = '.$id;
		$DB->executer($sql, $DBerrors);
	}
	
	public function supprimerRecette($id, $DB){
	
		$sql = 'DELETE FROM domonet_recette_recette_ingredient_unite WHERE idrecette = '.$id;
		$DB->executer($sql, $DBerrors);
		  
		$sql = 'DELETE FROM domonet_recette_recette_classementrecette WHERE idrecette = '.$id;
		$DB->executer($sql, $DBerrors);
		
		$sql = 'DELETE FROM domonet_recette_avis WHERE idrecette = '.$id;
		$DB->executer($sql, $DBerrors);

		$sql = 'DELETE FROM domonet_recette_recette WHERE idrecette = '.$id;
		$DB->executer($sql, $DBerrors);
	}
	
	
	
	public function modifierRecette($id, $DB) {
		
	}
	
}