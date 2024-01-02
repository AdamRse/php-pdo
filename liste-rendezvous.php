<?php
include './classes/Bdd-Exo-2.class.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher les rendez-vous</title>
</head>
<body>
    <h1>Afficher la liste des rendes-vous</h1>
    <?php
    $Bdd = new Bdd();
    $Bdd->afficherListeRDV();
    ?>
    
    <?php include "./menu.php" ?>
</body>
</html>