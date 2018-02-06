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
    <form id="detail" method="post" action="../../controleur/detail/index.php" >
        </br>
        <label for="nom_detail">Nom du détail : </label>
        <input id="nom_detail" name="nom_detail" type="text">
        </br>
        <label for="desc_detail">Description : </label>
        <input id="desc_detail" name="desc_detail" type="text">
        </br>
        </br>

        <?php

        include_once('../../controleur/detail/index.php');
        //on charge la liste des theme des details 
        chargeListe();
        ?>


        </br>
        <button id="submit" name="submit" type="submit" value="submit" >Enregistrer</button>
    </form>
</div>

</body>
</html>