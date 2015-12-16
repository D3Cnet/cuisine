
<?php 
include_once("annuaire_visualisation_action.php");
include('enteteDePage.php');
?>

<form id="formulaire_visualiserAnnuaire" name="formulaire_visualiserAnnuaire" action="annuaire_visualisation_vue.php" METHOD="post">

<h1>Consulter une fiche</h1>
<br>

<script>
	$(function() {
		$( "#accordion" ).accordion();
	});
</script>



<table class="contenuForm" style="white-space:nowrap;">
	<tr>
		<td class="contenu right"><label for="nom_recherche">Nom de la personne :</label></td>
		<td>
			<select name="annuaire" id="annuaire">
				<?php
					if(count($_POST) == 0){
						if (isset($_GET['idAnnuaire'])){
							echo $visualisationAnnuaire->genererOptions($visualisationAnnuaire->listeAnnuaires, $visualisationAnnuaire->getLibelleAnnuaire($_GET['idAnnuaire']));
						} else 
						{
							echo $visualisationAnnuaire->genererOptions($visualisationAnnuaire->listeAnnuaires); 
						}
					}
					else
					{
						echo $visualisationAnnuaire->genererOptions($visualisationAnnuaire->listeAnnuaires, $visualisationAnnuaire->getLibelleAnnuaire($_POST['annuaire']));
					}
				?>
			</select>
			<input type="submit" value="Afficher" name="button_AfficherAnnuaire" onmousedown="document.forms['formulaire_visualiserAnnuaire'].target='_self';"></input>
			<?php
				if((count($_POST) <> 0) || (isset($_GET['idAnnaire']))){
			?>
  			<input type="button" value="Imprimer" name="button_Imprimer" onmousedown="document.forms['formulaire_visualiserAnnuaire'].target='Export_PDF';" onclick="window.location.href='annuaire_impression_fiche.php?idAnnuaire=<?php echo $visualisationAnnuaire->annuaire->idannuaire ?>'"></input>
  			<input type="button" value="Editer" name="button_EditerAnnuaire" onmousedown="document.forms['formulaire_visualiserAnnuaire'].target='_self';" onclick="window.location.href='annuaire_edition_vue.php?idAnnuaire=<?php echo $visualisationAnnuaire->annuaire->idannuaire ?>'"></input>
			<?php
				}
			?>
		</td>
	</tr>
	<tr>
  	<td style="height:20px"></td>
	</tr>
</table>

















<?php
if((isset($_POST['button_AfficherAnnuaire'])) || (isset($_GET['idAnnuaire']))){
// if(count($_POST) <> 0){
?>








<div class="demo">

<div id="accordion">
	<h3><a href="#">Domicile</a></h3>
	<div>
		<p>
<table style="text-align: left; width: 100%; height: 40px;" border="0" cellpadding="2" cellspacing="2">
<tbody>
	<tr>
		<td>Adresse :</td>
		<td><?php echo $visualisationAnnuaire->annuaire->adresse1; ?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo $visualisationAnnuaire->annuaire->adresse2; ?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo $visualisationAnnuaire->annuaire->codepostal; ?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo $visualisationAnnuaire->annuaire->ville; ?></td>
	</tr>
	<tr>
		<td>departement</td>
		<td><?php echo $visualisationAnnuaire->annuaire->departement; ?></td>
	</tr>
	<tr>
		<td>pays</td>
		<td><?php echo $visualisationAnnuaire->annuaire->pays; ?></td>
	</tr>
	<tr>
		<td>sexe</td>
		<td><?php echo $visualisationAnnuaire->annuaire->sexe; ?></td>
	</tr>
	<tr>
		<td>categorie</td>
		<td><?php echo $visualisationAnnuaire->annuaire->categorie; ?></td>
	</tr>
	<tr>
	<tr>
		<td>dateanniversaire</td>
		<td><?php echo $visualisationAnnuaire->annuaire->dateanniversaire; ?></td>
	</tr>
	<tr>
		<td>telephone</td>
		<td><?php echo $visualisationAnnuaire->annuaire->telephone; ?></td>
	</tr>
	<tr>
		<td>fax</td>
		<td><?php echo $visualisationAnnuaire->annuaire->fax; ?></td>
	</tr>
	<tr>
		<td>mobile</td>
		<td><?php echo $visualisationAnnuaire->annuaire->mobile; ?></td>
	</tr>
	<tr>
		<td>email</td>
		<td><?php echo $visualisationAnnuaire->annuaire->email; ?></td>
	</tr>
	<tr>
		<td>web</td>
		<td><?php echo $visualisationAnnuaire->annuaire->web; ?></td>
	</tr>
	<tr>
		<td>commentaire</td>
		<td><?php echo nl2br($visualisationAnnuaire->annuaire->commentaire); ?></td>
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
		<td><?php echo $visualisationAnnuaire->annuaire->socnom; ?></td>
	</tr>
	<tr>
		<td>Adresse :</td>
		<td><?php echo $visualisationAnnuaire->annuaire->socadresse1; ?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo $visualisationAnnuaire->annuaire->socadresse2; ?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo $visualisationAnnuaire->annuaire->soccodepostal; ?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo $visualisationAnnuaire->annuaire->socville; ?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo $visualisationAnnuaire->annuaire->socdepartement; ?></td>
	</tr>
	<tr>
		<td>socpays</td>
		<td><?php echo $visualisationAnnuaire->annuaire->socpays; ?></td>
	</tr>
	<tr>
		<td>soctelephone</td>
		<td><?php echo $visualisationAnnuaire->annuaire->soctelephone; ?></td>
	</tr>
	<tr>
		<td>socfax</td>
		<td><?php echo $visualisationAnnuaire->annuaire->socfax; ?></td>
	</tr>
	<tr>
		<td>socmobile</td>
		<td><?php echo $visualisationAnnuaire->annuaire->socmobile; ?></td>
	</tr>
	<tr>
		<td>socemail</td>
		<td><?php echo $visualisationAnnuaire->annuaire->socemail; ?></td>
	</tr>
	<tr>
		<td>socweb</td>
		<td><?php echo $visualisationAnnuaire->annuaire->socweb; ?></td>
	</tr>
	<tr>
		<td>soccommentaire</td>
		<td><?php echo nl2br($visualisationAnnuaire->annuaire->soccommentaire); ?></td>
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
		<td><?php echo $visualisationAnnuaire->annuaire->dateanniversaire; ?></td>
	</tr>
	<tr>
		<td>datefete</td>
		<td><?php echo $visualisationAnnuaire->annuaire->datefete; ?></td>
	</tr>
	<tr>
		<td>commentaire</td>
		<td><?php echo nl2br($visualisationAnnuaire->annuaire->commentaire); ?></td>
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









<br>
<big style="font-weight: bold; color: rgb(0, 0, 153);"><big><big><?php echo $visualisationAnnuaire->annuaire->civilite.' '.$visualisationAnnuaire->annuaire->nom.' '.$visualisationAnnuaire->annuaire->prenom; ?></big></big></big><br>
<br>
<table style="text-align: left; width: 100%; height: 40px;" border="0" cellpadding="2" cellspacing="2">
<tbody>
	<tr>
		<td>Adresse :</td>
		<td><?php echo $visualisationAnnuaire->annuaire->adresse1; ?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo $visualisationAnnuaire->annuaire->adresse2; ?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo $visualisationAnnuaire->annuaire->codepostal; ?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo $visualisationAnnuaire->annuaire->ville; ?></td>
	</tr>
	<tr>
		<td>departement</td>
		<td><?php echo $visualisationAnnuaire->annuaire->departement; ?></td>
	</tr>
	<tr>
		<td>pays</td>
		<td><?php echo $visualisationAnnuaire->annuaire->pays; ?></td>
	</tr>
	<tr>
		<td>sexe</td>
		<td><?php echo $visualisationAnnuaire->annuaire->sexe; ?></td>
	</tr>
	<tr>
		<td>categorie</td>
		<td><?php echo $visualisationAnnuaire->annuaire->categorie; ?></td>
	</tr>
	<tr>
		<td>telephone</td>
		<td><?php echo $visualisationAnnuaire->annuaire->telephone; ?></td>
	</tr>
	<tr>
		<td>fax</td>
		<td><?php echo $visualisationAnnuaire->annuaire->fax; ?></td>
	</tr>
	<tr>
		<td>mobile</td>
		<td><?php echo $visualisationAnnuaire->annuaire->mobile; ?></td>
	</tr>
	<tr>
		<td>email</td>
		<td><?php echo $visualisationAnnuaire->annuaire->email; ?></td>
	</tr>
	<tr>
		<td>web</td>
		<td><?php echo $visualisationAnnuaire->annuaire->web; ?></td>
	</tr>
	<tr>
		<td>dateanniversaire</td>
		<td><?php echo $visualisationAnnuaire->annuaire->dateanniversaire; ?></td>
	</tr>
	<tr>
		<td>datefete</td>
		<td><?php echo $visualisationAnnuaire->annuaire->datefete; ?></td>
	</tr>
	<tr>
		<td>commentaire</td>
		<td><?php echo nl2br($visualisationAnnuaire->annuaire->commentaire); ?></td>
	</tr>
	<tr>
		<td>socnom</td>
		<td><?php echo $visualisationAnnuaire->annuaire->socnom; ?></td>
	</tr>
	<tr>
		<td>Adresse :</td>
		<td><?php echo $visualisationAnnuaire->annuaire->socadresse1; ?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo $visualisationAnnuaire->annuaire->socadresse2; ?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo $visualisationAnnuaire->annuaire->soccodepostal; ?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo $visualisationAnnuaire->annuaire->socville; ?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo $visualisationAnnuaire->annuaire->socdepartement; ?></td>
	</tr>
	<tr>
		<td>socpays</td>
		<td><?php echo $visualisationAnnuaire->annuaire->socpays; ?></td>
	</tr>
	<tr>
		<td>soctelephone</td>
		<td><?php echo $visualisationAnnuaire->annuaire->soctelephone; ?></td>
	</tr>
	<tr>
		<td>socfax</td>
		<td><?php echo $visualisationAnnuaire->annuaire->socfax; ?></td>
	</tr>
	<tr>
		<td>socmobile</td>
		<td><?php echo $visualisationAnnuaire->annuaire->socmobile; ?></td>
	</tr>
	<tr>
		<td>socemail</td>
		<td><?php echo $visualisationAnnuaire->annuaire->socemail; ?></td>
	</tr>
	<tr>
		<td>socweb</td>
		<td><?php echo $visualisationAnnuaire->annuaire->socweb; ?></td>
	</tr>
	<tr>
		<td>commentaire</td>
		<td><?php echo nl2br($visualisationAnnuaire->annuaire->commentaire); ?></td>
	</tr>
</tbody>
</table>
<br>
<br>
<span style="font-weight: bold; text-decoration: underline;">Liens de relation</span><br>
<ul>
<?php echo $visualisationAnnuaire->LireRelations(); ?>
</ul>
<br>

<?php
}
?>

</form>

<?php 
  include('piedDePage.php');
 ?>
