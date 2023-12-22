<?php
class Bdd extends PDO{

    private const sgbd = 'mysql';
    private const server = "127.0.0.1";
    private const db = "colyseum";
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
    public function afficherClients(){//1
        $this->afficherSelectWhile("SELECT * FROM clients");
    }
    public function afficherTypesSpectacles(){//2
        $this->afficherSelectWhile("SELECT * FROM showTypes");
    }
    public function afficher20Premiers(){//3
        $this->afficherSelectWhile("SELECT * FROM clients LIMIT 0, 20");
    }
    public function afficherClientsCarte(){//4
        $this->afficherSelectWhile("SELECT * FROM clients WHERE cardNumber IS NOT NULL");
    }
    public function afficherClientsM5(){//5
        $tabClients = $this->afficherSelectWhile("SELECT * FROM clients WHERE lastName LIKE 'm%' ORDER BY lastName", false);
        foreach($tabClients as $client){
            echo "<p>Nom : ".$client['lastName']."</p>";
            echo "<p>Prénom : ".$client['firstName']."</p>";
            echo "<hr>";
        }
    }
    public function afficherShows(){//6
        $tabClients = $this->afficherSelectWhile("SELECT * FROM shows", false);
        foreach($tabShows as $show){
            echo "<p><b>".$show['title']."</b> par ".$show['performer']." la ".$show['date']." à ".$show['startTime']." </p>";
        }
    }
    public function afficherClient7(){//7
        $tabClients = $this->afficherSelectWhile("SELECT * FROM clients", false);
        foreach($tabClients as $client){
            echo "<p><b>Nom</b> : ".$client['lastName']."</p>";
            echo "<p><b>Prénom</b> : ".$client['firstName']."</p>";
            echo "<p><b>Date de naissance</b> : ".$client['birthDate']."</p>";
            echo "<p><b>Carte de fidélité</b> : ".(($client['card'])?"Oui":"Non")."</p>";
            echo ($client['card'])?"<p><b>Numéro de carte</b> : ".$client['cardNumber']."</p>":null;
            echo "<hr>";
        }
    }
    
}