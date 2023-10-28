<?php
require_once('functions/general.php');
session_start();

if (!isLogged() or !isset($_POST["sub"])) {
	echo "redirectoring to login";
	header('Location: ./login');
} else {
	echo "<h1>Sprint Vidor</h1>";

	//getting data to insert from ./prossimeCorse/index.php and executing the insert
	$idBimbo = $_POST["idBimbo"];
	$idCorsa = $_POST["idCorsa"];
	$iscritto = $_POST["iscritto"];
	$con = connection();

	/*
	aggiungi form per conferma iscrizione/cancellazione iscrizione
	*/

	if ($iscritto) {
		$queryResult = mysqli_query($con, "UPDATE partecipa SET iscritto=false WHERE idBimboFK = $idBimbo AND idCorsaFK = $idCorsa");
	} else {
		$queryResult = mysqli_query($con, "INSERT INTO partecipa (idBimboFK, idCorsaFK, iscritto) VALUES ($idBimbo, $idCorsa, true)");
		$queryResult = mysqli_query($con, "UPDATE partecipa SET iscritto=true WHERE idBimboFK = $idBimbo AND idCorsaFK = $idCorsa");
	}
	echo "UPDATE partecipa SET iscritto=false WHERE idBimboFK = $idBimbo AND idCorsaFK = $idCorsa";
	header('location: index.php');
}

?>