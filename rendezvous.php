<?php
include './classes/Bdd-Exo-2.class.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendez-vous</title>
</head>
<body>
    <h1>Détail du rendez-vous</h1>
    <?php
    if(!empty($_GET['id'])){
        $Bdd = new Bdd();
        $Bdd->afficherRDV($_GET['id']);
    }
    elseif(!empty($_GET['modifier'])){
        $Bdd = new Bdd();
        if(empty($_GET["idPatients"]) || empty($_GET["dateHour"])){
            $listePatients = $Bdd->querySelectAll("Select firstname, lastname, id from patients order by lastname");
            ?>
            <form action=".<?= $_SERVER["SCRIPT_NAME"] ?>" method="get">
                <input type="hidden" name="modifier" value="<?= $_GET['modifier'] ?>">
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
        }
        else{
            if($Bdd->modifierRDV($_GET)){
                $dt = new DateTime($_GET["dateHour"]);
                echo "<p>Le rendez-vous du ".$dt->format('m/d/Y à H\hi')." a bien été modifié</p>";
            }
            else{
                ?>
                <p>La modification a échouée</p>
                <p><pre><?php var_dump($Bdd->errorInfo()) ?></pre></p>
                <?php
            }
        }
    }
    else{
        ?>
        <p>Aucun rdv passé.</p>
        <?php
    }
    
    ?>
    
    <?php include "./menu.php" ?>
</body>
</html>