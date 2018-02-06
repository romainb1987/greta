<?php

include_once('../modele/requetes.php');

if(isset($_POST['pseudo'])){
$req = connexion();
$donnee = $req->fetch();

    if ($donnee['pseudo'] == $_POST['pseudo'])
    {
        if($donnee['mdp'] == $_POST['mdp'])
            {
            echo'connexion ok';
        }else
            {
            echo 'le mot de passe est erroné!';
            }

    }else
    {
        echo 'le pseudo n\'est pas bon';
    }

}else{
include_once('connexion/vue/index.php');
}