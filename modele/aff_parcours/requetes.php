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

function createListeModules($idForm){
        //creation liste de tous les themes
        //1>recherche de l'id du theme selectionné
        $bdd = getBdd();
        $req = $bdd->prepare('SELECT * FROM modules WHERE idModules IN (SELECT idModules FROM contenu_parcours WHERE IdFormation = ?)');
        $req->execute(array($idForm));

        return $req;
}
function NomForm($idForm){
    
    //retourne le nom de la formation
    $bdd = getBdd();
    $req = $bdd->prepare('SELECT nom_Form FROM formation WHERE idFormation = ?');
    $req->execute(array($idForm));
    return $req;
}
function getDetail($idModule){
    //recuperation de la liste des details en fonction du module parametré
    $bdd = getBdd();
    $req = $bdd->prepare('SELECT id_Detail, Nom_Detail FROM detail WHERE det_ref = 1 AND id_Detail IN (SELECT id_Detail FROM detail_module WHERE idModules = ?)');
    $req->execute(array($idModule));

        return $req;
}
function createParcours($idForm,$idStag){
    //creation du parcours grace au choix de la formation et a la creation du stagiaire
    $bdd = getBdd();
    $req = $bdd->prepare('INSERT INTO parcours(idFormation, idStagiaire) VALUES ( :idForm,:idStag)');
    $req->execute(array(

        'idForm' => $idForm,
        'idStag' => $idStag
    ));
    
    $req->closeCursor();
    $req = $bdd->prepare('SELECT idParcours FROM parcours WHERE idStagiaire = ?');
    $req->execute(array($idStag));
    $Parcours = $req->fetch();
    $idParcours = $Parcours['idParcours'];
    return $idParcours;
}
function cloneMod($idmodule, $idParc){
    //chargement de toutes les info sur le module
   $modules = chargeModule($idmodule);
    //selection obligatoire de la premiere ligne
    $module = $modules->fetch();
    
    $bdd = getBdd();
    //preparation de la requete utilisant une fonction stockée sur la base
    $req = $bdd->prepare('SELECT gretatest.CreateModule(:idCompetence,:idMatiere,:idTheme,:idFormateurs_suivi,:idFormateurs_createur,:idParcours,:Nom_mod,:descript_mod,:etat_mod,:heure_mod,:code_module) AS Pidmodule ');
    $req->bindParam(':idCompetence', $module['idCompetence'], PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
    $req->bindParam(':idMatiere', $module['idMatiere'], PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
    $req->bindParam(':idTheme', $module['idTheme'], PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
    $req->bindParam(':idFormateurs_suivi', $module['idFormateurs_suivi'], PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
    $req->bindParam(':idFormateurs_createur', $module['idFormateurs_createur'], PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
    $req->bindParam(':idParcours', $idParc, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
    $req->bindParam(':Nom_mod',$module['Nom_mod'], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);
    $req->bindParam(':descript_mod', $module['descript_mod'], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);
    $req->bindParam(':etat_mod', $module['etat_mod'], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);
    $req->bindParam(':heure_mod', $module['heure_mod'] , PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
    $req->bindParam(':code_module', $module['code_module'], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);
    $req->execute();


    if ($res = $req->fetch(PDO::FETCH_ASSOC)){
        //si fonction a bien fonctionnée alors on retrouve ici l'id du module clone
        $idModClone = $res['Pidmodule'];
    }
    return $idModClone;
}
function chargeModule($idModule){
    //chargement de toutes les info sur le module
    $bdd = getBdd();
    $req = $bdd->prepare('SELECT * FROM modules WHERE idModules = ?');
    $req->execute(array($idModule));
    return $req;
}

function cloneDet($idDetail,$idModule,$idModClone){
    //chargement de toutes les info sur le module
    $details =  chargeDetail($idDetail);
    $detail = $details->fetch();

    $bdd = getBdd();
    //preparation de la requete utilisant une fonction stockée sur la base
    $req = $bdd->prepare('SELECT gretatest.CreateDetail(:Pcode_Detail,:PNom_Detail,:Pdescript,:Pobjectif_Detail,:Pheure_Detail,:Pevaluable,:PidDetailParent,:PidTheme) as PidDetail');
    $req->bindParam(':Pcode_Detail', $detail['code_Detail'], PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
    $req->bindParam(':PNom_Detail', $detail['Nom_Detail'], PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
    $req->bindParam(':Pdescript', $detail['descript_Detail'], PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
    $req->bindParam(':Pobjectif_Detail', $detail['objectif_Detail'], PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
    $req->bindParam(':Pheure_Detail', $detail['heure_Detail'], PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
    $req->bindParam(':Pevaluable', $detail['evaluable'], PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
    $req->bindParam(':PidDetailParent', $idModule, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);
    $req->bindParam(':PidTheme', $detail['idTheme'], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);
    $req->execute();

    if ($res = $req->fetch(PDO::FETCH_ASSOC)){
        //si fonction a bien fonctionnée alors on retrouve ici l'id du detail clone
        $idDetClone = $res['PidDetail'];
    }
    //liaison du nouveau detail au nouveau module en cours
    aff_detClone($idModClone,$idDetClone);
}
function chargeDetail($idDetail){
    //chargement de toutes les info sur le module
    $bdd = getBdd();
    $req = $bdd->prepare('SELECT * FROM detail WHERE id_Detail = ?');
    $req->execute(array($idDetail));
    return $req;
}

function aff_detClone($idMod, $idDet){
    //liaison du nouveau detail au nouveau module en cours
    $bdd = getBdd();
    $req = $bdd->prepare('INSERT INTO detail_module(idModules, id_Detail) VALUES (?,?)');
    $req->execute(array($idMod,$idDet));

}
















