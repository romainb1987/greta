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
            a[name="module"]{
                color: black;
                text-decoration: none;
            }
            a[name="module"]:hover{
                color: dimgray;
            }

        </style>
        <script type="text/javascript" src="aff_parcours.js"></script>


    </head>
    <body>
        <?php
        include_once('../../controleur/aff_parcours/index.php');

        // recuperation pôur affichage du nom de la formation
        getNomForm($_SESSION['idForm']);
        echo '<h1> affecter des modules au parcours  '.$_SESSION['nom_Form']. ' de '.$_SESSION['prenom_Stag'].' '.$_SESSION['nom_Stag'].'</h1>';
        ?>
        <div id="cadre">
            <form id="<?php echo $_SESSION['idForm'];?>" method="post" action="fin_aff_parcours.php" onsubmit="insertContenu(this)">
                </br>
                <label for="nom_form">Choix des modules : </label>
                <?php
                //charge la liste des modules appliqués à la formation
                chargeListe();


                //  structure du DOM :
                //      <table id="details">
                //         <tr>
                //             <td id="detail"+id_module_en_cours>
                //                  <a id="$id_du_module_en_cours">
                //              </td>
                //          </tr>
                //       </table>


                ?>
                </br>
                <button id="submit" name="submit" type="submit" value="submit" >Enregistrer</button>
                <button id="reset" name="reset" type="reset" value="reset" >Réinitialiser</button>

            </form>
        </div>
    </body>
</html>