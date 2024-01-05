<?php
include_once './page/header.php';
include './classes/Bdd-Exo-2.class.php';
?>
<h1>Liste des pigeons</h1>
<?php

$Bdd = new Bdd();
if(!empty($_GET['supprimer'])){
    if($Bdd->supprimerPatient($_GET['supprimer'])){
        ?>
        <div class="alert alert-success" role="alert">
        Le patient a bien été supprimé
        </div>
        <?php
    }
    else{
        ?>
        <div class="alert alert-danger" role="alert">
            La base de données renvoie une erreur :
            <pre><?= var_dump($Bdd->errorInfo()) ?></pre>
        </div>
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
            <div class="alert alert-danger" role="alert">
                Erreur de formulaire : <?= $incomplet ?>
            </div>
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
    ?>
    <form class="d-flex m-3" role="search" action=".<?= $_SERVER["SCRIPT_NAME"] ?>"  method="get">
        <input class="form-control me-2" type="search" name="cherche" placeholder="Chercher un patient" aria-label="Search">
        <button class="btn btn-danger" type="submit">Chercher</button>
    </form>
    <?php
    if(!empty($_GET['cherche'])){
        $cherche = $Bdd->chercherPatient($_GET['cherche']);
        if($cherche === false){
            ?>
            <div class="alert alert-danger" role="alert">
                La requête de recherche a échouée.
            </div>
            <?php
        }
        elseif(!empty($cherche)){
            ?>
            <div class="contCards">
                <div class="alert alert-success" role="alert">
                    Résultat de la recherche
                </div>
                <?php
                foreach ($cherche as $patient){
                    ?>
                    <div class="card m-2 bg-light tailleCarte">
                        <div class="card-body">
                            <h5 class="card-title"><?= $patient["lastname"] ?></h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary"><?= $patient["firstname"] ?></h6>
                            <a href="./profil-patient.php?id=<?= $patient["id"] ?>" class="card-link">Détail</a>
                            <a href="./profil-patient.php?modifier=<?= $patient["id"] ?>" class="card-link text-warning-emphasis">Modifier</a>
                            <a href="./liste-patients.php?supprimer=<?= $patient["id"] ?>" class="card-link text-danger">Supprimer</a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <hr>
            <?php
        }
        else{
            ?>
            <div class="alert alert-info" role="alert">
            Aucun patient trouvé.
            </div>
            <?php
        }
    }
    $Bdd->afficherListePatients((empty($_GET['page'])?1:$_GET['page']));
}

include_once "./page/footer.php";