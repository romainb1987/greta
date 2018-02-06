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
    //en fonction de tab charge le nom de la table demandée
    $bdd = getBdd();
    $sql = 'SELECT '. $champs. ' FROM '. $tab;
    $req = $bdd->prepare($sql);
    $req->execute();
    return $req;
}

function insertData($nom,$desc,$comp,$matiere,$theme){
    //retrouve l'id de competence avec le nom
    $bdd = getBdd();
    $req = $bdd->prepare('SELECT idCompetence FROM competence where Nom_Comp = ?');
    $req->execute(array($comp));
    $donnee = $req->fetch();
    $comp = $donnee['idCompetence'];
    $req->closeCursor();
    //retrouve l'id de matiere
    $req = $bdd->prepare('SELECT idMatiere FROM matiere where Nom_matiere = ?');
    $req->execute(array($matiere));
    $donnee = $req->fetch();
    $matiere = $donnee['idMatiere'];
    $req->closeCursor();
    //retrouve l'id du theme
    $req = $bdd->prepare('SELECT idTheme FROM theme where Nom_theme = ?');
    $req->execute(array($theme));
    $donnee = $req->fetch();
    $theme = $donnee['idTheme'];
    $req->closeCursor();


    //execute l'insertion du nouveau module
    $req = $bdd->prepare('INSERT INTO modules(idCompetence, idMatiere, idTheme,Nom_mod, descript_mod) VALUES (:idCompetence, :idMatiere, :idTheme, :Nom_mod, :desc_mod) ');
    $req->execute(array(
            'idCompetence' => $comp,
            'idMatiere' => $matiere,
            'idTheme' => $theme,
            'Nom_mod' => $nom,
            'desc_mod' => $desc
    ));
    $req->closeCursor();

    $req = $bdd->prepare('SELECT * FROM modules WHERE Nom_mod = ?');
    $req->execute(array($nom));

    return $req;

}