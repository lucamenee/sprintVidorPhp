<title> Inserimento corsa </title>
<?php
require_once('../functions/general.php');
session_start();
printHead();

if (!isLogged() or !$_SESSION["isAdmin"]) {
	echo "redirectoring to login";
	header('Location: ../login');
} else {
	$con = connection();
	if (!isset($_POST["sub"])) header('Location: ./');
	$esegui=true;

	//required
	$luogo = $_POST["luogo"];
	$dataEvento = $_POST["dataEvento"];
	$dataChiusuraIscrizioni = $_POST["dataChiusuraIscrizioni"];
	$ora = $_POST["ora"];
	$posizione = $_POST["posizione"];
	$idCorsa = $_POST["idCorsa"];

	//not required
	if (isset($_POST["linkMaps"]) and $_POST["linkMaps"]) $linkMaps = insertAst($_POST["linkMaps"]);
	else $linkMaps = 'NULL';

	if (isset($_POST["notePosizione"]) and $_POST["notePosizione"]) $notePosizione = insertAst($_POST["notePosizione"]);
	else $notePosizione = 'NULL';

	if (isset($_POST["noteGara"]) and $_POST["noteGara"]) $noteGara = insertAst($_POST["noteGara"]);
	else $noteGara = 'NULL';

	if ($_POST["sub"] == "Modifica") {
		$stringToInsertConferma="Modifica confermata";
		$query = "UPDATE corse SET luogo='$luogo', dataEvento='$dataEvento', dataChiusuraIscrizioni='$dataChiusuraIscrizioni', ora='$ora', posizione='$posizione', linkMaps=$linkMaps, notePosizione=$notePosizione, noteGara=$noteGara WHERE idCorsa=$idCorsa";
	} else {
		$stringToInsertConferma="Inserimento confermato";
		if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM corse WHERE luogo='$luogo' and dataEvento='$dataEvento' and ora='$ora:00'"))) {
			echo "<h2> Corsa già presente </h2>";
			$esegui=false;
			header("Refresh:1.5; URL= ./");
		} else
			$query = "INSERT INTO corse (luogo, dataEvento, dataChiusuraIscrizioni, ora, posizione, linkMaps, notePosizione, noteGara) VALUES ('$luogo', '$dataEvento', '$dataChiusuraIscrizioni', '$ora:00', '$posizione', $linkMaps, $notePosizione, $noteGara)";		
	}

	if ($esegui) {
		if (mysqli_query($con, $query)) {
			echo "<h2> $stringToInsertConferma </h2>";
			header("Refresh:1.5; URL= ../");
		} else {
			echo "<h2> Update non avvenuto correttamente </h2>";
			header("Refresh:1.5; URL= ./");
		}
	}
	

}