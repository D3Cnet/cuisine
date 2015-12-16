
<?php 
include_once("recette_suppression_action.php");
include('enteteDePage.php');
?>

<form id="formulaire_visualiserRecette" name="formulaire_visualiserRecette" action="recette_suppression_vue.php" METHOD="post">

  <h1>Supprimer une ou plusieurs recettes</h1>
  <br>

<table class="contenuForm" style="white-space:nowrap;">
	<tr>
		<td class="contenu right" style="text-align: left; vertical-align: top;"><label for="nom_recherche">Nom de la recette :</label></td>
		<td style="text-align: left; vertical-align: top;">
			<select multiple="multiple" size="15" name="listeRecette[]" id="listeRecette">
				<?php
						echo $suppressionRecette->genererOptions($suppressionRecette->listeRecettes); 
				?>
			</select>
		</td>
	</tr>
	<tr>
  	<td style="height:20px"></td>
  	<td style="height:20px"></td>
	</tr>
	<tr>
  	<td></td>
		<td style="text-align: right; vertical-align: top;">
      <input type="submit" value="Supprimer" name="buttonSuppressionRecette"></input>
    </td>
</table>


<?php
if(isset($_POST['buttonSuppressionRecette'])){
?>
<br />

<label>Fiche(s) supprimée(s) :&nbsp;</label>

<?php echo $suppressionRecette->lireResultatSuppression($listeRecettesSupprimees); ?>
<br />
<?php
}
?>

</form>

<?php 
  include('piedDePage.php');
 ?>
