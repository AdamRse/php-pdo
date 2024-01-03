<div style="background: #aaa; text-align: center">
    <h3>Menu</h3>
    <ul>
    <?php
    //$nomPage défini dans page/header.php
    $listeScripts = scandir('./');
    $expl = explode('/', __FILE__);
    $nomScriptMenu = $expl[sizeof($expl)-1];
    foreach($listeScripts as $sc){
        if(substr($sc, 1)!="." && !is_dir("./$sc") && $sc != $nomScriptMenu && $sc != SCRIPT_NAME && ((!empty($nomPage[$sc]) || !isset($nomPage[$sc])))){
            ?>
            <li style="margin: 20px 0"><a href="./<?= $sc ?>"><?= (empty($nomPage[$sc]))?$sc:$nomPage[$sc] ?></a></li>
            <?php
        }
    }
    ?>
    </ul>
</div>