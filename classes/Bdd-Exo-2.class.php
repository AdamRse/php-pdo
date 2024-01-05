<?php
class Bdd extends PDO{

    private $_taillePage = 6;

    private const sgbd = 'mysql';
    private const server = "127.0.0.1";
    private const db = "hospitalE2N";
    private const user = "root";
    private const pw = "";

    public function __construct(){
        $connectionString = self::sgbd.":dbname=".self::db.";host=".self::server;
        parent::__construct($connectionString, self::user, self::pw);
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    private function majFirst($str){
        return strtoupper(substr($str, 0, 1)).strtolower(substr($str, 1));
    }
    public function querySelectAll($requete){
        return $this->afficherSelectWhile($requete, false);
    }
    private function afficherSelectWhile($requete, $afficher = true){
        $retour = array();
        $rq = $this->query($requete);
        while($ligne=$rq->fetch(PDO::FETCH_ASSOC)){
            echo ($afficher)?"<p>":null;
            if($afficher){
                foreach($ligne as $k => $v){
                    if($afficher){
                        echo "<b>$k</b> : $v | ";
                    }
                }
            }
            else{
                $retour[]=$ligne;
            }
            echo ($afficher)?"</p>":null;;
        }
        return $retour;
    }
    public function ajouterPatient($tab){
        $tab['firstName']=$this->majFirst($tab['firstName']);
        $tab['lastName']=$this->majFirst($tab['lastName']);
        $rq = $this->prepare("INSERT INTO patients (lastName, firstName, birthdate, phone, mail) VALUES (:lastName, :firstName, :birthdate, :phone, :mail)");
        return $rq->execute($tab);
    }
    public function ajouterRdv($tab){
        $rq = $this->prepare("INSERT INTO appointments (dateHour, idPatients) VALUES (:dateHour, :idPatients)");
        return $rq->execute($tab);
    }
    public function ajoutPatientEtRdv($tab){
        $tab["lastName"]=$this->majFirst($tab["lastName"]);
        $tab["firstName"]=$this->majFirst($tab["firstName"]);
        $sql = "INSERT INTO patients (lastName, firstName, birthdate, phone, mail) VALUES (:lastName, :firstName, :birthdate, :phone, :mail);".((empty($tab["dateHour"]))?"":" INSERT INTO appointments (dateHour, idPatients) VALUES (:dateHour, LAST_INSERT_ID())");
        $rq = $this->prepare($sql);
        return $rq->execute($tab);
    }
    public function afficherListePatients($page = 1){
        $patients = $this->afficherSelectWhile("SELECT * FROM patients ORDER BY lastname LIMIT ".((($page-1)*$this->_taillePage)).", ".$this->_taillePage."", false);
        $rq = $this->query("SELECT count(id) as nbEntrees FROM patients");
        $nbPatients = $rq->fetch(PDO::FETCH_COLUMN);
        $lastPage = ceil($nbPatients/$this->_taillePage);
        if($page>$lastPage) $page = $lastPage;
        ?>
        <div class="contCards">
        <?php
        foreach ($patients as $patient){
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
        <?php
        if($nbPatients > $this->_taillePage){
            ?>
            <div style="text-align: center; margin-top: 30px;">
                <?php
                if($page>1){
                    ?>
                    <a href=".<?= $_SERVER["SCRIPT_NAME"]."?page=".($page-1) ?>">
                        <button type="button" class="btn btn-danger mx-2">< Précédent</button>
                    </a>
                    <?php
                    for($i=1;$i<$page;$i++){
                        ?>
                        <a href=".<?= $_SERVER["SCRIPT_NAME"]."?page=$i" ?>">
                            <button type="button" class="btn btn-danger mx-2"><?= $i ?></button>
                        </a>
                        <?php
                    }
                }
                else{
                    ?>
                    <button type="button" class="btn btn-light mx-2">< Précédent</button>
                    <?php
                }
                ?>
                <button type="button" class="btn btn-light mx-2"><?= $page ?></button>
                <?php
                if($page<$lastPage){
                    for($i=$page+1;$i<=$lastPage;$i++){
                        ?>
                        <a href=".<?= $_SERVER["SCRIPT_NAME"]."?page=$i" ?>">
                            <button type="button" class="btn btn-danger mx-2"><?= $i ?></button>
                        </a>
                        <?php
                    }
                    ?>
                    <a href=".<?= $_SERVER["SCRIPT_NAME"]."?page=".($page+1) ?>">
                        <button type="button" class="btn btn-danger mx-2">Suivant ></button>
                    </a>
                    <?php
                }
                else{
                    ?>
                    <button type="button" class="btn btn-light mx-2">Suivant ></button>
                    <?php
                }
                ?>
            </div>
            <?php
        }
    }
    public function afficherPatient($id){
        $rq = $this->prepare("SELECT * FROM patients WHERE id = :id");
        $rq->execute(array("id" => $id));
        $patient = $rq->fetch();
        $rq = $this->prepare("SELECT dateHour FROM appointments WHERE idPatients = :id");
        $rq->execute(array("id" => $id));
        ?>
        <div class="d-flex justify-content-center">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills card-header-pills">
                    <li class="nav-item">
                        <a class="nav-link"  href="./ajout-rendezvous.php?id=<?= $patient['id'] ?>">Ajouter un rendez-vous</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning-emphasis"  href=".<?= $_SERVER["SCRIPT_NAME"].'?modifier='.$patient['id'] ?>">Modifier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger"  href="./liste-patients.php?supprimer=<?= $patient['id'] ?>">Supprimer</a>
                    </li>
                    </ul>
                </div>
                <div class="card-body">
                    <h4 class="card-title text-center"><?= $patient['lastname'].' '.$patient['firstname'] ?></h4>
                    <hr>
                    <p>Date de naissaince : <?= $patient['birthdate'] ?></p>
                    <p>Téléphone : <?= $patient['phone'] ?></p>
                    <p>E-mail : <?= $patient['mail'] ?></p>
                </div>
                <ul class="list-group list-group-flush text-center">
                    <?php
                        while($rdv = $rq->fetch(PDO::FETCH_ASSOC)){
                            $dt = new DateTime($rdv["dateHour"]);
                            ?>
                            <li class="list-group-item bg-danger text-white">RDV Le <?= $dt->format('m/d/Y à H\hi') ?></li>
                            <?php
                        }
                    ?>
                </ul>
            </div>
        </div>
        <?php
    }
    public function chercherPatient($str){
        $retour = null;
        if(!empty($str)){
            $rq = $this->prepare("SELECT * FROM patients WHERE lastname LIKE :s OR firstname LIKE :s");
            $rq->execute(array("s" => $str.'%'));
            $retour = $rq->fetchAll();
        }
        return $retour;
    }
    public function modifierPatient($tab){
        $tab['firstName']=$this->majFirst($tab['firstName']);
        $tab['lastName']=$this->majFirst($tab['lastName']);
        $rq = $this->prepare("UPDATE patients SET firstname = :firstName, lastname = :lastName, birthdate = :birthdate, phone = :phone, mail = :mail WHERE id = :modifier");
        return $rq->execute($tab);
    }
    public function supprimerPatient($id){
        $rq = $this->prepare("DELETE appointments, patients FROM appointments LEFT JOIN patients ON appointments.idPatients = patients.id WHERE appointments.idPatients = :id");
        return $rq->execute(array("id" => $id));
    }
    public function afficherListeRDV(){
        $listeRdv = $this->afficherSelectWhile("SELECT id, dateHour FROM appointments;", false);
        $i=0;
        foreach ($listeRdv as $rdv){
            ?>
            <ul>
                <li>
                    <a href="./rendezvous.php?id=<?= $rdv["id"] ?>">
                        <?php $dt = new DateTime($rdv["dateHour"]); echo ++$i.") Le ".$dt->format('m/d/Y à H:i') ?>
                    </a>
                    <a href=".<?= $_SERVER["SCRIPT_NAME"]."?supprimer=".$rdv["id"] ?>">Supprimer</a>
                </li>
            </ul>
            <hr/>
            <?php
        }
    }
    public function afficherRDV($id){
        $rq = $this->prepare("SELECT a.id, a.dateHour ,p.lastname ,p.firstname, p.phone, p.mail FROM appointments as a LEFT JOIN patients as p ON a.idPatients = p.id WHERE a.id = :id;");
        $rq->execute(array("id" => $id));
        $rdv = $rq->fetch();
        ?>
        <div>
            <h3>Rendez-vous du <?php $dt = new DateTime($rdv["dateHour"]); $dateTime = explode(" à ", $dt->format('m/d/Y à H\hi'), 2); echo $dateTime[0];  ?></h2>
            <ul>
                <li>Horaire : <?= $dateTime[1] ?></li>
                <li>Patient : <?= $rdv['lastname'].' '.$rdv['firstname'] ?></li>
                <li>Téléphone : <?= $rdv['phone'] ?></li>
                <li>E-mail : <?= $rdv['mail'] ?></li>
                <li><a href=".<?= $_SERVER["SCRIPT_NAME"].'?modifier='.$rdv['id'] ?>">Modifier</a></li>
            </ul>
            <hr/>
        </div>
        <?php
    }
    public function modifierRDV($tab){
        $rq = $this->prepare("UPDATE appointments SET dateHour = :dateHour, idPatients = :idPatients WHERE id = :modifier");
        return $rq->execute($tab);
    }
    public function SupprimerRDV($id){
        $rq = $this->prepare("DELETE FROM appointments WHERE id = :id");
        return $rq->execute(array("id" => $id));
    }
    
}