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
    elseif(!empty($_GET['modifier'])){
        $allPatient = $Bdd->querySelectAll("SELECT * FROM patients WHERE id = ".$_GET['modifier']);
        $incomplet = "";
        foreach($_GET as $k => $v){
            if(empty($v)) $incomplet .= "<br/>- valeur <b>$k</b> manquante.";
        }
        if(isset($_GET['firstName']) || isset($_GET['lastName']) || isset($_GET['birthdate']) || isset($_GET['phone']) || isset($_GET['mail'])){
            if(empty($incomplet)){
                if($Bdd->modifierPatient($_GET)){
                    ?>
                    <p>Patient <?= $_GET['lastName'].' '.$_GET['firstName'] ?> bien modifié !</p>
                    <ul>
                        <li>Date de naissance : <?= $_GET['birthdate'] ?> </li>
                        <li>Téléphone : <?= $_GET['phone'] ?> </li>
                        <li>E-mail: <?= $_GET['mail'] ?> </li>
                    </ul>
                    <?php
                }
            }
            else{
                ?>
                <p>Erreur de formulaire :<?= $incomplet ?></p>
                <?php
            }
        }
        else{
        ?> 
        <h1>Modifier la fiche de <?= $allPatient[0]["lastName"], $allPatient[0]["firstName"] ?></h1>
            <form action=".<?= $_SERVER["SCRIPT_NAME"] ?>" method="get">
            <h3>Patient</h3>
                <input type="hidden" name="modifier" value="<?= $allPatient[0]["id"] ?>">
                <input type="text" name="lastName" placeholder="Nom" value="<?= $allPatient[0]["lastName"] ?>">
                <input type="text" name="firstName" placeholder="Prénom" value="<?= $allPatient[0]["firstName"] ?>">
                <input type="date" name="birthdate" value="<?= $allPatient[0]["birthdate"] ?>">
                <input type="number" name="phone" placeholder="Téléphone" value="<?= $allPatient[0]["phone"] ?>">
                <input type="email" name="mail" placeholder="e-mail" value="<?= $allPatient[0]["mail"] ?>">
                <input type="submit" value="Modifier">
            </form>
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
                    ?>a 
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
        $Bdd->afficherListePatients((empty($_GET['page'])?1:$_GET['page']));
    }
    ?>
    <?php include "./menu.php" ?>
</body>
</html>