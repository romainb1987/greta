    <?php
    include_once('../../modele/aff_module/requetes.php');
    

    function chargeListe(){

        $tab = 'theme';
        $champs = 'Nom_theme';

        $req = createListeTheme();
        //recupération de la requete pour connaitre la liste des themes et de leurs id
        //traitement du select
        echo '<label for="'.$tab.'">'.$tab.' : </label></br>
        <select id="'.$tab.'" name="'.$tab.'" type="text" onchange="request(this);">';
        //traitement des options du select avec les données recup
        // ajout d'un event onchange pour traiter le changement du theme envoie vers aff_modules.js
        $i = 0;
        while ($donnee = $req->fetch()) {
            //recupération de l'id du premier theme listé
            if ($i == 0){
                $idTheme = $donnee['idTheme'];
            }
            //creation des options du select avec en value = id et intitulé = nom du theme
            echo '<option value="' . $donnee['idTheme'] . '">' . $donnee[$champs]. '</option>';
            $i++;
        }
        echo '</select></br></br>';
        //fin creation du select
        //debut création de l'affichage des modules
        chargeModules($idTheme);
        
    }
    function chargeModules($idTheme){

        echo '<label >Selectionnez les modules desirés</label></br></br>';
        //recup des modules pour le premier theme initilisé
        $listeModules = getModules($idTheme);
        $deb = true;
        $i = 1;
        echo '<table id="modules">';
        //tant il y a des éléments à lire
        while ($module = $listeModules->fetch()){
            //si debut de ligne on commence par la balise <tr> et on passe deb en false
            if ($deb == true){
                echo'<tr>';
                $deb = false;
            }
            //on crée les td du tableau et on y met les checkboxes et on incrémente (max par ligne = 6 colonnes)
            echo '<td><input type="checkbox" name="module" id="'.$module['idModules'].'">'.$module['Nom_mod'].'</td>';
            $i++;
            // ligne 6 -> saut de ligne on repart à 0 et on ferme le /tr deb devient a nouveau true
            if ($i%6 == 0){
                echo '</tr>';
                $deb = true;
            }
        }
        // si pas modulo de 6 le tr n'a pas été refermé alors on le ferme ici
        if ($i%6 != 0){
            echo '</tr>';
        }
        echo '</table>';

    }

if (isset($_POST['Nom_adminparc'])){

    if (isset($_POST['Nom_typeForm'])){

        if (isset($_POST['nom_form'])){

            if (isset($_POST['desc_form'])){


                    $_POST['nom_form'] = htmlspecialchars($_POST['nom_form']);
                    $_POST['desc_form'] = htmlspecialchars($_POST['desc_form']);
                //test des variables minimum lettre nom = 2 et mini pour desc = 5
                    if (preg_match('#^(.){2,}$#', $_POST['nom_form'])) {

                        if (preg_match('#^(.){5,}$#', $_POST['desc_form'])) {
                            //si tout bon (valeur existante, valeur rendu inoffencives et controlée pour quelles soient normée -> insertion DATA dans DB
                            insertData($_POST['nom_form'], $_POST['desc_form'], $_POST['Nom_typeForm'], $_POST['Nom_adminparc']);
                            // retour sur la page d'accueil
                            header('location: ../../index.php');

                        }
                    }


            }
        }
    }
}

    
    
    
    



