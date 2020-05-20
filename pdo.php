<?php
class ToDo
{
    private $host;
    private $dbname;
    private $user;
    private $password;
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
            $db->exec("DROP DATABASE IF EXISTS " . $dbname . ";");
            $db->exec("CREATE DATABASE " . $dbname . ";");
            $db->exec("USE " . $dbname . ";");
            $db->exec("CREATE TABLE fach (fachKuerzel VARCHAR(10) PRIMARY KEY, FachBez VARCHAR(50)) ENGINE=InnoDB;");
            $db->exec("CREATE TABLE todo (fach VARCHAR(10) , aufgabe VARCHAR(50),gemacht BOOL,deadline DATE ,PRIMARY KEY (fach,aufgabe),FOREIGN KEY (fach) REFERENCES fach (fachKuerzel)) ENGINE=InnoDB;");
             // Datenbankverbindung schließen
            $db = null;
            echo("Everything's fine");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}