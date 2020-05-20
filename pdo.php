<?php
class ToDoList
{
    private $host;
    private $dbname;
    private $user;
    private $password;
    private $dcs;
    public function setup($host, $dbname, $user, $password)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->password = $password;
        $dcs = "mysql:host=$host;charset=utf8mb4";
        $options = [
            PDO::ATTR_EMULATE_PREPARES => false, // echte Prepared Statements ermöglichen
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Exceptions für Nicht-Connection-Fehler einschalten
        ];
        try {
            // Datenbank verbinden
            $db = new PDO($dcs, $user, $password, $options);
            // Datenbank erstellen
            $db->exec("DROP DATABASE IF EXISTS " . $dbname . ";");
            $db->exec("CREATE DATABASE " . $dbname . ";");
            $db->exec("USE " . $dbname . ";");
            $db->exec("CREATE TABLE fach (fachKuerzel VARCHAR(10) PRIMARY KEY, fachBez VARCHAR(60)) ENGINE=InnoDB;");
            $db->exec("CREATE TABLE todo (fach VARCHAR(10) , aufgabe VARCHAR(50),gemacht BOOL,deadline DATE ,PRIMARY KEY (fach,aufgabe),FOREIGN KEY (fach) REFERENCES fach (fachKuerzel)) ENGINE=InnoDB;");
             // Datenbankverbindung schließen
            $db = null;
            $this->dcs = "mysql:host=$host;dbname=$this->dbname;charset=utf8mb4";
            echo("Everything's fine");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function AddAllSubjects(){
        try {
            // Datenbank verbinden
            $db = new PDO($this->dcs, $this->user, $this->password, $this->options);
            $db->exec("INSERT INTO fach (fachKuerzel, fachBez) VALUES ('AM', 'Angewandet Mathematik');");
            $db->exec("INSERT INTO fach (fachKuerzel, fachBez) VALUES ('D', 'Deutsch');");
            $db->exec("INSERT INTO fach (fachKuerzel, fachBez) VALUES ('E', 'Englisch');");
            $db->exec("INSERT INTO fach (fachKuerzel, fachBez) VALUES ('NW', 'Naturwissenschaften');");
            $db->exec("INSERT INTO fach (fachKuerzel, fachBez) VALUES ('AUDT', 'Audiotechnik ');");
            $db->exec("INSERT INTO fach (fachKuerzel, fachBez) VALUES ('MEDT', 'Medientechnik ');");
            $db->exec("INSERT INTO fach (fachKuerzel, fachBez) VALUES ('NWTK', 'Netzwerktechnik ');");
            $db->exec("INSERT INTO fach (fachKuerzel, fachBez) VALUES ('SYT', 'Systemtechnik ');");
            $db->exec("INSERT INTO fach (fachKuerzel, fachBez) VALUES ('INSY', 'Informationssysteme');");
            $db->exec("INSERT INTO fach (fachKuerzel, fachBez) VALUES ('INFI', 'Informatik und Informationssysteme ');");
            $db->exec("INSERT INTO fach (fachKuerzel, fachBez) VALUES ('RK', 'Religion Katholisch ');");
            $db->exec("INSERT INTO fach (fachKuerzel, fachBez) VALUES ('SEW', 'Softwareentwicklung ');");
            $db = null;
            echo("Everything's fine");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function  AddSubject($kuerzel,$bez){
        try {
            // Datenbank verbinden
            $db = new PDO($this->dcs, $this->user, $this->password, $this->options);
            $statement = $db->prepare("INSERT INTO fach (fachKuerzel, fachBez) VALUES (?,?);");
            $statement -> execute ( array ( "'".$kuerzel ."'", "'".$bez ."'" ) ) ;
            $db = null;
            echo("Everything's fine");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function AddToDo($fach,$aufgabe,$gemacht,$deadline){
        try {
            // Datenbank verbinden
            $db = new PDO($this->dcs, $this->user, $this->password, $this->options);
            // TODO statement ist noch nicht fertig
            $statement = $db->prepare("INSERT INTO todo (fach, aufgabe,) VALUES (?,?,?);");
            $statement -> execute ( array ( "'".$kuerzel ."'", "'".$bez ."'" ) ) ;
            $db = null;
            echo("Everything's fine");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function getAllSubjects(){
        try {
            // Datenbank verbinden
            $db = new PDO($this->dcs, $this->user, $this->password, $this->options);
            $db->exec("SELECT fach, aufgabek, gemacht, deadline FROM todo;");
            $db = null;
            echo("Everything's fine");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function getAllToDos(){

    }
    public function getSubject($kuerzel){

    }
    public function getToDo($fach,$aufgabe){

    }
}