<?php
require_once('functions/general.php');
session_start();

if (!isLogged() or !isset($_POST["sub"])) {
	echo "redirectoring to login";
	header('Location: ./login');
} else {
	echo "<h1>Sprint Vidor</h1>";

	$idBimbo = $_POST["idBimbo"];
	$idCorsa = $_POST["idCorsa"];
	$iscritto = $_POST["iscritto"];

	$con = connection();
	if ($iscritto) $stringPostConferma = "disiscrizione";
	else $stringPostConferma = "iscrizione";

	if ($_POST["sub"] == 'annulla') {
		echo "<h2> $stringPostConferma non confermata </h2>";
		header('Refresh:1.5; URL= index.php');
	} else if ($_POST["sub"] == 'conferma') {
		if ($iscritto) {
			$queryResult = mysqli_query($con, "UPDATE partecipa SET iscritto=false WHERE idBimboFK = $idBimbo AND idCorsaFK = $idCorsa");
		} else {
			$queryResult = mysqli_query($con, "INSERT INTO partecipa (idBimboFK, idCorsaFK, iscritto) VALUES ($idBimbo, $idCorsa, true)");
			$queryResult = mysqli_query($con, "UPDATE partecipa SET iscritto=true WHERE idBimboFK = $idBimbo AND idCorsaFK = $idCorsa");
		}
		
		echo "<h2> $stringPostConferma confermata </h2>";
		header("Refresh:1.5; URL= index.php");
	} else {

		$nomeBimbo = $_POST["nomeBimbo"];
		$luogoCorsa = $_POST["luogoCorsa"];
		$dataCorsa = $_POST["dataCorsa"];
		

		//form per conferma iscrizione/cancellazione iscrizione
		echo "<form action=# method=POST>\n";
		if ($iscritto)
			$stringPreConferma = "disiscrizione";
		else 
			$stringPreConferma = "iscrizione";

		echo "Conferma $stringPreConferma di $nomeBimbo per la gara di $luogoCorsa del $dataCorsa <br>\n";
		echo "<input type=submit submit name=sub value=conferma> <input type=submit name=sub value=annulla>\n";
		echo "<input type=hidden name=idBimbo value=$idBimbo>
			<input type=hidden name=idCorsa value=$idCorsa>
			<input type=hidden name=iscritto value=$iscritto>";
		echo "</form>";
	}

}

?>