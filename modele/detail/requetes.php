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

function createListe($champs, $tab){
        //creation de la liste des element dont on a besoin

        $bdd = getBdd();
        $sql = 'SELECT ' . $champs . ' FROM ' . $tab;
        $req = $bdd->prepare($sql);
        $req->execute();
        return $req;
}

function insertData($nom,$desc,$theme){
    //recuperationde l'id theme

    $bdd = getBdd();

    $req = $bdd->prepare('SELECT idTheme FROM theme where Nom_theme = ?');
    $req->execute(array($theme));
    $donnee = $req->fetch();
    $theme = $donnee['idTheme'];
    $req->closeCursor();

    //insertion du nouveau detail dans la bdd
    $req = $bdd->prepare('insert into detail (nom_detail, descript_detail,idTheme) values (:nom,:desc,:theme)');
    $req->execute(array(
            'nom' => $nom,
            'desc' => $desc,
            'theme' => $theme
    ));
    $req->closeCursor();
}