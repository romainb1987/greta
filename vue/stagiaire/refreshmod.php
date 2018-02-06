<?php
include_once ("../../modele/stagiaire/requetes.php");

//construction ddu xml
echo"<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
echo"<list>";
//recuperation des formation par type de frmation
$req = getForm($_POST['idTForm']);

//creation de borne formation pour chaque formation 
while($donnee = $req->fetch()){
    echo "<formation id=\"".$donnee['idFormation']."\" name=\"".$donnee['nom_Form']."\" />";
}
echo "</list>";







