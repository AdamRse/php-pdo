<?php
include './classes/Bdd-Exo-2.class.php';
include_once './page/header.php';

if(empty($_GET)){
    ?>
    <form action=".<?= $_SERVER["SCRIPT_NAME"] ?>" method="get">
        <h3>Patient</h3>
            <input type="text" name="lastName" placeholder="Nom">
            <input type="text" name="firstName" placeholder="Prénom">
            <input type="date" name="birthdate">
            <input type="number" name="phone" placeholder="Téléphone">
            <input type="email" name="mail" placeholder="e-mail">
        <h3>RDV</h3>
        <p>Date du RDV (optionel) : <input type="datetime-local" name="dateHour"></p>
        <input type="submit" value="Envoyer">
    </form>
    <?php
}
else{
    $formValide = true;
    foreach ($_GET as $value) {
        if(empty($value)){
            $formValide = false;
        }
    }
    if($formValide){
        $bdd = new Bdd();
        if($bdd->ajoutPatientEtRdv($_GET)){// A TESTER
            ?>
            <p>Le patient et son RDV ont bien été ajouté ! </p><a href='.<?= $_SERVER["SCRIPT_NAME"] ?>'>Retour</a>
            <?php
        }
        else{
            ?>
            <p>Erreur en base de données.</p><a href='.<?= $_SERVER["SCRIPT_NAME"] ?>'>Retour</a>
            <?php
        }
    }
    else{
        ?>
        <p>Le formulaire n'est pas remplis correctement.</p><a href='.<?= $_SERVER["SCRIPT_NAME"] ?>'>Retour</a>
        <?php
    }
}

include_once "./page/footer.php";