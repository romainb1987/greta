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
    <form id="module" method="post" action="../../controleur/module/index.php" >
        </br>
        <label for="nom_module">Nom du module : </label>
        <input id="nom_module" name="nom_module" type="text">
        </br>
        <label for="desc_mod">Description : </label>
        <input id="desc_mod" name="desc_mod" type="text">
        </br>

            <?php
            include_once('../../controleur/module/index.php');
            //vers charger les liste des competences, themes et matieres existants
            chargeListe();

            ?>

        </br>
        <button id="submit" name="submit" type="submit" value="submit" >Enregistrer</button>
    </form>
</div>

<div>

</div>
</body>
</html>