<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Greta-Suivi pédagogique</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="application-name" content="suivi pedagogique Formation greta">
    <style>
        table {
            border: medium solid #6495ed;
            border-collapse: collapse;
            width: 100%;
        }
        th {
            font-family: monospace;
            border: thin solid #6495ed;
            width: 15%;
            padding: 5px;
            background-color: #D0E3FA;
            background-image: url(sky.jpg);
        }
        td {
            font-family: sans-serif;
            border: thin solid #6495ed;
            width: 15%;
            padding: 5px;
            text-align: center;
            background-color: #ffffff;
        }
        caption {
            font-family: sans-serif;
        }

    </style>
    <script type="text/javascript" src="aff_modules.js"></script>

  
</head>
<body>

<?php
echo '<h1> affecter des modules à la formation '.$_SESSION['nom_form'].'</h1>';

?>
<div id="cadre">
    <form id="<?php echo $_SESSION['idformation'];?>" method="post" action="fin_aff_module.php" onsubmit="insertContenu(this)">
        </br>
        <label for="nom_form">Thèmes : </label>
        <?php

        include_once('../../controleur/aff_module/index.php');
        //charge la liste des thèmes
        chargeListe();
        ?>


        </br>
        <button id="submit" name="submit" type="submit" value="submit" >Enregistrer</button>
        <button id="reset" name="reset" type="reset" value="reset" >Réinitialiser</button>

    </form>
</div>

<div>

</div>
</body>
</html>