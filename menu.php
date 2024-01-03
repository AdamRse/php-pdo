<div style="background: #aaa; text-align: center">
    <h3>Menu</h3>
    <ul>
    <?php
    $nom = array(
        "ajout-patient.php" => "Ajouter un patient"
        , "index.php" => "Page principale"
        , "liste-patients.php" => "Liste les patients"
        , "ajout-rendezvous.php" => "Ajouter un RDV"
        , "profil-patient.php" => false
        , "liste-rendezvous.php" => "Liste des rendez-vous"
        , "rendezvous.php" => false
    );
    $listeScripts = scandir('./');
    foreach($listeScripts as $sc){
        if(substr($sc, 1)!="." && !is_dir("./$sc") && $sc != 'menu.php' && "/".$sc != $_SERVER["SCRIPT_NAME"] && ((!empty($nom[$sc]) || !isset($nom[$sc])))){
            ?>
            <li style="margin: 20px 0"><a href="./<?= $sc ?>"><?= (empty($nom[$sc]))?$sc:$nom[$sc] ?></a></li>
            <?php
        }
    }
    ?>
    </ul>
</div>