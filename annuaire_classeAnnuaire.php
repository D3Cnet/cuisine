<?php

class Annuaire {
	
	var $idannuaire = -1;
	var $civilite = '';
	var $nom = '';
	var $prenom = '';
	var $adresse1 = '';
	var $adresse2 = '';
	var $codepostal = '';
	var $ville = '';
	var $departement = '';
	var $pays = '';
	var $sexe = '';
	var $categorie = '';
	var $telephone = '';
	var $fax = '';
	var $mobile = '';
	var $email = '';
	var $web = '';
	var $dateanniversaire = '';
	var $datefete = '';
	var $commentaire = '';
	
  var $socnom = '';
	var $socadresse1 = '';
	var $socadresse2 = '';
	var $soccodepostal = '';
	var $socville = '';
	var $socdepartement = '';
	var $socpays = '';
	var $soctelephone = '';
	var $socfax = '';
	var $socmobile = '';
	var $socemail = '';
	var $socweb = '';
	var $soccommentaire = '';

	var $listeRelations = array();

	public function chargerPersonne($id, $DB) {
		$sql = 'SELECT * FROM domonet_annuaire_personne WHERE idannuaire = '.$id;
		$res = $DB->executer($sql, $DBerrors);
		$maPersonne = $DB->getArray($res, $DBerrors);

		foreach($maPersonne as $ligne){
		
    	$this->idannuaire= $ligne['idannuaire'];
    	$this->civilite= $ligne['civilite'];
    	$this->nom= $ligne['nom'];
    	$this->prenom= $ligne['prenom'];
    	$this->adresse1= $ligne['adresse1'];
    	$this->adresse2= $ligne['adresse2'];
    	$this->codepostal= $ligne['codepostal'];
    	$this->ville= $ligne['ville'];
    	$this->departement= $ligne['departement'];
    	$this->pays= $ligne['pays'];
    	$this->sexe= $ligne['sexe'];
    	$this->categorie= $ligne['categorie'];
    	$this->telephone= $ligne['telephone'];
    	$this->fax= $ligne['fax'];
    	$this->mobile= $ligne['mobile'];
    	$this->email= $ligne['email'];
    	$this->web= $ligne['web'];
    	$this->dateanniversaire= $ligne['dateanniversaire'];
    	$this->datefete= $ligne['datefete'];
    	$this->commentaire= $ligne['commentaire'];
    	
      $this->socnom = $ligne['socnom'];
    	$this->socadresse1 = $ligne['socadresse1'];
    	$this->socadresse2 = $ligne['socadresse2'];
    	$this->soccodepostal = $ligne['soccodepostal'];
    	$this->socville = $ligne['socville'];
    	$this->socdepartement = $ligne['socdepartement'];
    	$this->socpays = $ligne['socpays'];
    	$this->soctelephone = $ligne['soctelephone'];
    	$this->socfax = $ligne['socfax'];
    	$this->socmobile = $ligne['socmobile'];
    	$this->socemail = $ligne['socemail'];
    	$this->socweb = $ligne['socweb'];
    	$this->soccommentaire = $ligne['soccommentaire'];
    }
  
    $sql = 'SELECT idpersonnesource, idpersonnedestination, idtyperelation from domonet_annuaire_relation'.
           ' WHERE idpersonnesource='.$this->idannuaire;
 		$res = $DB->executer($sql, $DBerrors);
 		$this->classementRecette = $DB->getArray($res, $DBerrors);
	}


	public function sauverPersonne($DB) {

    if ($this->idannuaire == -1){
  		$sql = 'INSERT INTO domonet_annuaire_personne (civilite,nom,prenom,adresse1,adresse2,codepostal,ville,departement,pays,sexe,categorie,telephone,fax,mobile,email,web,dateanniversaire,datefete,commentaire,socnom,socadresse1,socadresse2,soccodepostal,socville,socdepartement,socpays,soctelephone,socfax,socmobile,socemail,socweb,soccommentaire)'.
              ' VALUES ("'.mysql_real_escape_string($this->civilite).'",'.
              '"'.mysql_real_escape_string($this->nom).'",'.
              '"'.mysql_real_escape_string($this->prenom).'",'.
              '"'.mysql_real_escape_string($this->adresse1).'",'.
              '"'.mysql_real_escape_string($this->adresse2).'",'.
              '"'.mysql_real_escape_string($this->codepostal).'",'.
              '"'.mysql_real_escape_string($this->ville).'",'.
              '"'.mysql_real_escape_string($this->departement).'",'.
              '"'.mysql_real_escape_string($this->pays).'",'.
              '"'.mysql_real_escape_string($this->sexe).'",'.
              '"'.mysql_real_escape_string($this->categorie).'",'.
              '"'.mysql_real_escape_string($this->telephone).'",'.
              '"'.mysql_real_escape_string($this->fax).'",'.
              '"'.mysql_real_escape_string($this->mobile).'",'.
              '"'.mysql_real_escape_string($this->email).'",'.
              '"'.mysql_real_escape_string($this->web).'",'.
              '"'.$this->dateanniversaire.'",'.
              '"'.mysql_real_escape_string($this->datefete).'",'.
              '"'.mysql_real_escape_string($this->commentaire).'",'.
              '"'.mysql_real_escape_string($this->socnom).'",'.
              '"'.mysql_real_escape_string($this->socadresse1).'",'.
              '"'.mysql_real_escape_string($this->socadresse2).'",'.
              '"'.mysql_real_escape_string($this->soccodepostal).'",'.
              '"'.mysql_real_escape_string($this->socville).'",'.
              '"'.mysql_real_escape_string($this->socdepartement).'",'.
              '"'.mysql_real_escape_string($this->socpays).'",'.
              '"'.mysql_real_escape_string($this->soctelephone).'",'.
              '"'.mysql_real_escape_string($this->socfax).'",'.
              '"'.mysql_real_escape_string($this->socmobile).'",'.
              '"'.mysql_real_escape_string($this->socemail).'",'.
              '"'.mysql_real_escape_string($this->socweb).'",'.
              '"'.mysql_real_escape_string($this->soccommentaire).'")';
              
  		$this->idannuaire = $DB->inserer($sql, $DBerrors);
    
    }
    else {
  		$sql = 'UPDATE domonet_annuaire_personne SET'.
              ' civilite="'.mysql_real_escape_string($this->nom).'",'.
              ' nom="'.mysql_real_escape_string($this->nom).'",'.            
              ' prenom="'.mysql_real_escape_string($this->prenom).'",'.         
              ' adresse1="'.mysql_real_escape_string($this->adresse1).'",'.       
              ' adresse2="'.mysql_real_escape_string($this->adresse2).'",'.       
              ' codepostal="'.mysql_real_escape_string($this->codepostal).'",'.     
              ' ville="'.mysql_real_escape_string($this->ville).'",'.          
              ' departement="'.mysql_real_escape_string($this->departement).'",'.    
              ' pays="'.mysql_real_escape_string($this->pays).'",'.           
              ' sexe="'.mysql_real_escape_string($this->sexe).'",'.           
              ' categorie="'.mysql_real_escape_string($this->categorie).'",'.      
              ' telephone="'.mysql_real_escape_string($this->telephone).'",'.      
              ' fax="'.mysql_real_escape_string($this->fax).'",'.            
              ' mobile="'.mysql_real_escape_string($this->mobile).'",'.         
              ' email="'.mysql_real_escape_string($this->email).'",'.          
              ' web="'.mysql_real_escape_string($this->web).'",'.            
              ' dateanniversaire="'.$this->dateanniversaire.'",'.                                  
              ' datefete="'.mysql_real_escape_string($this->datefete).'",'.       
              ' commentaire="'.mysql_real_escape_string($this->commentaire).'",'.    
              ' socnom="'.mysql_real_escape_string($this->socnom).'",'.         
              ' socadresse1="'.mysql_real_escape_string($this->socadresse1).'",'.    
              ' socadresse2="'.mysql_real_escape_string($this->socadresse2).'",'.    
              ' soccodepostal="'.mysql_real_escape_string($this->soccodepostal).'",'.  
              ' socville="'.mysql_real_escape_string($this->socville).'",'.       
              ' socdepartement="'.mysql_real_escape_string($this->socdepartement).'",'. 
              ' socpays="'.mysql_real_escape_string($this->socpays).'",'.        
              ' soctelephone="'.mysql_real_escape_string($this->soctelephone).'",'.   
              ' socfax="'.mysql_real_escape_string($this->socfax).'",'.         
              ' socmobile="'.mysql_real_escape_string($this->socmobile).'",'.      
              ' socemail="'.mysql_real_escape_string($this->socemail).'",'.       
              ' socweb="'.mysql_real_escape_string($this->socweb).'",'.         
              ' soccommentaire="'.mysql_real_escape_string($this->soccommentaire).'"'.
              ' WHERE idannuaire='.$this->idannuaire;
      $DB->executer($sql, $DBerrors);
    
    }
      
/*
idannuaire,
civilite,
nom,
prenom,
adresse1,
adresse2,
codepostal,
ville,
departement,
pays,
sexe,
categorie,
telephone,
fax,
mobile,
email,
web,
dateanniversaire,
datefete,
commentaire,
socnom,
socadresse1,
socadresse2,
soccodepostal,
socville,
socdepartement,
socpays,
soctelephone,
socfax,
socmobile,
socemail,
socweb,
soccommentaire  
*/

		if ($this->idannuaire >= 0){
			
			$this->supprimerReferencesRelation($this->idannuaire, $DB);
			foreach ($this->relation as $ligne){
				$sql = 'INSERT INTO domonet_annuaire_relation (idpersonnesource, idpersonnedestination, idtyperelation)' .
						' VALUES ('.$this->idannuaire.','.$ligne['idannuaire'].','.$ligne['idtyperelation'].')';
				$DB->executer($sql, $DBerrors);
			}

		}
	}
	
	public function supprimerReferencesRelation($id, $DB){
		$sql = 'DELETE FROM domonet_annuaire_relation WHERE idpersonnesource = '.$id;
		$DB->executer($sql, $DBerrors);
	}
	
	public function supprimerPersonne($id, $DB){
	
		$sql = 'DELETE FROM domonet_annuaire_personne WHERE idannuaire = '.$id;
		$DB->executer($sql, $DBerrors);

  	$this->supprimerReferencesRelation($this->id, $DB);
	}
	
	
	
	public function modifierPersonne($id, $DB) {
		
	}
	
}