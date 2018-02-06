<?php
include_once ("../../modele/aff_module/requetes.php");
header("content-Type: text/xml");
$i=0;
$r = $_POST['mod'.$i];

while (isset($_POST['mod'.$i])) {

    $r .= insereData($_POST['idform'],$_POST['mod'.$i]);
    $i++;

}
echo $r;






