
    <?php
    session_start();
    include_once('../../modele/formation/requetes.php');

    function chargeListe(){
        //enregistrement des intitulée et des noms des tables sous forme tableau associatifs
        $tab = array(
            'Nom_adminparc' => 'admin_parcours',
            'Nom_typeForm' => 'type_formation'
        );
            //pour chacun d'entre eux
            foreach ($tab as $cle => $element) {
                //definition du titre
                if ($element === 'admin_parcours'){
                    $title = 'administrateur du parcours';
                }else{
                    $title = 'typologie de formation';
                }
                //chargement de la liste en fonction de l'element du tableau en cours
                $req = createListe($cle,$element);
                //creation label select et option
                echo '<label for="'.$element.'">'.$title.' : </label>
                </br><select id="'.$element.'" name="'.$cle.'" type="text">';

            while ($donnee = $req->fetch()) {
                echo '<option value="' . $donnee[$cle] . '">' . $donnee[$cle]. '</option>';
                echo '<p>'.$donnee['cle'].'</p>';
            }
            echo '</select></br>';
        }   
    }


// a chaque passage verification des information saisies (ce n'est qu'une premisse et cela doit etre amelioré sur l'ensemble du document)

if (isset($_POST['Nom_adminparc'])){

    if (isset($_POST['Nom_typeForm'])){

        if (isset($_POST['nom_form'])){
            $_SESSION['nom_form'] = $_POST['nom_form'];
            if (isset($_POST['desc_form'])){


                    $_POST['nom_form'] = htmlspecialchars($_POST['nom_form']);
                    $_POST['desc_form'] = htmlspecialchars($_POST['desc_form']);

                    if (preg_match('#^(.){2,}$#', $_POST['nom_form'])) {

                        if (preg_match('#^(.){5,}$#', $_POST['desc_form'])) {
                            //si toutes les informations sont correctes insertion des données dans la BDD 
                            $idformation = insertData($_POST['nom_form'], $_POST['desc_form'], $_POST['Nom_typeForm'], $_POST['Nom_adminparc']);
                            //et enregistrement de la formation crée dans la session
                            $_SESSION['idformation']= $idformation;
                            echo 'le numero de formation est : '.$_SESSION['idformation'];
                            //redirection fin formation
                            header('location: ../../vue/formation/fin_formation.php');

                        }
                    }


            }
        }
    }
}

    
    
    
    



