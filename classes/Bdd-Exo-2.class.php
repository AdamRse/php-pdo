<?php
class Bdd extends PDO{

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
        $rq = $this->prepare("INSERT INTO patients (lastName, firstName, birthdate, phone, mail) VALUES (:lastName, :firstName, :birthdate, :phone, :mail)");
        return $rq->execute($tab);
    }
    public function ajouterRdv($tab){
        $rq = $this->prepare("INSERT INTO appointments (dateHour, idPatients) VALUES (:dateHour, :idPatients)");
        return $rq->execute($tab);
    }
    public function afficherListePatients(){
        $patients = $this->afficherSelectWhile("SELECT * FROM patients", false);
        foreach ($patients as $patient){
            ?>
            <a href="./profil-patient.php?id=<?= $patient["id"] ?>">
                <p>
                    <b><?= $patient["lastname"]." ".$patient["firstname"] ?></b>
                </p>
            </a>
            <hr/>
            <?php
        }
    }
    public function afficherPatient($id){
        $rq = $this->prepare("SELECT * FROM patients WHERE id = :id");
        $rq->execute(array("id" => $id));
        $patient = $rq->fetch();
        ?>
        <div>
            <h3><?= $patient['lastname'].' '.$patient['firstname'] ?></h2>
            <ul>
                <li>Date de naissance : <?= $patient['birthdate'] ?></li>
                <li>Téléphone : <?= $patient['phone'] ?></li>
                <li>E-mail : <?= $patient['mail'] ?></li>
            </ul>
            <hr/>
        </div>
        <?php
    }
    //SELECT a.dateHour ,p.lastname ,p.firstname FROM appointments as a LEFT JOIN patients as p ON a.idPatients = p.id;
    public function afficherListeRDV(){
        $listeRdv = $this->afficherSelectWhile("SELECT id, dateHour FROM appointments;", false);
        $i=0;
        foreach ($listeRdv as $rdv){
            ?>
            <ul>
                <li>
                    <a href=".<?= $_SERVER["SCRIPT_NAME"].'?id='.$rdv["id"] ?>">
                        <?php $dt = new DateTime($rdv["dateHour"]); echo ++$i.") Le ".$dt->format('m/d/Y à H:i') ?>
                    </a>
                </li>
            </ul>
            <hr/>
            <?php
        }
    }
    
}