<?php
include './classes/Bdd-Exo-2.class.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher les patients</title>
</head>
<body>
    <h1>Afficher la liste des patients</h1>
    <?php
    $Bdd = new Bdd();
    $Bdd->afficherListePatients();
    ?>
    
    <a href="./ajout-patient.php">Ajouter un patient</a>
</body>
</html>