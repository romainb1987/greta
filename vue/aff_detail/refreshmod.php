<?php
include_once ("../../modele/aff_detail/requetes.php");
header("content-Type: text/xml");
//creation du xml
echo"<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
echo"<list>";
//recuperation des detail par theme
$req = getDetail($_POST['idTheme']);

//pour chaque detail on met son id et son nom dans une balise xml detail
while($donnee = $req->fetch()){
    echo "<detail id=\"".$donnee['id_Detail']."\" name=\"".$donnee['Nom_detail']."\" />";
}
echo "</list>";







