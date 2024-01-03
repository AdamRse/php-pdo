<?php
include './classes/Bdd-Exo-2.class.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des rendez-vous</title>
</head>
<body>
    <h1>Liste des rendez-vous</h1>
    <?php
    $Bdd = new Bdd();
    if(!empty($_GET['supprimer'])){
        if($Bdd->SupprimerRDV($_GET['supprimer'])){
            ?>
            <p>Le rendez-vous a bien été supprimé</p>
            <?php
        }
        else{
            ?>
            <p>La base de données renvoie une erreur :</p>
            <p><?= var_dump($Bdd->errorInfo()) ?></p>
            <?php
        }
    }
    else{
        $Bdd->afficherListeRDV();
    }
    ?>
    
    <?php include "./menu.php" ?>
</body>
</html>