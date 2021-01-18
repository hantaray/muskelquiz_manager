<?php
include("lib/db.php");
include("models/benutzer.php");
include("models/muskel.php");
// include("lib/functions.php");

session_start();


if(isset($_GET["logout"])){
	$_SESSION = array();
	session_destroy();
	header("Location:../index.php");
}

if(isset($_POST["benutzer"]))
{
	$benutzerDaten = Benutzer::getBenutzerDaten($db);
	foreach($benutzerDaten as $einBenutzerDaten){	
		if($_POST["benutzer"] == $einBenutzerDaten['benutzername'] && $_POST["passwort"] == $einBenutzerDaten['password'])
		{
			$_SESSION["benutzer"] = $_POST["benutzer"];
		}
	}
	if(!isset($_SESSION["benutzer"]))
	{
		exit("<p>Kein Zugang. Bitte überprüfen Sie den Benutzernamen und das Passwort.<br />
		<a href='../index.php?aktion=login'>Zum Login</a></p>");
	}
}
elseif(!isset($_SESSION["benutzer"]))
	{
		exit("<p>Kein Zugang. Bitte überprüfen Sie den Benutzernamen und das Passwort.<br />
		// <a href='../index.php?aktion=login'>Zum Login</a>");
	}

if (isset($db)) {

	$aktion = isset($_REQUEST['aktion']) ? $_REQUEST['aktion'] : null;
	$view = $aktion;

	switch ($aktion) {

		case "bearbeiten":
			$id = $_REQUEST['id'];
			$muskel = Muskel::getMuskel($db, $id);

			if (isset($_POST['speichern'])) {
				// if(validiereMuskel($_POST) === true){

				// Keep Kategorie, so we don't have to handle reihenfolge-id
				$kategorie = $muskel[0]->getKategorie();
				// set prvious Kategorie if not changed
				// if ($_POST['kategorie'] != 0) {
				// 	$kategorie = $_POST['kategorie'];
				// }

				$daten = array(
					"reihenfolge" => $_POST['reihenfolge'],
					"name" => $_POST['name'],
					"ursprung" => $_POST['ursprung'],
					"ansatz" => $_POST['ansatz'],
					"innervation" => $_POST['innervation'],
					"kategorie" => $kategorie,
					"id" => $id
				);

				$reihenfolgeId = $muskel[0]->getReihenfolge();;

				// Check if reihenfolge has changed
				if ($reihenfolgeId != $daten['reihenfolge']) {
					// If reihenfolge has changed, check if reichenfolge exists
					$result = Muskel::checkExistingReihenfolge($db,  $daten['kategorie'], $daten['reihenfolge']);
					$reihenfolge = $result->fetch();
					$muskelId = $reihenfolge['reihenfolgeIntExists'];
					// If reihenfolge exists, change reihenfolge of existing id (swap reihenfolge)
					if ($muskelId) {
						Muskel::updateReihenfolge($db, $muskelId, $reihenfolgeId);
					}
				}

				Muskel::updateMuskel($db, $daten);
				header("Location: index.php");
				// 	}else{
				// 		$fehler = validiereMuskel($_POST);	
				// 	}
			}
			if (isset($_POST['abbrechen'])) {
				header("Location: index.php");
			}
			$view = "bearbeiten";
			break;

		case "delete":
			$id = $_REQUEST['id'];
			$muskel = new Muskel();
			$muskel = Muskel::getMuskel($db, $id);
			Muskel::loescheMuskel($db, $id);
			Muskel::decreaseAllReihenfolge($db, $muskel[0]->getKategorie(), $muskel[0]->getReihenfolge());
			header("Location: index.php");
			break;

		case "reihenfolgeSetzen":
			$id = $_REQUEST['id'];
			$kategorie = $_REQUEST['kategorie'];
			$nextReihenfolge =  Muskel::getNextReihenfolgeIntByKategorie($db, $kategorie);
			header("Location: index.php?aktion=anlegen");
			break;

		case "anlegen":
			if (isset($_POST['speichern'])) {
				//Prüfe Daten auf Validität
				// if(validiereMuskel($_POST) === true){
				//Speichere in DB
				$daten = array(
					$_POST['reihenfolge'],
					$_POST['name'],
					$_POST['ursprung'],
					$_POST['ansatz'],
					$_POST['innervation'],
					$_POST['kategorie']
				);

				// If reihenfolge exists (entry is inserted)
				$result = Muskel::checkExistingReihenfolge($db, $_POST['kategorie'], $_POST['reihenfolge']);
				$reihenfolge = $result->fetchAll();
				if ($reihenfolge[0]['reihenfolgeIntExists']) {
					Muskel::increaseAllReihenfolge($db, $_POST['kategorie'], $_POST['reihenfolge']);
				}
				// raise all reihenfolge from new reihenfolge
				// insert Muskel
				Muskel::insertMuskel($db, $daten);
				header("Location: index.php");
				// } else{
				// $fehler = validiereMuskel($_POST);	
				// }
			}
			$view = "anlegen";
			break;

			// case "impressum":
			// $view = "impressum";
			// break;

		case "login":
			$view = "login";
			break;

		case "logout":
			$view = "login";
			break;

		default:
			$muskeln = Muskel::getMuskeln($db);
			$view = "allesAnzeigen";
			break;
	}

	include("views/" . $view . ".tpl.php");
}
