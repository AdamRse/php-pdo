<?php
$nomPage = array(
    "ajout-patient.php" => "Ajouter un patient"
    , "index.php" => "Accueil"
    , "liste-patients.php" => "Liste les patients"
    , "ajout-rendezvous.php" => "Ajouter un RDV"
    , "profil-patient.php" => false
    , "liste-rendezvous.php" => "Liste des rendez-vous"
    , "rendezvous.php" => false
    , "ajout-patient-rendez-vous.php" => "Ajouter patient + RDV"
);
define("SCRIPT_NAME", substr($_SERVER["SCRIPT_NAME"], 1));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= (empty($nomPage[SCRIPT_NAME]))?SCRIPT_NAME:$nomPage[SCRIPT_NAME] ?></title>
</head>
<body>
    <h1><?= (empty($nomPage[SCRIPT_NAME]))?SCRIPT_NAME:$nomPage[SCRIPT_NAME] ?></h1>