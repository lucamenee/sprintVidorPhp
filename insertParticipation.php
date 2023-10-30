<?php
require_once('functions/general.php');
session_start();
printHead();

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

	if(isset($_POST["pagPrec"])) $gotoPag = $_POST["pagPrec"];
	else $gotoPag = "index.php";

	if ($_POST["sub"] == 'annulla') {
		echo "<h2> $stringPostConferma non confermata </h2>";
		header("Refresh:1.5; URL= $gotoPag");
	} else if ($_POST["sub"] == 'conferma') {
		if ($iscritto) {
			$queryResult = mysqli_query($con, "UPDATE partecipa SET iscritto=false WHERE idBimboFK = $idBimbo AND idCorsaFK = $idCorsa");
		} else {
			$queryResult = mysqli_query($con, "INSERT INTO partecipa (idBimboFK, idCorsaFK, iscritto, escluso) VALUES ($idBimbo, $idCorsa, true, false)");
			$queryResult = mysqli_query($con, "UPDATE partecipa SET iscritto=true, escluso=false WHERE idBimboFK = $idBimbo AND idCorsaFK = $idCorsa");
		}
		
		echo "<h2> $stringPostConferma confermata </h2>";
		header("Refresh:1.5; URL= $gotoPag");
	} else {

		$nomeBimbo = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM bimbi WHERE IdBimbo=$idBimbo"))["nome"];
		$luogoCorsa = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM corse WHERE IdCorsa=$idCorsa"))["luogo"];
		$dataCorsa = convertDataIta(mysqli_fetch_array(mysqli_query($con, "SELECT * FROM corse WHERE IdCorsa=$idCorsa"))["dataEvento"]);
		

		//form per conferma iscrizione/cancellazione iscrizione
		echo "<form action=# method=POST>\n";
		if ($iscritto)
			$stringPreConferma = "disiscrizione";
		else 
			$stringPreConferma = "iscrizione";

		echo "Conferma $stringPreConferma di $nomeBimbo per la gara di $luogoCorsa del $dataCorsa <br>\n";
		echo "<input type=submit name=sub value=conferma> <input type=submit name=sub value=annulla>\n";
		echo "<input type=hidden name=idBimbo value=$idBimbo>
			<input type=hidden name=idCorsa value=$idCorsa>
			<input type=hidden name=iscritto value=$iscritto>
			<input type=hidden name=pagPrec value=$gotoPag>";
		echo "</form>";
	}

}

?>