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
            <div class="alert alert-success" role="alert">
                Le patient et son RDV ont bien été ajouté ! <a href='.<?= $_SERVER["SCRIPT_NAME"] ?>'>Retour</a>
            </div>
            <?php
        }
        else{
            ?>
            <div class="alert alert-danger" role="alert">
                Erreur SQL :
                <pre>
                <?php var_dump($Bdd->errorInfo()) ?>
                </pre>
            </div>
            <?php
        }
    }
    else{
        ?>
        <div class="alert alert-danger" role="alert">
            Le formulaire n'est pas remplis correctement. <a href='.<?= $_SERVER["SCRIPT_NAME"] ?>'>Retour</a>
        </div>
        <?php
    }
}

include_once "./page/footer.php";