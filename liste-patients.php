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
    if(!empty($_GET['supprimer'])){
        if($Bdd->supprimerPatient($_GET['supprimer'])){
            ?>
            <p>Le patient a bien été supprimé</p>
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
        if(!empty($_GET['cherche'])){
            $cherche = $Bdd->chercherPatient($_GET['cherche']);
            if($cherche === false){
                ?>
                <p>La requête de recherche a échouée.</p>
                <?php
            }
            elseif(!empty($cherche)){
                ?>
                <div style="background: #ddd; padding: 10px">
                    <h3>Résultat de la recherche</h3>
                    <?php
                    foreach ($cherche as $patient){
                        ?>
                        <a href="./profil-patient.php?id=<?= $patient["id"] ?>">
                            <p>
                                <b><?= $patient["lastname"]." ".$patient["firstname"] ?></b>
                                </a>
                                - <a href="./liste-patients.php?supprimer=<?= $patient["id"] ?>">Supprimer</a>
                            </p>
                        <hr/>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
            else{
                ?>
                <p>Aucun patient trouvé.</p>
                <?php
            }
        }
        ?>
        <form action=".<?= $_SERVER["SCRIPT_NAME"] ?>" method="get">
            <input type="text" name="cherche" placeholder="Chercher un patient">
            <input type="submit" value="Recherche">
        </form>
        <?php
        $Bdd->afficherListePatients();
    }
    ?>
    <?php include "./menu.php" ?>
</body>
</html>