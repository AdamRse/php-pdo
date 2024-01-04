<?php
include './classes/Bdd-Exo-2.class.php';
include_once './page/header.php';
if(empty($_GET)){
    ?>
    <form action=".<?= $_SERVER["SCRIPT_NAME"] ?>" method="get">
        <input type="text" name="lastName" placeholder="Nom">
        <input type="text" name="firstName" placeholder="Prénom">
        <input type="date" name="birthdate">
        <input type="number" name="phone" placeholder="Téléphone">
        <input type="email" name="mail" placeholder="e-mail">
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
        if($bdd->ajouterPatient($_GET)){
            ?>
            <p>Le patient a bien été ajouté ! </p><a href='./ajout-patient.php'>Retour</a>
            <?php
        }
        else{
            ?>
            <p>Erreur en base de données.</p><a href='./ajout-patient.php'>Retour</a>
            <?php
        }
    }
    else{
        ?>
        <p>Le formulaire n'est pas remplis correctement.</p><a href='./ajout-patient.php'>Retour</a>
        <?php
    }
}

include_once "./page/footer.php";