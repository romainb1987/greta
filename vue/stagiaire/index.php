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
        <script type="text/javascript" src="aff_formation.js"></script>

  
    </head>
    <body>

        <?php
        echo '<h1>Création d\'un stagiaire</h1>';
        ?>
    <div id="cadre">
        <form id="stagiaire" method="post" action="../aff_parcours/index.php?" onsubmit="insertContenu(this)">
            </br>
            <label for="nom_stag">Nom du stagiaire : </label>
            <input id="nom_form" name="nom_form" type="text">
            </br>
            <label for="prenom_stag">Prénom du stagiaire : </label>
            <input id="prenom_stag" name="prenom_stag" type="text">
            </br></br>
            <h4 >Selectionner une formation :-)</h4>
                <?php

                include_once('../../controleur/stagiaire/index.php');
                //charge la liste des types de formation
                chargeListe();


                //DOM de la section 
                //  liste theme formation
                //  <label/>
                //  <select/>
                //  <option>/
                //  tableau des formations
                //  <table>
                //      <tr>
                //          <td>---->> maxi 6 <td>
                //              <label>
                //                  <input>
                //              </label>
                //          </td>
                //      </tr>
                //  </table>

                ?>


            </br>
            <button id="submit" name="submit" type="submit" value="submit" >Enregistrer</button>
            <button id="reset" name="reset" type="reset" value="reset" >Réinitialiser</button>

        </form>
    </div>
    </body>
</html>