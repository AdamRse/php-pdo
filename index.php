<?php
include './classes/Bdd.class.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exo PDO</title>
</head>
<body>
    hello pdo
    <?php
    $bdd = new Bdd(); 
    $bdd->afficherClientsCarte();
    ?>
</body>
</html>