<?php

define('DB_NOM','domonet');
define('DB_HOSTNAME','localhost');
define('DB_USERNAME','daniel');
define('DB_PASSWORD','daniel');




// Constantes Mode debug
define('FULL_DEBUG', 3); // Active le log invoker + affichage de allVars
define('EXTENDED_DEBUG', 2); // Affiche les début/fins de fonctions
define('NORMAL_DEBUG', 1);
define('NO_DEBUG', 0);

// MODE_DEBUG possibles : NO_DEBUG, NORMAL_DEBUG, EXTENDED_DEBUG, FULL_DEBUG 
define('MODE_DEBUG', NO_DEBUG);


$menuRecette = '<li><a href="recette_visualisation.php">Consulter</a></li>
                <li><a href="recette_liste_vue.php">Liste</a></li>
                <li><a href="recette_recherche_vue.php">Rechercher</a></li>
                <li><a href="recette_edition_vue.php">Ajouter</a></li>
                <li><a href="recette_suppression_vue.php">Supprimer</a></li>
                <li><a href="recette_tablesParametres_vue.php">Parametres</a></li>';

$menuAnnuaire = '<li><a href="annuaire_visualisation_vue.php">Consulter</a></li>
                <li><a href="annuaire_recherche_vue.php">Rechercher</a></li>
                <li><a href="annuaire_recherche_vue.php">Imprimer</a></li>
                <li><a href="annuaire_edition_vue.php">Ajouter</a></li>
                <li><a href="annuaire_suppression_vue.php">Supprimer</a></li>';


?>