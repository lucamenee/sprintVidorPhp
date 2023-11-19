<title> Dati corsa </title>
<?php
require_once('functions/general.php');
require_once('functions/vistaCorseFunctions.php');
session_start();
printHead();

if (!isLogged()  or (!$_SESSION["isAdmin"] and !$_SESSION["isTrainer"]) and !isset($_POST["postBack"]) and isset($_POST["sub"])) {
	echo "redirectoring to login";
	header('Location: ./login');
} else {
	echo "<form action=./> <input type=submit value='← indietro'> </form>\n";
	
	$idCorsa = $_REQUEST["idCorsa"];	
	$con = connection();
	
	$datiCorsa = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM corse WHERE idCorsa = $idCorsa"));
	$luogo = $datiCorsa["luogo"];
	$posizione = $datiCorsa["posizione"];
	$dataEvento = convertDataIta($datiCorsa["dataEvento"]);
	$iscrizioniAperte = $datiCorsa["dataChiusuraIscrizioni"] >= today();
	$ora = cutSeconds($datiCorsa["ora"]);
	$notePosizione = $datiCorsa["notePosizione"];
	$noteGara = $datiCorsa["noteGara"];
	$linkMaps = $datiCorsa["linkMaps"];

	if ($linkMaps) $stringToPrintLink = "<a href=$linkMaps target='_blank'>$posizione</a>";
	else $stringToPrintLink = $posizione;

	echo "$luogo, $stringToPrintLink - $dataEvento, $ora <br> \n";
	if ($notePosizione) echo "Posizione: $notePosizione <br> \n";
	if ($noteGara) echo "Note gara: $noteGara <br> \n";
	echo "iscrizioni ";
	if ($iscrizioniAperte) 
		echo "aperte";
	else 
		echo "chiuse";

	if ($_SESSION["isAdmin"]) {
		echo "<form action=./inserimentoCorse method=GET> 
			<input type=hidden name=idCorsa value=$idCorsa>		
			<input type=submit name=subMod value='modifica dati gara'> 
			</form>\n";
	}
	
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