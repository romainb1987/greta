<?php
session_start();
    include_once('../../modele/detail/requetes.php');

function chargeListe(){
    //creation tableau des element a inserer dans le select
    $tab = array(
        'Nom_theme' => 'theme'
    );
    //pour chaque element
    foreach ($tab as $cle => $element) {

        //recueration de la liste de ces elements
        $req = createListe($cle,$element);
        //creation de la liste deroulante
        echo '<label for="'.$element.'">'.$element.' : </label>
                </br><select id="'.$element.'" name="'.$cle.'" type="text">';
        //pour chaque elements retournés on insere un option en plus
        while ($donnee = $req->fetch()) {
            echo '<option value="' . $donnee[$cle] . '">' . $donnee[$cle]. '</option>';
            echo '<p>'.$donnee['cle'].'</p>';
        }
        echo '</select></br>';
    }
}

//on verifie l'integrités des informations
if (isset($_POST['nom_detail']) && isset($_POST['desc_detail'])&& isset($_POST['Nom_theme'])){
    $_POST['nom_detail'] = htmlspecialchars($_POST['nom_detail'] );
    $_POST['desc_detail'] = htmlspecialchars($_POST['desc_detail']);
    
    if (preg_match('#^(.){2,}$#',$_POST['nom_detail'])){
        
        if (preg_match('#^(.){5,}$#',$_POST['desc_detail'])){
            //si tout es valide on insert les données
            insertData($_POST['nom_detail'],$_POST['desc_detail'],$_POST['Nom_theme']);
            header('location: ../../index.php');
        }else{
            header('location:../../vue/detail/index.php');
        }
            
    }else{
        header('location: ../../vue/detail/index.php');
    }
}



