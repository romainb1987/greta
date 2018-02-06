    <?php
    session_start();
    include_once('../../modele/module/requetes.php');
    //charge les liste des competences matieres et theme du module
    function chargeListe(){
        //initialisation des variable champs et table dont nous aurons besoin
        $tab = array(
            'Nom_Comp' => 'competence',
            'Nom_Matiere' => 'matiere',
            'Nom_theme' => 'theme');
    


            //pour chacun des element du tableau
            foreach ($tab as $cle => $element) {
                //on recupere le liste des elements
                $req = createListe($cle,$element);

                //on crée un arborescence label/ select> option /p
                echo '<label for="'.$element.'">'.$element.' : </label>
                </br><select id="'.$element.'" name="'.$cle.'" type="text">';

            while ($donnee = $req->fetch()) {
                echo '<option value="' . $donnee[$cle] . '">' . $donnee[$cle]. '</option>';
                echo '<p>'.$donnee['cle'].'</p>';
            }
            echo '</select></br>';
        }   
    }


//a chaque tour on verifie la presence des informations et qu'elle sont conformes et securisées
if (isset($_POST['nom_module'])){

    if (isset($_POST['desc_mod'])){

        if (isset($_POST['Nom_Comp'])){

            if (isset($_POST['Nom_Matiere'])){

                if (isset($_POST['Nom_theme'])){

                    $_POST['nom_module'] = htmlspecialchars($_POST['nom_module']);
                    $_POST['desc_mod'] = htmlspecialchars($_POST['desc_mod']);

                    if (preg_match('#^(.){2,}$#', $_POST['nom_module'])) {

                        if (preg_match('#^(.){5,}$#', $_POST['desc_mod'])) {
                            //si tout est bon on insere les données etou recupere le nom et id module en cours dans la session
                            $req =insertData($_POST['nom_module'], $_POST['desc_mod'], $_POST['Nom_Comp'], $_POST['Nom_Matiere'], $_POST['Nom_theme']);
                            $donnees = $req->fetch();
                            $_SESSION['id_mod'] = $donnees['idModules'];
                            $_SESSION['nom_mod'] = $donnees['Nom_mod'];
                            //pui on redirige vers fin module
                            header('location: ../../vue/module/fin_crea_module.php');

                        }
                    }

                }
            }
        }
    }
}
    
    
    
    
    



