    <?php
    include_once('../../modele/aff_parcours/requetes.php');

    //fonction qui permet de recupèrer la nom de la formation grace à son id
    function getNomForm($idForm){
        $req = nomForm($idForm);
        $donnee = $req->fetch();
        //le stock dans la session active
        $_SESSION['nom_Form'] = $donnee['nom_Form'];
    }

    function chargeListe(){

        $listeModules = createListeModules($_SESSION['idForm']);
        //recupération de la requete pour connaitre la liste des modules et de leurs id
        //traitement du tableau
        $deb = true;
        $i = 1;
        echo '<table id="details">';
        //tant il y a des modules à lire
        while ($module = $listeModules->fetch()){
            //si debut de ligne on commence par la balise <tr> et on passe deb en false
            if ($deb == true){
                echo'<tr>';
                $deb = false;
            }
            //on crée les td du tableau et on y met les liens(<a>)
            //on rajoute un event onclick qui sera capter au click du lien en javascript (cf aff_parours.js)
            // et on incrémente (max par ligne = 6 colonnes)
            echo '<td id="detail'.$module['idModules'].'"><a href="#" name="module" id="'.$module['idModules'].'" onclick="select_Det(this)">'.$module['Nom_mod'].'</a></td>';
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
        //fin creation du select
        //debut création de l'affichage des modules
        //chargeModules($idTheme);
        
    }

    
    
    

    

    
    



