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
    private function afficherSelectWhile($requete){
        $rq = $this->query($requete);
        while($ligne=$rq->fetch(PDO::FETCH_ASSOC)){
            echo "<p>";
            foreach($ligne as $k => $v){
                echo "<b>$k</b> : $v | ";
            }
            echo "</p>";
        }
    }
    public function afficherClients(){
        $this->afficherSelectWhile("SELECT * FROM clients");
    }
    public function afficherTypesSpectacles(){
        $this->afficherSelectWhile("SELECT * FROM showTypes");
    }
    public function  afficher20Premiers(){
        $this->afficherSelectWhile("SELECT * FROM clients LIMIT 0, 20");
    }
    public function  afficherClientsCarte(){
        $this->afficherSelectWhile("SELECT * FROM clients WHERE cardNumber IS NOT NULL");
    }

}