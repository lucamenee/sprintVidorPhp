<?php
require_once('functions/general.php');
require_once('functions/vistaCorseFunctions.php');
session_start();
printHead();

if ((!isLogged()  or !$_SESSION["isAdmin"] or !$_SESSION["isTrainer"]) and !isset($_POST["postBack"]) and isset($_POST["sub"])) {
	echo "redirectoring to login";
	header('Location: ./login');
} else {
	//echo "<h1>Sprint Vidor</h1>";
	echo "<form action=./> <input type=submit value='← indietro'> </form>";

	$idCorsa = $_REQUEST["idCorsa"];
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
	
	if (isset($_POST["postBack"]) and $_POST["postBack"] != "fine modifica") 
		$valueModifica = "fine modifica";
	else
		$valueModifica = "modifica";	
	echo "<form action=# method=POST> <input type=submit name=postBack value='$valueModifica'> <input type=hidden name=idCorsa value=$idCorsa> </form>";
	//tabella degli iscritti
	createTableRaceKids(1, $idCorsa);
	//tabella dei non iscritti
	createTableRaceKids(0, $idCorsa);
	//tabella di chi non ha effettuato la scelta
	createTableRaceKids(-1, $idCorsa);
	//tabella di chi è escluso
	createTableRaceKids(-2, $idCorsa);
}

?>