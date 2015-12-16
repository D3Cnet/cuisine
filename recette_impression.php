<?php

function imprimerRecette($visualisationRecette){

  $pageEnCours = '
  <page backtop="15mm" backbottom="7mm" backleft="0mm" backright="0mm" style="font-size: 10pt">

  <page_header>
  	<table border="0" cellpadding="0" cellspacing="0"><col style="width: 15%"><col style="width: 85%">
  		<tr style="background-color:#FFFFFF; color:#363b29; font-size:24pt">
      	  	<td align="left"><img src="images/domonet.png" alt="domoNet" /></td>
      	  	<td align="left"><i>DomoNet</i></td>
      	</tr>
  	</table>
  </page_header>

  <page_footer>
  	<hr style="width: 100%; height: 1px;">
  	<table border="0" cellpadding="0" cellspacing="0"><col style="width: 50%"><col style="width: 50%">
  		<tr>
      	  	<td align="left">'.date('d/m/Y H:i:s').'</td>
  
        		<td align="right">page [[page_cu]]/[[page_nb]]</td>
      	</tr>
  	</table>
  </page_footer>';

  $pageEnCours .= '<br><br><big style="font-weight: bold; color: rgb(0, 0, 153);"><big><big>'.$visualisationRecette->recette->libelle.
  '</big></big></big><br><br><label>Classement :&nbsp;'.$visualisationRecette->LireClassement().
  '</label><br /><br /><table style="text-align: left; width: 100%; height: 40px;" border="0" cellpadding="2" cellspacing="2">'.
  '<tbody><tr><td>Difficulté : '.$visualisationRecette->getDifficulte().
  '</td><td>Appréciation : '.$visualisationRecette->getAppreciation().
  '</td></tr><tr><td>Temps de préparation : '.$visualisationRecette->recette->tempsPreparation.
  '</td><td>Temps de cuisson : '.$visualisationRecette->recette->tempsCuisson.
  '</td></tr></tbody></table><br><span style="font-weight: bold; text-decoration: underline;">Commentaire </span>: <br><br>'.nl2br($visualisationRecette->recette->commentaire).
  '<br><br><span style="font-weight: bold; text-decoration: underline;">Ingrédients</span><br><ul>'.$visualisationRecette->LireIngredients().
  '</ul><br><span style="text-decoration: underline; font-weight: bold;">Préparation</span><br><br>'.nl2br($visualisationRecette->recette->modePreparation).
  '</page>';

  require_once(dirname(__FILE__).'/librairies/html2pdf_v4.01/html2pdf.class.php');
  try
  	{
  	  $html2pdf = new HTML2PDF('P','A4', 'fr');
  		// $html2pdf = new HTML2PDF('P','A4', 'fr', false, 'ISO-8859-15', array(10, 10, 15, 10));
  		$html2pdf->pdf->SetDisplayMode('fullpage');
  		$html2pdf->writeHTML($pageEnCours);
//  		$html2pdf->Output('export.pdf');
        $html2pdf->Output($visualisationRecette->recette->libelle.'.pdf', 'D');
  	}
  	catch(HTML2PDF_exception $e) { echo $e; }	

}