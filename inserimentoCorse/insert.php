<title> Inserimento corsa </title>
<?php
require_once('../functions/general.php');
session_start();
printHead();

if (!isLogged() or (!$_SESSION["isAdmin"] and !$_SESSION["isTrainer"])) {
	echo "redirectoring to login";
	header('Location: ../login');
} else {
	$con = connection();
	if (!isset($_POST["sub"])) header('Location: ./');

	//required
	$luogo = $_POST["luogo"];
	$dataEvento = $_POST["dataEvento"];
	$dataChiusuraIscrizioni = $_POST["dataChiusuraIscrizioni"];
	$ora = $_POST["ora"];
	$via = $_POST["via"];

	//not required
	if (isset($_POST["civico"]) and $_POST["civico"]) $civico = $_POST["civico"];
	else $civico = 'NULL';

	if (isset($_POST["provincia"]) and $_POST["provincia"]) $provincia = $_POST["provincia"];
	else $provincia = "'TV'";

	if (isset($_POST["linkMaps"]) and $_POST["linkMaps"]) $linkMaps = $_POST["linkMaps"];
	else $linkMaps = 'NULL';

	if (isset($_POST["notePosizione"]) and $_POST["notePosizione"]) $notePosizione = $_POST["notePosizione"];
	else $notePosizione = 'NULL';

	if (isset($_POST["noteGara"]) and $_POST["noteGara"]) $noteGara = $_POST["noteGara"];
	else $noteGara = 'NULL';

	$query = "INSERT INTO corse (luogo, dataEvento, dataChiusuraIscrizioni, ora, via, civico, provincia, linkMaps, notePosizione, noteGara) VALUES ('$luogo', '$dataEvento', '$dataChiusuraIscrizioni', '$ora:00', $via, $civico, $provincia, $linkMaps, $notePosizione, $noteGara)";


	if (mysqli_query($con, $query)) {
		echo "<h2> Inserimento confermato </h2>";
		header("Refresh:1.5; URL= ../");
	} else {
		echo "<h2> Inserimento non avvenuto correttamente </h2>";
		header("Refresh:1.5; URL= ./");
	}
	

}