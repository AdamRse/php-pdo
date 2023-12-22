<?php
include './classes/Bdd-Exo-2.class.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>patients</title>
</head>
<body>
    <h1>Afficher la liste des patients</h1>
    <?php
    if(empty($_GET['idi'])){
        $Bdd = new Bdd();
        $Bdd->afficherPatient($_GET['id']);
    }
    else{
        echo "<p>Aucun ID passé en get.</p><a href=\"./liste-patients.php\">Retour</a>";
    }
    ?>
    
    <a href="./ajout-patient.php">Ajouter un patient</a>
</body>
</html>