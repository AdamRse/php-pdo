<?php
include './classes/Bdd-Exo-2.class.php';
include_once './page/header.php';

if(!empty($_GET['id'])){
    $Bdd = new Bdd();
    $Bdd->afficherPatient($_GET['id']);
}
elseif(!empty($_GET['modifier'])){
    $Bdd = new Bdd();
    if(isset($_GET['firstName']) || isset($_GET['lastName']) || isset($_GET['birthdate']) || isset($_GET['phone']) || isset($_GET['mail'])){
        $val = "";
        foreach ($_GET as $k => $v) {
            if(empty($v)) $val .= "<br/>Champ $k vide";
        }
        if($val == ""){
            if($Bdd->modifierPatient($_GET)){
                ?>
                <p>Le patient <b><?= $_GET['firstName'].' '.$_GET['lastName']  ?></b> a bien été modifié !</p>
                <?php
            }

        }
        else{
            ?>
            <p>Erreur de formulaire : <?= $val ?></p>
            <?php
        }
    }
    else{
        $patient = $Bdd->querySelectAll("SELECT * FROM patients WHERE id = ".$_GET['modifier']);
        if(empty($patient[0])){
            ?>
            <p>Impossible de récupérer le patient <?= $_GET['modifier'] ?> en base de données</p>
            <?php
        }
        else{
            ?>
            <h3>Modifier le patient</h3>
            <form action="./<?= SCRIPT_NAME ?>" method="get">
                    <input type="hidden" name="modifier" value="<?= $patient[0]["id"] ?>">
                    <input type="text" name="lastName" placeholder="Nom" value="<?= $patient[0]["lastname"] ?>">
                    <input type="text" name="firstName" placeholder="Prénom" value="<?= $patient[0]["firstname"] ?>">
                    <input type="date" name="birthdate" value="<?= $patient[0]["birthdate"] ?>">
                    <input type="number" name="phone" placeholder="Téléphone" value="<?= $patient[0]["phone"] ?>">
                    <input type="email" name="mail" placeholder="e-mail" value="<?= $patient[0]["mail"] ?>">
                <input type="submit" value="Envoyer">
            </form>
            <?php
        }
    }
}
else{
    echo "<p>Aucun ID passé en get.</p><a href=\"./liste-patients.php\">Retour</a>";
}

include_once "./menu.php";
include_once "./page/footer.php";