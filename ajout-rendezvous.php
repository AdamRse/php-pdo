<?php
include './classes/Bdd-Exo-2.class.php';
include_once './page/header.php';

$Bdd = new Bdd();
$listePatients = $Bdd->querySelectAll("Select firstname, lastname, id from patients order by lastname");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un rdv</title>
</head>
<body>
    <h1>Ajouter un rdv</h1>
<?php
if(empty($_GET['idPatients']) || empty($_GET['dateHour']) ){
    ?>
    <form action=".<?= $_SERVER["SCRIPT_NAME"] ?>" method="get">
        <select name="idPatients">
            <?php
            foreach ($listePatients as $patient){
                echo "<option value='".$patient["id"]."'>".$patient["lastname"]." ".$patient["firstname"]."</option>";
            }
            ?>
        </select>
        <p>Date du RDV : <input type="datetime-local" name="dateHour"></p>
        <input type="submit" value="Envoyer">
    </form>
        <?php
        echo (empty($_GET))?"":"<p style='color: #921'>Requête invalide</p>";
}
else{
    if($Bdd->ajouterRdv($_GET)){
        echo "<p style='color: #193'>Rendez-vous pris !</p>";
    }
    else{
        echo "<p style='color: #931'>Erreur SQL</p>";
    }
}
include_once "./menu.php";
include_once "./page/footer.php";