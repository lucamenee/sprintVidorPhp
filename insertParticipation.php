<?php
require_once('functions/general.php');
session_start();

if (!isLogged() or !isset($_POST["sub"])) {
	echo "redirectoring to login";
	header('Location: ./login');
} else {
	echo "<h1>Sprint Vidor</h1>";

	//getting data to insert from ./prossimeCorse/index.php and executing the insert
	$idBimbo = $_POST["idFiglio"];
	$idCorsa = $_POST["idCorsa"];
	$iscritto = $_POST["iscritto"];
	$con = connection();
	if ($iscritto) {
		$queryResult = mysqli_query($con, "DELETE FROM partecipa WHERE idBimboFK = $idBimbo AND idCorsaFK = $idCorsa");
	} else {
		$queryResult = mysqli_query($con, "INSERT INTO partecipa (idBimboFK, idCorsaFK) VALUES ($idBimbo, $idCorsa)");
	}

	header('location: index.php');
}

?>