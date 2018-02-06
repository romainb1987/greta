<?php
session_start();
include_once ("../../modele/aff_parcours/requetes.php");
header("content-Type: text/xml");
$text = 'a';
//creation du parcours avec l'id de la formation selectionnée et l'id du stagiaire
$idParc = createParcours($_SESSION['idForm'],$_SESSION['id_Stag']);
ECHO $idParc;
// i est la position dans l'url recupèré de httprequest
$i=0;
$idmodule = '';
//tant qu'il y a des id module dans l'url
while (isset($_POST['mod'.$i])) {
    $text += ' b';
    // on recupère la valeur de l'id
    $idmodule = $_POST['mod'.$i];
    $text += ' c';
    //on clone le module et on recupère sont id de clone
    $idModClone = cloneMod($idmodule,$idParc);
    $text += ' d';

   //tant que l'id module est le même que l'id du module suivant et qu'il y a un module suivant
    while (isset($_POST['mod'.$i]) && $idmodule == $_POST['mod'.$i]){
        $text += ' e';
        //on recupère l'id du detail
        $idDetail = $_POST['det'.$i];
        $text += ' f';
        //on clone le detail et on recupère sont id
        $ideDetClone = cloneDet($idDetail, $idmodule,$idModClone);
        $text += ' g';
        //on passe au module et detail suivant (i incremantant les deux tableaux)
        $i++;
    }
}
echo ($text);






