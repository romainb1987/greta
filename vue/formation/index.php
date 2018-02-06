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
    <form id="formation" method="post" action="../../controleur/formation/index.php" >
        </br>
        <label for="nom_form">Nom de la formation : </label>
        <input id="nom_form" name="nom_form" type="text">
        </br>
        <label for="desc_form">Description : </label>
        <input id="desc_form" name="desc_form" type="text">
        </br>

            <?php
            //chargement de la liste des admin parc et des type de formation
            include_once('../../controleur/formation/index.php');
            chargeListe();
                        ?>
            

        </br>
        <button id="submit" name="submit" type="submit" value="submit" >Enregistrer</button>
        <button id="reset" name="reset" type="reset" value="reset" >Reinitialisé</button>

    </form>
</div>

<div>

</div>
</body>
</html>