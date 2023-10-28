<?php
require_once('functions/general.php');
require_once('functions/vistaCorseFunctions.php');
session_start();

if (!isLogged() or !isset($_POST["sub"]) or !$_SESSION["isAdmin"] or !$_SESSION["isTrainer"]) {
	echo "redirectoring to login";
	header('Location: ./login');
} else {
	echo "<h1>Sprint Vidor</h1>";
	echo "<form action=./> <input type=submit value='← indietro'> </form>";

	$idCorsa = $_POST["idCorsa"];
	$con = connection();
	
	$datiCorsa = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM corse WHERE idCorsa = $idCorsa"));
	$luogo = $datiCorsa["luogo"];
	$via = $datiCorsa["via"];
	$civico = $datiCorsa["civico"];
	$provincia = $datiCorsa["provincia"];
	$dataEvento = convertDataIta($datiCorsa["dataEvento"]);
	$iscrizioniAperte = $datiCorsa["dataChiusuraIscrizioni"] >= today();
	$ora = cutSeconds($datiCorsa["ora"]);
	
	echo "$luogo, via $via $civico $provincia - $dataEvento, $ora <br> \n iscrizioni ";
	if ($iscrizioniAperte) 
		echo "aperte";
	else 
		echo "chiuse";
	
	//tabella degli iscritti
	createTableRaceKids(1, $idCorsa);
	//tabella dei non iscritti (metti possibilità di poter iscrivere gente)	
	createTableRaceKids(0, $idCorsa);
	//tabella di chi non ha effettuato la scelta (metti possibilità di poter iscrivere gente)
	createTableRaceKids(-1, $idCorsa);

	//tabella di chi non ha deciso [bimbi non presenti nella tabella "partecipa"] (metti possibilità di poter iscrivere gente)
	
}

?>