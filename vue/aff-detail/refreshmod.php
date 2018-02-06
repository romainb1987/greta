<?php
include_once ("../../modele/aff_module/requetes.php");
header("content-Type: text/xml");
echo"<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
echo"<list>";

$req = getModules($_POST['idTheme']);


while($donnee = $req->fetch()){
    echo "<module id=\"".$donnee['idModules']."\" name=\"".$donnee['Nom_mod']."\" />";
}
echo "</list>";







