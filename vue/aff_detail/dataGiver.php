<?php
include_once ("../../modele/aff_detail/requetes.php");
header("content-Type: text/xml");
//increment des details
$i=0;
//tant qu'il y a desdetails on les insert dans detail module
while (isset($_POST['det'.$i])) {

    $r = insereData($_POST['idMod'],$_POST['det'.$i]);
    $i++;

}
echo $r;






