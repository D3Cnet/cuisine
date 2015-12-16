<?php
/**
* Nom du fichier : inc_BD.php
* Projet : OC2E
* Permet la gestion des acces à une base de données SQL
* 1.00 - RJU - 08/11/2006 : Création
* 1.10 - RJU - xx/xx/200x : Ajout getHash()
* 1.11 - RJU - 18/07/2008 : Utilisation inc_Commun (ajouterErreur())
* 1.12 - RJU - 10/02/2009 - OC2E v2.01 : modif getHash(), gestion clés multiples
* 1.13 - RJU - 12/03/2009 - OC2E-E-11562b : +getNbLignes()
* 1.14 - RJU - 18/08/2009 - OC2E v2.05 : Renommage $a_abc_de->$aAbcDe
*/

// include_once('inc_Commun.php');

class connexionBD {
	var $host;	  // Nom/URL du serveur MySQL
	var $login;	 // Login de connexion à la base
	var $password;  // Mot de passe de connexion à la base
	var $database;  // Nom de la base de données à utiliser
	var $link;	  // Identifiant de la connexion ouverte

	/**
	 * Constructeur
	 * @param $host string Le serveur de base de données (adresse IP ou nom DNS)
	 * @param $login string Le nom de l'utilisateur utilisé pour se connecter
	 * @param $password string Le mot de passe de l'utilisateur
	 * @param $database string Le nom de la base de données à utiliser
	 */
	function connexionBD($host, $login, $password, $database) {
		$this->host = $host;
		$this->login = $login;
		$this->password = $password;
		$this->database = $database;
	}

	/**
	 * Etablit la connexion à la base de données
	 * @param array $aErreurs Le tableau contenant les messages d'erreurs rencontrées
	 */
	function connecter(&$aErreurs) {
		// Connexion
		$this->link = @mysql_connect($this->host,$this->login,$this->password);
		
    mysql_select_db($this->database);
    mysql_set_charset('utf8', $this->link);
    mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
    
		// En cas d'erreur
		if(!$this->link) {
			ajouterErreurDansTableau("Impossible de se connecter à la base de données !", $aErreurs);
			
			if(MODE_DEBUG) { ajouterErreurDansTableau(' -> '.mysql_error(), $aErreurs); }
			
			return false;
		}
		
		// Sélection de la base de données
		if(!@mysql_select_db($this->database, $this->link)) {
			ajouterErreurDansTableau("Impossible de sélectionner la base '".BD_BASE."' !", $aErreurs);
			
			if(MODE_DEBUG) { ajouterErreurDansTableau(' -> '.mysql_error(), $aErreurs); }
			
			return false;
		}
		
		return true;
	}

	/**
	 * Ferme la connexion
	 * @param array $aErreurs Le tableau contenant les messages d'erreurs rencontrées
	 */
	function deconnecter(&$aErreurs) {
		// Si la connexion est bien ouverte
		if($this->link) {
			// En cas d'erreur de déconnexion
			if(!@mysql_close($this->link)) {
				ajouterErreurDansTableau("Impossible de se déconnecter de la base !", $aErreurs);
				
				if(MODE_DEBUG) { ajouterErreurDansTableau(' -> '.mysql_error(), $aErreurs); }
				
				return false;
			}
		}
		
		return true;
	}
	
	/**
	 * Exécute une requête SQL
	 * @param $requete string La requête SQL à exécuter
	 * @param array $aErreurs Le tableau contenant les messages d'erreurs rencontrées
	 * @return Le résultat de la requête
	 */
	function executer($requete, &$aErreurs) {
		if(MODE_DEBUG) { echo($requete.'<br />'); }
		
		// Exécution de la requête SQL
		$resultat = @mysql_query($requete);

		// En cas d'erreur
		if((!$resultat) && MODE_DEBUG) {
			ajouterErreurDansTableau("Impossible d'exécuter la requête SQL suivante :", $aErreurs);
			ajouterErreurDansTableau($requete, $aErreurs);
			ajouterErreurDansTableau(' -> '.mysql_error(), $aErreurs);
		}
		
		return $resultat;
	}

	/**
	 * Retourne le nombre de lignes d'un résultat de requête
	 * @param $resultat Le résultat de requête
	 * @param array $aErreurs Le tableau contenant les messages d'erreurs rencontrées
	 * @return int Le nombre de lignes du résultat de requête
	 */
	function nbrLignes($resultat, &$aErreurs) {
		// Si le résultat est valide...
		if($resultat) { $nbr = @mysql_num_rows($resultat); }
		else { $nbr = 0; }
		
		return $nbr;
	}

	/**
	 * Retourne la prochaine ligne d'un résultat de requête
	 * @param $resultat Le résultat d'une requête
	 * @param array $aErreurs Le tableau contenant les messages d'erreurs rencontrées
	 * @return array Les informations de la prochaine ligne du résultat
	 */
	function getLigne($resultat, &$aErreurs, $result_type = MYSQL_ASSOC) {
		// Si le résultat est valide...
	   if($resultat) { $ligne = @mysql_fetch_array($resultat, $result_type); }
	   else { $ligne = false; }

	   return $ligne;
	}
	
	/**
	 * Retourne le résultat d'une requête sous forme d'un tableau
	 * @param $resultat Le résultat d'une requête SQL
	 * @param array $aErreurs Le tableau contenant les messages d'erreurs rencontrées
	 * @return array Le tableau à 2 dimensions contenant les lignes du résultat
	 */
	function getArray($resultat, &$aErreurs, $result_type = MYSQL_ASSOC) {
		$aArray = array();

		// Parcours des lignes du résultat
		while($ligne = ($this->getLigne($resultat, $aErreurs, $result_type))) {
			// Ajout des informations
			array_push($aArray, $ligne);
		}
	
		return $aArray;
	}
	
	/**
	 * Retourne le résultat d'une requête sous forme d'un tableau
	 * @param $resultat Le résultat d'une requête SQL
	 * @param $cleLigne Le champ servant de clé pour une ligne
	 * @param array $aErreurs Le tableau contenant les messages d'erreurs rencontrées
	 * @return array Le tableau à 2 dimensions contenant les lignes du résultat
	 */
	function getHash($resultat, $cleLigne, &$aErreurs, $result_type = MYSQL_ASSOC) {
		$hash = array();

		$aClesLigne = $cleLigne;
		if(!is_array($aClesLigne)) { $aClesLigne = array($cleLigne); }

		// Parcours des lignes du résultat
		while($ligne = ($this->getLigne($resultat, $aErreurs, $result_type))) {
			$aClesH = array();
			foreach($aClesLigne as $cleLigne) {
				array_push($aClesH, $ligne[$cleLigne]);
				unset($ligne[$cleLigne]);
			}
			
			// Ajout des informations
			eval('$hash["'.join($aClesH, '"]["').'"] = $ligne;');
		}
	
		return $hash;
	}
	
	/**
	 * Calcule le nombre de lignes de résultat d'une requête
	 * @param $requete string La requête SQL à exécuter
	 * @param $aErreurs array Le tableau contenant les messages d'erreurs rencontrées
	 * @return Le nombre de pages, null en cas d'erreur
	 */
	function getNbLignes($requete, &$aErreurs) {
		//if(MODE_DEBUG) { echo($requete.'<br />'); }
		
		// Transformation de la requête
		$matches = array();
		$nbLignes = null;
		
		if(preg_match("/^(SELECT .+ FROM )/i", $requete, $matches)) {
			$sql = str_replace($matches[1], 'SELECT COUNT(*) nbLignes FROM ', $requete);
			
			$resultat = $this->executer($sql, $aErreurs);
			if($resultat) {
				$aDonnees = $this->getArray($resultat, $aErreurs);
				$nbLignes = $aDonnees[0]['nbLignes'];
			}
		}
		else {
			ajouterErreurDansTableau("Requête SQL invalide pour le calcul du nombre de lignes !", $aErreurs);
			return null;
		}
		
		return $nbLignes;
	}
	
	public function last_id() {
		return mysql_insert_id();
//		return @mysql_insert_id($this->link);
	}
	
	public function inserer($requete, &$aErreurs){
		if($this->executer($requete, $aErreurs)) {
			return $this->last_id();
		}
		else
			return -1;
	}

}
?>
