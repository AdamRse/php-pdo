<?php
if(!empty($_GET['lastname']) && !empty($_GET['firstname'])){
    require "./PageRequetes/modifier-bdd.php";
}
else{
    require "./PageRequetes/modifier-formulaire.php";
}