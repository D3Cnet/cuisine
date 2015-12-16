
<?php 
include_once("recette_recherche_action.php");
include('enteteDePage.php');
include('recette_recherche.js');
?>

<form id="formulaire_rechercheRecette" name="formulaire_rechercherRecette" action="recette_recherche_vue.php" METHOD="post">

  <h1>Rechercher une recette</h1>
  <br>
<div>
	<table class="contenuForm" style="white-space:nowrap;">
		<tr>
			<td class="contenu right" style="text-align: left; vertical-align: top;">Critère de recherche :</td>
			<td style="text-align: left; vertical-align: top;">
			    <?php if (isset($_POST['critere'])){ ?>
					<input maxlength="200" name="critere" id="critere" value="<?php echo $_POST['critere'] ?>"></input>
				<?php } else { ?>
					<input maxlength="200" name="critere" id="critere" value=""></input>
				<?php } ?>
				<input type="submit" value="Rechercher" name="buttonRechercher"></input>
			</td>
		</tr>
		<tr>
			<td class="contenu right" style="text-align: left; vertical-align: top;">Rechercher dans :</td>
			<td id="table_checkbox" style="text-align: left; vertical-align: top;">
				<?php if (isset($_POST['checkLibelle']) || (count($_POST) == 0)){ ?>
					<input type="checkbox" checked="checked" name="checkLibelle" id="check_titre" value="check_titre";></input><label>&nbsp;Nom de recette</label>			
				<?php } else { ?>
					<input type="checkbox" name="checkLibelle" id="check_titre" value="check_titre";></input><label>&nbsp;Nom de recette</label>			
				<?php } ?>

				<?php if (isset($_POST['checkIngredient']) || (count($_POST) == 0)){ ?>
					<input type="checkbox" checked="checked" name="checkIngredient" id="check_ingredient" value="check_ingredient";></input><label>&nbsp;Ingrédients</label>			
				<?php } else { ?>
					<input type="checkbox" name="checkIngredient" id="check_ingredient" value="check_ingredient";></input><label>&nbsp;Ingrédients</label>			
				<?php } ?>

				<?php if (isset($_POST['checkDescription']) || (count($_POST) == 0)){ ?>
					<input type="checkbox" checked="checked" name="checkDescription" id="check_description" value="check_description";></input><label>&nbsp;Description</label>
				<?php } else { ?>
					<input type="checkbox" name="checkDescription" id="check_description" value="check_description";></input><label>&nbsp;Description</label>
				<?php } ?>
			</td>
		</tr>
		
		
		
		
				<tr>
					<td style="width: 180px;"></td>
					<td>Difficulté :&nbsp;
						<select name="difficulte" id="difficulte" style="width: 50px;">
							<?php
								echo $rechercheRecette->addOptionPourSelect('difficulte');
							?>					
						</select>
						&nbsp;Appréciation :&nbsp;
						<select name="appreciation" id="appreciation" style="width: 50px;">
							<?php
								echo $rechercheRecette->addOptionPourSelect('appreciation');
							?>					
						</select>
					</td>
				</tr>
		
		
		
		
		
		
		
		
		
		
	</table>
</div>


<?php
if(isset($_POST['buttonRechercher'])){
?>
<br />

<label>Fiche(s) trouvée(s) :&nbsp;</label><br />

<?php echo $rechercheRecette->afficherResultatRecherche(); ?>

<br />
<?php
}
?>

</form>

<?php 
  include('piedDePage.php');
 ?>
