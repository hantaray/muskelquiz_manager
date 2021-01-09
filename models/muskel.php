<?php

class Muskel
{

	private $id;
	private $reihenfolge;
	private $name;
	private $ursprung;
	private $ansatz;
	private $innervation;
	private $kategorie;

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

	public function getId()
	{
		return $this->id;
	}

	public function getReihenfolge()
	{
		return $this->reihenfolge;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getUrsprung()
	{
		return $this->ursprung;
	}
	public function getAnsatz()
	{
		return $this->ansatz;
	}
	public function getInnervation()
	{
		return $this->innervation;
	}
	public function getKategorie()
	{
		return $this->kategorie;
	}

	//Setter
	public function setReihenfolge($reihenfolge)
	{
		$this->reihenfolge = $reihenfolge;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setUrsprung($ursprung)
	{
		$this->ursprung = $ursprung;
	}

	public function setAnsatz($ansatz)
	{
		$this->ursprung = $ansatz;
	}

	public function setInnervasion($innervasion)
	{
		$this->ursprung = $innervasion;
	}

	public function setKategorie($kategorie)
	{
		$this->ursprung = $kategorie;
	}

	// read products
	public static function read($db)
	{

		// select all query
		$query = "SELECT id, reihenfolge, name, ursprung, ansatz, innervation, kategorie
		FROM muskeln";

		// prepare query statement
		$stmt = $db->prepare($query);

		// execute query
		$stmt->execute();

		return $stmt;
	}

	public static function getMuskeln($db)
	{
		$abfrage = $db->query("SELECT id, reihenfolge, name, ursprung, ansatz, innervation, kategorie
FROM muskeln ORDER BY kategorie, reihenfolge");
		$abfrage->setFetchMode(PDO::FETCH_CLASS, "Muskel", array());
		$muskeln = $abfrage->fetchAll();
		return $muskeln;
	}

	public static function insertMuskel($db, $daten)
	{
		$query = $db->prepare("INSERT INTO muskeln 
(reihenfolge, name, ursprung, ansatz, innervation, kategorie)
VALUES (?, ?, ?, ?, ?, ?)");
		$query->execute($daten);
	}

	public static function getMuskel($db, $id)
	{
		$abfrage = $db->query("SELECT id, reihenfolge, name, ursprung, ansatz, innervation, kategorie
FROM muskeln WHERE id = $id");
		$abfrage->setFetchMode(PDO::FETCH_CLASS, "Muskel", array());
		$muskel = $abfrage->fetchAll();
		return $muskel;
	}

	public static function updateMuskel($db, $daten)
	{
		$query = $db->prepare("UPDATE muskeln SET reihenfolge = :reihenfolge, name = :muskelName, ursprung = :muskelUrsprung,
	ansatz = :muskelAnsatz, innervation = :muskelInnervation, kategorie = :muskelKategorie
	WHERE id = :muskelID");
		$query->bindValue(":reihenfolge", $daten['reihenfolge'], PDO::PARAM_STR);
		$query->bindValue(":muskelName", $daten['name'], PDO::PARAM_STR);
		$query->bindValue(":muskelUrsprung", $daten['ursprung'], PDO::PARAM_STR);
		$query->bindValue(":muskelAnsatz", $daten['ansatz'], PDO::PARAM_STR);
		$query->bindValue(":muskelInnervation", $daten['innervation'], PDO::PARAM_STR);
		$query->bindValue(":muskelKategorie", $daten['kategorie'], PDO::PARAM_STR);
		$query->bindValue(":muskelID", $daten['id'], PDO::PARAM_INT);
		$query->execute();
	}

	public static function loescheMuskel($db, $id)
	{
		$query = $db->prepare("DELETE FROM muskeln WHERE id= :id");
		$query->bindValue(":id", $id, PDO::PARAM_INT);
		$query->execute();
	}

	public static function checkModified($db)
	{
		$abfrage = $db->query("SELECT UPDATE_TIME
		FROM information_schema.tables
		WHERE TABLE_SCHEMA = 'muskelabcd_muskelDB'
		AND TABLE_NAME = 'muskeln';");
		// $abfrage = $db->query("select update_time
		// from information_schema.tables tab
		// where table_type = 'BASE TABLE'
		//   and table_schema not in ('information_schema', 'sys',
		// 					   'performance_schema','mysql')
		//   -- and table_schema = 'muskeln' 
		// order by update_time desc;");
		return $abfrage;
	}

	public static function getNextReihenfolgeIntByKategorie($db, $kategorie)
	{
		$abfrage = $db->query("SELECT MAX(`reihenfolge`) + 1 AS nextReihenfolgeInt FROM `muskeln` WHERE `kategorie`= $kategorie");
		$abfrage->setFetchMode(PDO::FETCH_ASSOC);
		return $abfrage;
	}

	public static function checkExistingReihenfolge($db, $kategorie, $reihenfolge)
	{
		$abfrage = $db->query("SELECT id AS reihenfolgeIntExists FROM `muskeln` WHERE `kategorie`= $kategorie AND `reihenfolge`= $reihenfolge");
		$abfrage->setFetchMode(PDO::FETCH_ASSOC);
		return $abfrage;
		// $result = $abfrage->execute();
		// $table = $result->fetch(PDO::FETCH_ASSOC);
		// if (empty($result) ) {
		// 	return $table['reihenfolgeIntExists'] = false;
		// } else {
		// 	return $table['reihenfolgeIntExists'] = true;
		// }
	}

	public static function updateReihenfolge($db, $id, $reihenfolge)
	{
		$abfrage = $db->query("UPDATE muskeln SET reihenfolge=$reihenfolge WHERE id=$id");
		$abfrage->setFetchMode(PDO::FETCH_ASSOC);
		return $abfrage;
	}

	public static function increaseAllReihenfolge($db, $kategorie, $reihenfolgeStart)
	{
		$abfrage = $db->query("UPDATE muskeln SET reihenfolge=reihenfolge+1 WHERE kategorie=$kategorie AND reihenfolge>=$reihenfolgeStart");
		$abfrage->setFetchMode(PDO::FETCH_ASSOC);
		return $abfrage;
	}

	public static function decreaseAllReihenfolge($db, $kategorie, $reihenfolgeStart)
	{
		$abfrage = $db->query("UPDATE muskeln SET reihenfolge=reihenfolge-1 WHERE kategorie=$kategorie AND reihenfolge>=$reihenfolgeStart+1");
		$abfrage->setFetchMode(PDO::FETCH_ASSOC);
		return $abfrage;
	}
}
