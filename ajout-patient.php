<?php
include './classes/Bdd-Exo-2.class.php';
include_once './page/header.php';
if(empty($_GET)){
    ?>
    <h1>Ajouter un iencli</h1>
    <form action=".<?= $_SERVER["SCRIPT_NAME"] ?>" method="get">
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" class="form-control" name="lastName" placeholder="Nom">
        </div>
        <div class="mb-3">
            <label class="form-label">Prénom</label>
            <input type="text" class="form-control" name="firstName" placeholder="Prénom">
        </div>
        <div class="mb-3">
            <label class="form-label">DAte de naissance</label>
            <input type="date" class="form-control" name="birthdate">
        </div>
        <div class="mb-3">
            <label class="form-label">Téléphone</label>
            <input type="number" class="form-control" name="phone" placeholder="Téléphone">
        </div>
        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input type="email" class="form-control" name="mail" placeholder="E-mail">
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
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
            <div class="alert alert-success" role="alert">
                Le patient a bien été ajouté ! <a href='./ajout-patient.php'>Retour</a>
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
            Le formulaire n'est pas remplis correctement.</p><a href='./ajout-patient.php'>Retour</a>
        </div>
        <?php
    }
}

include_once "./page/footer.php";