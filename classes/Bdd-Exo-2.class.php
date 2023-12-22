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
    public function ajouterPatient($tab){//1
        $rq = $this->prepare("INSERT INTO patients (lastName, firstName, birthdate, phone, mail) VALUES (:lastName, :firstName, :birthdate, :phone, :mail)");
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
        $tab = $rq->fetch();
        ?>
        
        <?php
    }
    
}