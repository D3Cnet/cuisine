
<?php 
include_once("recette_tablesParametres_action.php");
include('enteteDePage.php');
?>

<form METHOD="post" id="formulaire_tablesParametres" name="formulaire_tablesParametres" action="recette_tablesParametres_vue.php" style="width: 1000px;">

  <h1>Tables de paramètres</h1>

	<table style="text-align: left; width: 760px;" border="0" cellpadding="1" cellspacing="0">
		<tbody>
			<tr>
				<th style="width: 33%;">Classement</th>
				<th style="width: 33%;">Ingrédient</th>
				<th style="width: 33%;">Unité</th>
			</tr>
			<tr>
				<td style="width: 33%;">
					<select style="width: 100%;" multiple="multiple" size="25" name="listeClassements[]" id="listeClassements">
						<?php
								echo $tablesParametres->genererOptions($listeClassements); 
						?>
					</select>
				</td>
				<td style="width: 33%;">
					<select style="width: 100%;" multiple="multiple" size="25" name="listeIngredients[]" id="listeIngredients">
						<?php
								echo $tablesParametres->genererOptions($listeIngredients); 
						?>
					</select>
				</td>
				<td style="width: 33%;">
					<select style="width: 100%;" multiple="multiple" size="25" name="listeUnites[]" id="listeUnites">
						<?php
								echo $tablesParametres->genererOptions($listeUnites); 
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td style="width: 33%;">
					<input style="width: 180px;" maxlength="200" name="newClassement" id="newClassement" value=""></input>				
					<input type="submit" value="+" style="width: 15px;" name="buttonAjouterClassement"></input>
					<input type="submit" value="-" style="width: 15px;" name="buttonSupprimerClassement"></input>
				</td>
				<td style="width: 33%;">
					<input style="width: 180px;" maxlength="200" name="newIngredient" id="newIngredient" value=""></input>				
					<input type="submit" value="+" style="width: 15px;" name="buttonAjouterIngredient"></input>
					<input type="submit" value="-" style="width: 15px;" name="buttonSupprimerIngredient"></input>
				</td>
				<td style="width: 33%;">
					<input style="width: 180px;" maxlength="200" name="newUnite" id="newUnite" value=""></input>				
					<input type="submit" value="+" style="width: 15px;" name="buttonAjouterUnite"></input>
					<input type="submit" value="-" style="width: 15px;" name="buttonSupprimerUnite"></input>
				</td>
			</tr>
		</tbody>
	</table>


</form>

<?php 
  include('piedDePage.php');
 ?>
