<?php
function getBdd(){
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=gretatest;charset=utf8', 'root', '',
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (Exception $e) {
        die('Erreur : ' . $e);

    }
    return $bdd;
}

function typeForm(){
    $bdd = getBdd();

    $req = $bdd->query('select nom_typeForm from type_formation');

    return $req;
}