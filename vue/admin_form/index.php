<!DOCTYPE html>
<html>
<head>
    <title>Greta-Suivi pédagogique</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="application-name" content="suivi pedagogique Formation greta">

</head>
<body>


<div id="cadre">
    <form id="formation" method="post" action="../controleur/index.php" >
        </br>
        <label for="nom_form">Nom de la formation : </label>
        <input id="nom_form" name="nom_form" type="text">
        </br>
        <label for="desc_form">Description : </label>
        <input id="desc_form" name="desc_form" type="text">
        </br>
        <label for="type_form">Type de formation : </label>
        <select id="type_form" name="type_form" type="text">


            <?php

            include_once('../../modele/formation/requetes.php');

            $types = typeForm();
            echo '<p> bonjour'.$type['nom_typeForm'].'</p>';

            while($type = $types->fetch()){
                echo '<option value="'.$type['nom_typeForm'].'">'.$type['nom_typeForm'].'</option>';
            }
            
            ?>
            
            
        </select>

        </br>
        <label for="admin_form">Gestionnaire : </label>
        <input id="admin_form" name="admin_form" type="text">
        </br>
        <button id="submit" name="submit" type="submit" value="submit" >Enregistrer</button>
    </form>
</div>

<div>

</div>
</body>
</html>