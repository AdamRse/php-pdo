<?php
class Bdd extends PDO{

    private $_taillePage = 10;

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

    }
    public function afficherListePatients($page = 1){
        $patients = $this->afficherSelectWhile("SELECT * FROM patients LIMIT ".((($page-1)*$this->_taillePage)).", ".$this->_taillePage."", false);
        $rq = $this->query("SELECT count(id) as nbEntrees FROM patients");
        $nbPatients = $rq->fetch(PDO::FETCH_COLUMN);
        $lastPage = ceil($nbPatients/$this->_taillePage);
        if($page>$lastPage) $page = $lastPage;
        foreach ($patients as $patient){
            ?>
            <a href="./profil-patient.php?id=<?= $patient["id"] ?>">
                <p>
                    <b><?= $patient["lastname"]." ".$patient["firstname"] ?></b>
                    </a>
                    - <a href="./liste-patients.php?supprimer=<?= $patient["id"] ?>">Supprimer</a>
                </p>
            <hr/>
            <?php
        }
        if($nbPatients > $this->_taillePage){
            ?>
            <div style="text-align: center; margin-top: 30px;">
                <?php
                if($page>1){
                    ?>
                    <a href=".<?= $_SERVER["SCRIPT_NAME"]."?page=".($page-1) ?>">Page précédente (<?= $page-1 ?>)</a> |
                    <?php
                }
                ?>
                PAGE <?= $page ?>
                <?php
                if($page<$lastPage){
                    ?>
                    | <a href=".<?= $_SERVER["SCRIPT_NAME"]."?page=".($page+1) ?>">Page suivante (<?= $page+1 ?>)</a>
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
        <div>
            <h3><?= $patient['lastname'].' '.$patient['firstname'] ?></h2>
            <ul>
                <li>Date de naissaince : <?= $patient['birthdate'] ?></li>
                <li>Téléphone : <?= $patient['phone'] ?></li>
                <li>E-mail : <?= $patient['mail'] ?></li>
                <li><a href=".<?= $_SERVER["SCRIPT_NAME"].'?modifier='.$patient['id'] ?>">Modifier</a></li>
            </ul>
            <?php
            if($rq->rowCount()>0){
                ?>
                <h3><?= ($rq->rowCount()>1)?"Liste des rendez-vous planifiés":"Rendez-vous planifié" ?></h3>
                <ul>
                    <?php
                    while($rdv = $rq->fetch(PDO::FETCH_ASSOC)){
                        $dt = new DateTime($rdv["dateHour"]);
                        echo "<li>".$dt->format('\L\e m/d/Y à H\hi')."</li>";
                    }
                    ?>
                </ul>
                <?php
            }
            ?>
            <hr/>
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
        $rq = $this->prepare("UPDATE patients SET lastname = :lastname, idPatients = :idPatients WHERE id = :modifier");
        return $rq->execute(array("id" => $id));
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