
<?php 
include('enteteDePage.php');
include_once("identification_action.php");
?>

<form id="formulaire_identification" name="formulaire_identification" action="identification_vue.php" METHOD="post">

<h1>Identification de l'utilisateur</h1>
<br>

<?php

if(isset($_SESSION['connecte'])){
  if ($_SESSION['connecte'] === false){

    if (isset($_SESSION['nombreEssais'])){
?>


<br>
   <table border="0" width="400" align="center">
    <tr>
      <td style="color: rgb(204, 0, 0); text-decoration: underline;">Utilisateur inconnu ou mot de passe erroné.</td>
    </tr>
    <tr>
      <td style="color: rgb(204, 0, 0);">Nombre de tentative(s) : <?php echo $_SESSION['nombreEssais']; ?>.</td>
    </tr>
   </table>

<?php
    }
  }
  else
    header('Location: recette_visualisation.php');
}
?>

<br>
   <table border="0" width="400" align="center">
    <tr>
     <td width="200"><b>Votre login</b></td>
     <td width="200">
      <input type="text" name="login">
     </td>
    </tr>
    <tr>
     <td width="200"><b>Votre mot de passe<b></td>
     <td width="200">
      <input type="password" name="password">
     </td>
    </tr>
    <tr>
     <td colspan="2">
      <input type="submit" name="button_Connexion" value="Connexion">
     </td>
    </tr>
   </table>
</form>

<?php 
  include('piedDePage.php');
 ?>
