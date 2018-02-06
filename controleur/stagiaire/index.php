    <?php
    include_once('../../modele/stagiaire/requetes.php');
    

    function chargeListe(){

        $tab = 'type_formation';
        $champs = 'nom_typeForm';
        $req = createListeTypeForm();
        //recupération de la requete pour connaitre la liste des type de formation  et de leurs id
        //traitement du select
        echo '<label for="'.$tab.'">'.$tab.' : </label></br>
        <select id="'.$tab.'" name="'.$tab.'" type="text" onchange="request(this);">';
        //traitement des options du select avec les données recup
        // ajout d'un event onchange pour traiter le changement de type de formation envoie vers aff_modules.js pour charger les formations
        $i = 0;
        while ($donnee = $req->fetch()) {
            //recupération de l'id du premier type de formation listé
            //car il sera généreé sans l'aide du javascript à l'entrée sur le page
            if ($i == 0){
                $idTForm = $donnee['idType_Form'];
            }
            //creation des options du select avec en value = id et intitulé = nom du type formation
            echo '<option value="' . $donnee['idType_Form'] . '">' . $donnee[$champs]. '</option>';
            $i++;
        }
        echo '</select></br></br>';
        //fin creation du select
        //debut création de l'affichage des modules
        chargeForm($idTForm);
        
    }
    function chargeForm($idTForm){

        
        //recup des formations pour le premier type de formation initilisé
        $listeFormation = getForm($idTForm);
        $deb = true;
        $i = 1;
        echo '<table id="formations">';
        //tant il y a des éléments à lire
        while ($formation = $listeFormation->fetch()){
            //si debut de ligne on commence par la balise <tr> et on passe deb en false
            if ($deb == true){
                echo'<tr>';
                $deb = false;
            }
            //on crée les td du tableau et on y met les checkboxes et on incrémente (max par ligne = 6 colonnes)
            echo '<td><label>'.$formation['nom_Form'].'<input type="radio" name="formation" id="'.$formation['idFormation'].'"></label></td>';
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

//si besoin ci dessous code pour verifier coté serveur les informations envoyées a la baseutilisation de regex et de isset pour securiser l'ijection d'information
/*
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

    
    */
    
    



