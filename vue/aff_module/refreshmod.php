<?php
include_once ("../../modele/aff_module/requetes.php");
header("content-Type: text/xml");
//creation du xml
echo"<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
echo"<list>";
//recup la liste des modules par theme
$req = getModules($_POST['idTheme']);

//range les module dans des balise xml module avec id et nom du module
while($donnee = $req->fetch()){
    echo "<module id=\"".$donnee['idModules']."\" name=\"".$donnee['Nom_mod']."\" />";
}
echo "</list>";







