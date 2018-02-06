<?php
include_once ("../../modele/aff_module/requetes.php");
header("content-Type: text/xml");
//increment des modules
$i=0;
//tant que le module existe il insert l'affectation de ce module a la formation en cours'
while (isset($_POST['mod'.$i])) {

    $r = insereData($_POST['idform'],$_POST['mod'.$i]);
    $i++;

}
echo $r;






