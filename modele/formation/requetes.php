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
function createListe($champs, $tab)
{
    //creation d'une liste en fonction des table demandées
    $bdd = getBdd();
    $sql = 'SELECT ' . $champs . ' FROM ' . $tab;
    $req = $bdd->prepare($sql);
    $req->execute();
    return $req;
}


function insertData($nom,$desc,$type,$admin){
    //recuperation du numero d'admin grace au nom
    $bdd = getBdd();
    $req = $bdd->prepare('SELECT idAdmin_parcours FROM admin_parcours where Nom_adminparc = ?');
    $req->execute(array($admin));
    $donnee = $req->fetch();
    $admin = $donnee['idAdmin_parcours'];
    $req->closeCursor();
    
    //recuperation du numero de type formation
    $req = $bdd->prepare('SELECT idType_Form FROM type_formation where Nom_typeForm = ?');
    $req->execute(array($type));
    $donnee = $req->fetch();
    $type = $donnee['idType_Form'];
    $req->closeCursor();

    //insertion des données dans la table formation
    $req = $bdd->prepare('INSERT INTO formation(idType_Form, idAdmin_parcours, Nom_Form, desc_Form) VALUES (:idType, :idAdmin, :Nom, :desc)');
    $req->execute(array(
        'idType' => $type,
        'idAdmin' => $admin,
        'Nom' => $nom,
        'desc' => $desc
    ));
    $req->closeCursor();
    //recuperation de l'id formation grace a son nom <<>> attention a revoir car si doublon de nom il y aura des problemes
    $req = $bdd->prepare('SELECT idFormation FROM formation where Nom_Form = ?');
    $req->execute(array($nom));
    $donnee = $req->fetch();
    $idformation = $donnee['idFormation'];
    $req->closeCursor();

    return $idformation;
}