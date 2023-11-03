<title> Archivio corse </title>


<?php
require_once('../functions/general.php');
session_start();
printHead();

if (!isLogged() or (!$_SESSION["isAdmin"] and !$_SESSION["isTrainer"])) {
	echo "redirectoring to login";
	header('Location: ./login');
} else {
	echo "<form action=../> <input type=submit value='← indietro'> </form>";

	if (isset($_POST["anno"])) $anno =$_POST["anno"];
	else $anno = '2023';

	echo "<form action=# method=POST> Anno: <input type=number value=$anno name=anno> <input type=submit value=cerca></form> \n";

	
	$con = connection();
	$queryResultCorse = mysqli_query($con, "SELECT * FROM corse where dataEvento >= '$anno/01/01' ORDER BY dataEvento");
	if (mysqli_num_rows($queryResultCorse)) {

		echo "<table class=corsePrinc border=1> \n";
		echo "<tr> <th>luogo</th> <th>data evento</th> <th>ora</th> <th>indirizzo</th> <th>partecipanti</th> <th>non partecipanti</th></tr>";
		while ($row = mysqli_fetch_array($queryResultCorse)) {
			$idCorsa = $row["idCorsa"];
			$luogo = $row["luogo"];
			$dataEvento =  convertDataIta($row["dataEvento"]);
			$ora = cutSeconds($row["ora"]);
			$via = $row["via"];
			$civico = $row["civico"];
			$provincia = $row["provincia"];
			$linkMaps = $row["linkMaps"];

			$stringToPrintPosizione = "via $via, $civico $provincia";
			if ($linkMaps) $stringToPrintLink = "<a href=$linkMaps> $stringToPrintPosizione </a>";
			else $stringToPrintLink = $stringToPrintPosizione;

			echo "<tr> <td>$luogo</td> <td>$dataEvento</td> <td>$ora</td> <td>$stringToPrintLink </td>"; 

			/*
			printa numero partecipanti e n non partecipanti (tieni conto dichi non ha effettuato la scelta)
			*/
			$nPartecipanti = mysqli_fetch_array(mysqli_query($con, "SELECT count(*) as c FROM partecipa WHERE idCorsaFK = $idCorsa and iscritto=true and escluso=false"))["c"];
			$indecisi = mysqli_fetch_array(mysqli_query($con, "SELECT count(*) AS c FROM bimbi b WHERE NOT EXISTS (SELECT 1 FROM partecipa bc WHERE bc.IdBimboFK = b.IdBimbo AND bc.idCorsaFK = $idCorsa)"))["c"];
			$nNonPartecipanti = mysqli_fetch_array(mysqli_query($con, "SELECT count(*) as c FROM partecipa WHERE idCorsaFK = $idCorsa and (iscritto=false or escluso=true)"))["c"];

			echo "<td> $nPartecipanti </td> <td>" . $nNonPartecipanti+$indecisi ." </td>";

			echo "</tr> \n";
		}
		echo "</table>";
	} else {
		echo "<h2 class=titoloH> Nessuna corsa trovata per l'anno $anno </h2>";
	}

}