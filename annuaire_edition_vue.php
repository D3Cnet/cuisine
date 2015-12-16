<?php
include_once("annuaire_edition_action.php");
include('enteteDePage.php');
?>

<form id="formulaire_editionAnnuaire" name="formulaire_editionAnnuaire" action="annuaire_edition_vue.php" METHOD="post">

<h1>Rédiger une fiche</h1>
<br>

<script>
	$(function() {
		$( "#accordion" ).accordion();
	});
</script>



<div class="demo">

<div id="accordion">
	<h3><a href="#">Domicile</a></h3>
	<div>
		<p>
<table style="text-align: left; width: 100%; height: 40px;" border="0" cellpadding="2" cellspacing="2">
<tbody>
	<tr>
		<td>civilite :</td>
		<td><input maxlength="200" name="civilite" id="civilite" value="<?php echo $editionAnnuaire->annuaire->civilite ?>"></td>
		
	</tr>
	<tr>
		<td>nom :</td>
		<td><input maxlength="200" name="nom" id="nom" value="<?php echo $editionAnnuaire->annuaire->nom ?>"></td>
		
	</tr>
	<tr>
		<td>prenom :</td>
		<td><input maxlength="200" name="prenom" id="prenom" value="<?php echo $editionAnnuaire->annuaire->prenom ?>"></td>
		
	</tr>
	<tr>
		<td>Adresse :</td>
		<td><input maxlength="200" name="adresse1" id="adresse1" value="<?php echo $editionAnnuaire->annuaire->adresse1 ?>"></td>
		
	</tr>
	<tr>
		<td></td>
		<td><input maxlength="200" name="adresse2" id="adresse2" value="<?php echo $editionAnnuaire->annuaire->adresse2 ?>"></td>
	</tr>
	<tr>
		<td>codepostal :</td>
		<td><input maxlength="200" name="codepostal" id="codepostal" value="<?php echo $editionAnnuaire->annuaire->codepostal ?>"></td>
	</tr>
	<tr>
		<td>ville :</td>
		<td><input maxlength="200" name="ville" id="ville" value="<?php echo $editionAnnuaire->annuaire->ville ?>"></td>
	</tr>
	<tr>
		<td>departement</td>
		<td><input maxlength="200" name="departement" id="departement" value="<?php echo $editionAnnuaire->annuaire->departement ?>"></td>
	</tr>
	<tr>
		<td>pays</td>
		<td><input maxlength="200" name="pays" id="pays" value="<?php echo $editionAnnuaire->annuaire->pays ?>"></td>
	</tr>
	<tr>
		<td>sexe</td>
		<td><input maxlength="200" name="sexe" id="sexe" value="<?php echo $editionAnnuaire->annuaire->sexe ?>"></td>
	</tr>
	<tr>
		<td>categorie</td>
		<td><input maxlength="200" name="categorie" id="categorie" value="<?php echo $editionAnnuaire->annuaire->categorie ?>"></td>
	</tr>
	<tr>
	<tr>
		<td>dateanniversaire</td>
		<td><input maxlength="200" name="dateanniversaire" id="dateanniversaire" value="<?php echo $editionAnnuaire->annuaire->dateanniversaire ?>"></td>
	</tr>
	<tr>
		<td>telephone</td>
		<td><input maxlength="200" name="telephone" id="telephone" value="<?php echo $editionAnnuaire->annuaire->telephone ?>"></td>
	</tr>
	<tr>
		<td>fax</td>
		<td><input maxlength="200" name="fax" id="fax" value="<?php echo $editionAnnuaire->annuaire->fax ?>"></td>
	</tr>
	<tr>
		<td>mobile</td>
		<td><input maxlength="200" name="mobile" id="mobile" value="<?php echo $editionAnnuaire->annuaire->mobile ?>"></td>
	</tr>
	<tr>
		<td>email</td>
		<td><input maxlength="200" name="email" id="email" value="<?php echo $editionAnnuaire->annuaire->email ?>"></td>
	</tr>
	<tr>
		<td>web</td>
		<td><input maxlength="200" name="web" id="web" value="<?php echo $editionAnnuaire->annuaire->web ?>"></td>
	</tr>
	<tr>
		<td>commentaire</td>
		<td><input maxlength="200" name="commentaire" id="commentaire" value="<?php echo $editionAnnuaire->annuaire->commentaire ?>"></td>
	</tr>
</tbody>
</table>
		</p>
	</div>
	<h3><a href="#">Bureau</a></h3>
	<div>
		<p>
<table style="text-align: left; width: 100%; height: 40px;" border="0" cellpadding="2" cellspacing="2">
<tbody>
	<tr>
		<td>socnom</td>
		<td><input maxlength="200" name="socnom" id="socnom" value="<?php echo $editionAnnuaire->annuaire->socnom ?>"></td>
	</tr>
	<tr>
		<td>Adresse :</td>
		<td><input maxlength="200" name="socadresse1" id="socadresse1" value="<?php echo $editionAnnuaire->annuaire->socadresse1 ?>"></td>
	</tr>
	<tr>
		<td></td>
		<td><input maxlength="200" name="socadresse2" id="socadresse2" value="<?php echo $editionAnnuaire->annuaire->socadresse2 ?>"></td>
	</tr>
	<tr>
		<td></td>
		<td><input maxlength="200" name="soccodepostal" id="soccodepostal" value="<?php echo $editionAnnuaire->annuaire->soccodepostal ?>"></td>
	</tr>
	<tr>
		<td></td>
		<td><input maxlength="200" name="socville" id="socville" value="<?php echo $editionAnnuaire->annuaire->socville ?>"></td>
	</tr>
	<tr>
		<td></td>
		<td><input maxlength="200" name="socdepartement" id="socdepartement" value="<?php echo $editionAnnuaire->annuaire->socdepartement ?>"></td>
	</tr>
	<tr>
		<td>socpays</td>
		<td><input maxlength="200" name="socpays" id="socpays" value="<?php echo $editionAnnuaire->annuaire->socpays ?>"></td>
	</tr>
	<tr>
		<td>soctelephone</td>
		<td><input maxlength="200" name="soctelephone" id="soctelephone" value="<?php echo $editionAnnuaire->annuaire->soctelephone ?>"></td>
	</tr>
	<tr>
		<td>socfax</td>
		<td><input maxlength="200" name="socfax" id="socfax" value="<?php echo $editionAnnuaire->annuaire->socfax ?>"></td>
	</tr>
	<tr>
		<td>socmobile</td>
		<td><input maxlength="200" name="socmobile" id="socmobile" value="<?php echo $editionAnnuaire->annuaire->socmobile ?>"></td>
	</tr>
	<tr>
		<td>socemail</td>
		<td><input maxlength="200" name="socemail" id="socemail" value="<?php echo $editionAnnuaire->annuaire->socemail ?>"></td>
	</tr>
	<tr>
		<td>socweb</td>
		<td><input maxlength="200" name="socweb" id="socweb" value="<?php echo $editionAnnuaire->annuaire->socweb ?>"></td>
	</tr>
	<tr>
		<td>soccommentaire</td>
		<td><input maxlength="200" name="soccommentaire" id="soccommentaire" value="<?php echo nl2br($editionAnnuaire->annuaire->soccommentaire) ?>"></td>
	</tr>
</tbody>
</table>
		</p>
	</div>
	<h3><a href="#">Mémo et évènement</a></h3>
	<div>
		<p>
<table style="text-align: left; width: 100%; height: 40px;" border="0" cellpadding="2" cellspacing="2">
<tbody>
	<tr>
		<td>dateanniversaire</td>
		<td><input maxlength="200" name="dateanniversaire" id="dateanniversaire" value="<?php echo $editionAnnuaire->annuaire->dateanniversaire ?>"></td>
	</tr>
	<tr>
		<td>datefete</td>
		<td><input maxlength="200" name="datefete" id="datefete" value="<?php echo $editionAnnuaire->annuaire->datefete ?>"></td>
	</tr>
	<tr>
		<td>commentaire</td>
		<td><input maxlength="200" name="commentaire" id="commentaire" value="<?php echo $editionAnnuaire->annuaire->commentaire ?>"></td>
	</tr>
</tbody>
</table>
		</p>
	</div>
	<h3><a href="#">Photo</a></h3>
	<div>
		<p>
		Cras dictum. Pellentesque habitant morbi tristique senectus et netus
		et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in
		faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia
		mauris vel est.
		</p>
		<p>
		Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus.
		Class aptent taciti sociosqu ad litora torquent per conubia nostra, per
		inceptos himenaeos.
		</p>
	</div>
	<h3><a href="#">Lien avec les autres</a></h3>
	<div>
		<p>
		Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus.
		Class aptent taciti sociosqu ad litora torquent per conubia nostra, per
		inceptos himenaeos.
		</p>
	</div>
	
</div>

</div><!-- End demo -->



</form>

<?php 
  include('piedDePage.php');
 ?>
