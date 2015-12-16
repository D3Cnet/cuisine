<?php
include_once("recette_liste_action.php");
include('enteteDePage.php');
?>


<form METHOD="post" id="formulaire_listeRecette" name="formulaire_listeRecette" action="recette_visualisation.php" style="width: 650px;">

  <h1>Liste des recettes</h1>
  <br>

<?php
  echo $listeRecettes->genererSaisieRecette($maListeRecette);
?>
<table class="contenuForm" style="white-space:nowrap;">
  <tr>
	<td>Nom de la recette : </td>
	<td class="ui-widget">
      <input id="liste_recettes" style="width: 300px;" name="libelle_recette"/>
    </td>
	<td>
		<input type="submit" value="Afficher" name="button_AfficherRecette"></input>
<!--
        <img src="images/search_16.png" title="Visualiser la recette" alt="V" onclick="javascript:document.getElementById('formulaire_listeRecette').submit();" />
-->
    </td>
  </tr>
</table>

<br><br>

<?php
     if (count($maListeRecette) != 0){
?>

<div id="tableau">
	<table class="tableau" id="table_recette">
		<tbody>
<?php
     echo $listeRecettes->genererTableauRecettes($maListeRecette);
?>
		</tbody>
	</table>
</div>

 <?php
     }
?>

</form>

<?php
  include('piedDePage.php');
 ?>

