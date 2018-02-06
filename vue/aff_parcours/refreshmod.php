<?php
include_once ("../../modele/aff_parcours/requetes.php");
header("content-Type: text/xml");
//progrmmation de la reponse xml
echo"<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
echo"<list>";
//recuperation des details du module cliqué
$req = getDetail($_POST['idModule']);
//mise en place de balise XML <module> 
echo "<module id=\"".$_POST['idModule']."\">";
$i = 0;
//tant que il y a des details 
while($donnee = $req->fetch()){
    //creation d'un sous element detail avec id et nom 
    echo "<detail id=\"".$donnee['id_Detail']."\" name=\"".$donnee['Nom_Detail']."\" />";
        if ($donnee['id_Detail']== '' && $i = 0){
        //si pas de detail juste une seule balise avec id et nom ''vide''
        echo "<detail id=\"vide\" name=\"vide\" />";
    }
    $i++;
}
echo "</module>";
echo "</list>";







