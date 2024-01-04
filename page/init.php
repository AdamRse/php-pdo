<?php
$nomPage = array(
    "ajout-patient.php" => "Ajouter un patient"
    , "index.php" => "Hopital Adam"
    , "liste-patients.php" => "Liste des patients"
    , "ajout-rendezvous.php" => "Ajouter un RDV"
    , "profil-patient.php" => false
    , "liste-rendezvous.php" => "Liste des rendez-vous"
    , "rendezvous.php" => false
    , "ajout-patient-rendez-vous.php" => "Ajouter patient + RDV"
);

//constantes
define("SCRIPT_NAME", substr($_SERVER["SCRIPT_NAME"], 1));

define("NOM_PAGE", (empty($nomPage[SCRIPT_NAME]))?SCRIPT_NAME:$nomPage[SCRIPT_NAME]);