<?php
require_once "init.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/css.css">
    <link rel="icon" href="./img/icon.png" type="image/x-icon">
    <title><?= NOM_PAGE ?></title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-danger">
    <div class="container">
        <a class="navbar-brand text-white" href="./index.php">Adam Hopital</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php
                $listeScripts = scandir('./');
                foreach($listeScripts as $sc){
                    if(substr($sc, 1)!="." && !is_dir("./$sc") && $sc != "index.php" && ((!empty($nomPage[$sc]) || !isset($nomPage[$sc])))){
                        ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($sc == SCRIPT_NAME )?"active activeP text-warning":"text-white"; ?>" aria-current="page" href="./<?= $sc ?>"><?= (empty($nomPage[$sc]))?$sc:$nomPage[$sc] ?></a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    </nav>
    <div id="conteneur" class="container p-5">