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

function createListeTheme(){
        //creation liste de tous les themes
        //1>recherche de l'id du theme selectionné
        $bdd = getBdd();
        $sql = 'SELECT idTheme,Nom_theme FROM theme';
        $req = $bdd->prepare($sql);
        $req->execute();
        return $req;

}
function insereData($idformation,$module){


        $bdd = getBdd();
        $req = $bdd->prepare('INSERT INTO contenu_parcours(idModules, idFormation) VALUES (:idmodule, :idformation)');
       $req->execute(array(
             'idmodule' => $module,
             'idformation' => $idformation,
              ));
        $req->closeCursor();
    $r = 'les modules ont bien été rajoutés';
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
function getModules($idTheme){
    //recuperation de la liste des modules en fonction d'un theme parametré
    $bdd = getBdd();
    $req = $bdd->prepare('SELECT idModules,Nom_mod FROM modules WHERE idTheme = ?');
    $req->execute(array($idTheme));
    return $req;

}