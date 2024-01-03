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
    <h1>Patient</h1>
    <?php
    if(!empty($_GET['id'])){
        $Bdd = new Bdd();
        $Bdd->afficherPatient($_GET['id']);
    }
    elseif(!empty($_GET['modifier'])){
        $Bdd = new Bdd();
        $Bdd->modifierPatient($_GET['modifier']);
    }
    else{
        echo "<p>Aucun ID passé en get.</p><a href=\"./liste-patients.php\">Retour</a>";
    }
    ?>
    <?php include "./menu.php" ?>
</body>
</html>