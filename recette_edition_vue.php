<?php 
include_once("recette_edition_action.php");
include('enteteDePage.php');
include('recette_edition.js');
?>

<form METHOD="post" id="formulaire_editionRecette" name="formulaire_editionRecette" action="recette_edition_vue.php" style="width: 650px;">

<h1>Rédiger une recette</h1>
<br>

	<select name="classementsCaches" id="classementsCaches" style="display:none;">
{% for valeur in valeurs %}
		<option value="{{ valeur.idclassementrecette }}"

		, libelle


		foreach($valeurs as $key=>$val){
		$str .= '<option value="'.$key.'"';
		if($default === (string)$key){
		$str .= ' selected="selected"';
		}
		$str .= '>'.htmlentities($val).'</option>';
		}



	<?php
		echo $editionRecette->genererOptions($listeClassements);
	?>
	</select>

	<select name="ingredientsCaches" id="ingredientsCaches" style="display:none;">
	<?php
		echo $editionRecette->genererOptions($listeIngredients);
	?>
	</select>

	<select name="unitesCachees" id="unitesCachees" style="display:none;">
	<?php
		echo $editionRecette->genererOptions($listeUnites);
	?>
	</select>

	<input type="hidden" name="idRecette"  value="<?php echo $editionRecette->recette->id ?>">

	<table class="tableAlignement">
		<tbody>
			<tr>
				<td style="width: 180px;">Nom de la recette :&nbsp;</td>
				<td><input maxlength="200" name="libelle" id="libelle" size="60" value="<?php echo $editionRecette->recette->libelle ?>"></input></td>
			</tr>
			<tr>
				<td style="width: 180px;">Classé dans :&nbsp;</td>
				<td>
			<table style="text-align: left; width: 285px;" border="0" cellpadding="2" cellspacing="0">
			<tbody id="tableClassementBody">
				<?php
					echo $editionRecette->addLigneTableauClassement($listeClassements);
				?>
			</tbody>
			</table>
		</td>
			<tr>
				<td style="width: 180px;">Difficulté :</td>
				<td>
					<select name="difficulte" id="difficulte" style="width: 50px;">
						<?php
							echo $editionRecette->addOptionPourSelect('difficulte');
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td style="width: 180px;">Appréciation :</td>
				<td>
					<select name="appreciation" id="appreciation" style="width: 50px;">
						<?php
							echo $editionRecette->addOptionPourSelect('appreciation');
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td style="width: 180px;">Temps de préparation :</td>
				<td><input maxlength="200" name="tempsPreparation" id="tempsPreparation" value="<?php echo $editionRecette->recette->tempsPreparation ?>"></td>
			</tr>
			<tr>
				<td style="width: 180px;">Temps de cuisson :</td>
				<td><input maxlength="200" name="tempsCuisson" id="tempsCuisson" value="<?php echo $editionRecette->recette->tempsCuisson ?>"></td>
			</tr>
		</tbody>
	</table>
	<br>
	<table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="0">
		<tbody>
			<tr>
				<td style="text-align: left; vertical-align: top; width: 180px;">Commentaire :&nbsp;</td>
				<td><textarea cols="50" wrap="normal" rows="3" name="commentaire" id="commentaire"><?php echo $editionRecette->recette->commentaire ?></textarea><br>
				</td>
			</tr>
		</tbody>
	</table>
	<br>
	<table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="0">
		<tbody>
			<tr>
				<td style="text-align: left; vertical-align: top; width: 180px;">Préparation :&nbsp;</td>
				<td><textarea cols="50" wrap="normal" rows="10" name="modePreparation" id="modePreparation"><?php echo $editionRecette->recette->modePreparation ?></textarea><br>
				</td>
			</tr>
		</tbody>
	</table>
	<br>
	Ingrédients :&nbsp;<br>
	<table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="0">
		<tbody id="tableIngredientBody">
			<tr>
				<th style="text-align: center;">Ingrédient</th>
				<th style="text-align: center;">Quantité</th>
				<th style="text-align: center; width: 126px;">Unité</th>
				<th style="width: 30px;"></th>
			</tr>
			<?php

				echo $editionRecette->addLigneTableauIngredient($listeIngredients, $listeUnites);
			?>
		</tbody>
	</table>
	<br>
	<div style="text-align: center;">
		<input value="Sauver" name="button_Sauver" type="submit">
		<input type="button" value="Annuler" name="button_annuler" onclick="window.location.href='recette_visualisation.php?idRecette=<?php echo $editionRecette->recette->id ?>'"></input>
	</div>
</form>

<?php 
  include('piedDePage.php');
?>
