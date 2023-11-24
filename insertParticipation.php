<title> Inserimento partecipazione </title>
<?php
require_once('functions/general.php');
session_start();
printHead();

if (!isLogged() or !isset($_POST["sub"])) {
	echo "redirectoring to login";
	header('Location: ./login');
} else {
	$idBimbo = $_POST["idBimbo"];
	$idCorsa = $_POST["idCorsa"];
	if ($_POST["sub"] == "non partecipa") {
		$iscritto = true;
	} else {
		$iscritto = $_POST["iscritto"];
	}
	if (isset($_POST["escludi"])) 
		$escludi = $_POST["escludi"];
	else 
		$escludi=0;

	$con = connection();
	if ($escludi) $stringPostConferma = "esclusione";
	else if ($iscritto) $stringPostConferma = "disiscrizione";
	else $stringPostConferma = "iscrizione";

	if(isset($_POST["pagPrec"])) $gotoPag = $_POST["pagPrec"];
	else $gotoPag = "index.php";

	if ($_POST["sub"] == 'annulla') {
		echo "<h2> $stringPostConferma non confermata </h2>";
		header("Refresh:1.5; URL= $gotoPag");
	} else if ($_POST["sub"] == 'conferma') {
		if ($iscritto) {
			$queryResult = mysqli_query($con, "INSERT INTO partecipa (idBimboFK, idCorsaFK, iscritto, escluso) VALUES ($idBimbo, $idCorsa, false, false)");
			$queryResult = mysqli_query($con, "UPDATE partecipa SET iscritto=0, escluso=$escludi WHERE idBimboFK = $idBimbo AND idCorsaFK = $idCorsa");
		} else {
			$queryResult = mysqli_query($con, "INSERT INTO partecipa (idBimboFK, idCorsaFK, iscritto, escluso) VALUES ($idBimbo, $idCorsa, true, false)");
			$queryResult = mysqli_query($con, "UPDATE partecipa SET iscritto=true, escluso=$escludi WHERE idBimboFK = $idBimbo AND idCorsaFK = $idCorsa");
		}
		
		echo "<h2> $stringPostConferma confermata </h2>";
		header("Refresh:1.5; URL= $gotoPag");
	} else {

		$nomeBimbo = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM bimbi WHERE IdBimbo=$idBimbo"))["nome"];
		$luogoCorsa = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM corse WHERE IdCorsa=$idCorsa"))["luogo"];
		$dataCorsa = convertDataIta(mysqli_fetch_array(mysqli_query($con, "SELECT * FROM corse WHERE IdCorsa=$idCorsa"))["dataEvento"]);
		

		//form per conferma iscrizione/cancellazione iscrizione
		echo "<form action=# method=POST class='iscrizione'>\n";
		if ($escludi) $stringPreConferma = "esclusione";
		else if ($iscritto) $stringPreConferma = "disiscrizione";
		else $stringPreConferma = "iscrizione";

		echo "<h2> Conferma $stringPreConferma di $nomeBimbo per la gara di $luogoCorsa del $dataCorsa <h2> <br>\n";
		echo "<input type=submit name=sub value=conferma> <input type=submit name=sub value=annulla>\n";
		echo "<input type=hidden name=idBimbo value=$idBimbo>
			<input type=hidden name=idCorsa value=$idCorsa>
			<input type=hidden name=iscritto value=$iscritto>
			<input type=hidden name=pagPrec value=$gotoPag>
			<input type=hidden name=escludi value=$escludi>";
		echo "</form>";
	}

}

?>