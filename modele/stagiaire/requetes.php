<?php

function getBdd(){
// connexion BDD
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=gretatest;charset=utf8', 'root', '',
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (Exception $e) {
        die('Erreur : ' . $e);
    }
    return $bdd;
}

function createListeTypeForm(){
        //creation liste de tous les themes
        //1>recherche de l'id du theme selectionné
        $bdd = getBdd();
        $sql = 'SELECT * FROM type_formation';
        $req = $bdd->prepare($sql);
        $req->execute();
        return $req;

}
function insereData($nom,$prenom,$idForm){
    //insertion du nouveau stagiaire dans la base et recupération de son id
    $_SESSION['idForm'] = $idForm;
        $bdd = getBdd();
        $req = $bdd->prepare('INSERT INTO stagiaire (nom_stagiaire,prenom_stagiaire) VALUES (:nom,:prenom)');
       $req->execute(array(
             'nom' => $nom,
             'prenom' => $prenom
              ));
        $req->closeCursor();
    $req = $bdd->prepare('SELECT * FROM stagiaire WHERE nom_stagiaire = :nom and prenom_stagiaire = :prenom');
    $req->execute(array(
              'nom' => $nom,
              'prenom' => $prenom
    ));
    $donnee = $req->fetch();
    $_SESSION['nom_Stag'] = $nom;
    $_SESSION['prenom_Stag'] = $prenom;
    $_SESSION['id_Stag']= $donnee['idStagiaire'];
        $req->closeCursor();
    $r = 'nouveau stagiaire : '. $_SESSION['nom_Stag'].' '.$_SESSION['prenom_Stag'].' rajouter avec succés pour la formation '.$_SESSION['idForm'] ;
    return $r;
}

function idTheme($nomtheme){
    //recuperation de 'idtheme via son nom
    echo $nomtheme;
    $bdd = getBdd();
    $req = $bdd->prepare('SELECT idTheme FROM theme WHERE Nom_theme = ?');
    $req->execute(array($nomtheme));
    $theme = $req->fetch();
    $idtheme = $theme['idTheme'];
    echo $idtheme;
    return $idtheme;
}
function getForm($idTForm){
    //recuperation de la liste des modules en fonction d'un theme parametré
    $bdd = getBdd();
    $req = $bdd->prepare('SELECT * FROM formation WHERE idType_Form = ?');
    $req->execute(array($idTForm));
    return $req;

}