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

</head>
<body>


<div id="cadre">
    <p><a href="../../index.php">Retourner au début</a></p>
    <p><a href="../aff_detail/index.php">Affecter des détails au module : <?php echo $_SESSION['id_mod'].', '.$_SESSION['nom_mod']?></a></p>
</div>

<div>

</div>
</body>
</html>