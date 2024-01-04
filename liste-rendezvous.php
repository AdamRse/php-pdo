<?php
include './classes/Bdd-Exo-2.class.php';
include_once './page/header.php';

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

include_once "./menu.php";
include_once "./page/footer.php";