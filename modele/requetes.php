<?php

function connexion(){
    $bdd = getBdd();
    
$req = $bdd->prepare('select * from membre where pseudo = :pseudo');
    $req->execute(array('pseudo' => $_POST['pseudo']));

return $req;
}

function getBdd(){
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', '',
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (Exception $e) {
        die('Erreur : ' . $e);

    }
    return $bdd;
}

function inscription()
{
//verif
    $_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);
    $_POST['nom'] = htmlspecialchars($_POST['nom']);
    $_POST['prenom'] = htmlspecialchars($_POST['prneom']);
    $_POST['mail'] = htmlspecialchars($_POST['mail']);
    $_POST['mdp'] = sha1(htmlspecialchars($_POST['mdp'] ));


if (isset($_POST['pseudo']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['mail']) && isset($_POST['mdp'])) {
    if(preg_match('#^[a-z0-9.+_@*/ -]+$#si', $_POST['pseudo'])) {
        if (preg_match('#^[[:alpha:] -]+$#si', $_POST['nom'])) {
            if(preg_match('#^[[:alpha:] -]+$#si', $_POST['prenom'])) {
                if(preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z0-9._-]{2,4}$#si', $_POST['mail'])) {
                    $req = $bdd->prepare('select idmembre from membre where pseudo = ?');
                    $req->execute($_POST['pseudo']);

                    if(isset($req['idmembre'])){
                        echo 'pseudo déjà éxitant';
                    }else{
                        $req->closeCursor();
                        $req = $bdd->prepare('insert into membre(nommembre, prenommembre, mailmembre, pseudo, mdp, date_inscr) values (:nom, :prenom, :mail, :pseudo, :mdp, NOW())');
                        $req->execute(array(
                            'nom' => $_POST['nom'],
                            'prenom' => $_POST['prenom'],
                            'mail' => $_POST['mail'],
                            'pseudo' => $_POST['pseudo'],
                            'mdp' => $_POST['mdp']
                        ));
                        $req->closeCursor();

                    }



                }else{
                    echo'mail incorrecte';
                }
            }else{
                echo 'merci de renseigner un prénom';
            }

        }else{
            echo' merci de renseigner un nom';
        }
    }else{
        echo'merci de renseigner un pseudo';
    }

}else{
    echo 'un des champs n\'a pas été remplis';

}








}
