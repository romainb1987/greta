<?php
session_start();
//recuperationdepuis la session des info pour faire insert des données stagiaire
$_SESSION['idForm'] = $_POST['idForm'];
$_SESSION['nom_Stag'] = $_POST['nom'];
$_SESSION['prenom_Stag'] = $_POST['prenom'];

include_once ("../../modele/stagiaire/requetes.php");
header("content-Type: text/xml");
//si ces données existent
if (isset($_POST['nom'])&& isset($_POST['prenom'])) {

    //envoie de la fonction d'insertion
    $r = insereData($_POST['nom'],$_POST['prenom'],$_POST['idForm']);

}
echo $r;






