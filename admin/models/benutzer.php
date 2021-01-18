<?php

class Benutzer
{
    private $id;
    private $benutzername;
    private $password;

    public function __construct(array $daten = array())
    {
        $this->setDaten($daten);
    }
    
    public function setDaten(array $daten)
    {
        //Wenn Array Daten enthält, dann entsprechenden Setter aufrufen
        if ($daten) {
            //Durchlaufe das Array und gib Einzelwerte weiter
            foreach ($daten as $schluessel => $wert) {
                $setterName = 'set' . ucfirst($schluessel);

                if (method_exists($this, $setterName)) {
                    //Setter wir aufgerufen
                    $this->$setterName($wert);
                }
            }
        }
    }

    //Getter
    public function getBenutzername()
    {
        return $this->benutzername;
    }
    public function getPassword()
    {
        return $this->password;
    }

    public function getId()
    {
        return $this->id;
    }

    //Setter
    public function setBenutzername($benutzername)
    {
        $this->benutzername = $benutzername;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public static function getAlleBenutzer($db)
    {
        $abfrage = $db->query("SELECT benutzername FROM benutzer");
        $abfrage->setFetchMode(PDO::FETCH_CLASS, "Benutzer", array());
        $benutzer = $abfrage->fetchAll();
        return $benutzer;
    }

    public static function getEinBenutzer($db, $id)
    {
        $abfrage = $db->query("SELECT id, benutzername, password
FROM benutzer WHERE id = $id");
        $abfrage->setFetchMode(PDO::FETCH_CLASS, "EinBenutzer", array());
        $einBenutzer = $abfrage->fetchAll();
        return $einBenutzer;
    }

    public static function getBenutzerDaten($db)
    {
        $abfrage = $db->query("SELECT benutzername, password
FROM benutzer");
        $abfrage->setFetchMode(PDO::FETCH_CLASS, "BenutzerDaten", array());
        $benutzerDaten = $abfrage->fetchAll();
        return $benutzerDaten;
    }
}
