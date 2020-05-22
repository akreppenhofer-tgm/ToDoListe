<?php
require_once 'ToDo.php';

class ToDoList
{
    private $host;
    private $dbname;
    private $user;
    private $password;
    private $dcs;
    private static $options = [
        PDO::ATTR_EMULATE_PREPARES => false, // echte Prepared Statements ermöglichen
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Exceptions für Nicht-Connection-Fehler einschalten
    ];
    public function setup($host, $dbname, $user, $password)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->password = $password;
        $dcs = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        try {
            // Datenbank verbinden
            $db = new PDO($dcs, $user, $password, self::$options);
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
            echo "setup: ";
            echo $e->getMessage();
            echo $e;
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
            echo "AddAllSubjects: ";
            echo $e->getMessage();
            echo $e;
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
            echo "AddSubject: ";
            echo $e->getMessage();
            echo $e;
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
            return $allSubjects;
        } catch (PDOException $e) {
            echo "AddToDo: ";
            echo $e->getMessage();
            echo $e;
        }
        return false;
    }

    /**
     * @param ToDo $todo das Todo zum speichern
     * @return bool false, bei Fehler
     */
    public function saveToDo(ToDo $todo) {
        try {
            // Datenbank verbinden
            $db = new PDO($this->dcs, $this->user, $this->password, $this->options);
            $stmt = $db->prepare("SELECT * FROM todo WHERE fach = ? AND aufgabe = ?");
            $stmt->execute([$todo->getFach(),$todo->getBezeichnung()]);
            if ($stmt->fetch() != false) {
                // this To_do exists => UPDATE
                $stmt = $db->prepare("UPDATE todo SET gemacht = :gemacht AND deadline = :deadline WHERE aufgabe = :aufgabe AND fach = :fach");
            }
            else {
                // this To_do doesnt exist => INSERT INTO
                $stmt = $db->prepare("INSERT INTO todo (aufgabe, fach, gemacht, deadline) VALUES (:aufgabe, :fach, :gemacht, :deadline)");
            }
            $stmt->execute([':aufgabe'=>$todo->getFach(),':fach'=>$todo->getFach(),':gemacht'=>$todo->isDone(),':deadline'=>$todo->isOverdue()]);
            $db = null;
            return true;
        } catch (PDOException $e) {
            echo "saveToDo: ";
            echo $e->getMessage();
            echo $e;
            return false;
        }
    }

    /**
     * @param $todos an array of TODOs to save
     */
    public function saveToDos($todos) {
        foreach ($todos as $todo) {
            $this->saveToDo($todo);
        }
    }

    /**
     * @return array|bool all Fach-Objects or false
     */
    public function getAllSubjects(){
        try {
            // Datenbank verbinden
            $db = new PDO($this->dcs, $this->user, $this->password, self::$options);
            $data = $db->query("SELECT fachBez, fachKuerzel FROM fach;")->fetchAll();
            $allSubjects = array();
            foreach ($data as $row) {
                $allToDos[] = new Fach($data['fachKuerzel'],$data['fachBez']);
            }
            $db = null;
            echo("Everything's fine");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @return array|bool all TodoObjects or false
     */
    public function getAllToDos(){
        try {
            // Datenbank verbinden
            $db = new PDO($this->dcs, $this->user, $this->password, self::$options);
            $data = $db->query("SELECT fach, aufgabe, gemacht, deadline FROM todo;")->fetchAll();
            $allToDos = array();
            foreach ($data as $row) {
                $allToDos[] = new ToDo($data['aufgabe'],$data['fach'],$data['deadline'],$data['gemacht']);
            }
            $db = null;
            return $allToDos;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public function getSubject($kuerzel){

    }
    public function getToDo($fach,$aufgabe){

    }
}