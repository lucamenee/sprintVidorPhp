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
	$queryResultCorse = mysqli_query($con, "SELECT * FROM corse where dataEvento between '$anno/01/01' and '$anno/12/31' ORDER BY dataEvento");
	if (mysqli_num_rows($queryResultCorse)) {

		echo "<table class=corsePrinc border=1> \n";
		echo "<tr> <th>Luogo</th> <th>Data evento</th> <th>Ora</th> <th>Indirizzo</th> <th>Partecipanti</th> <th>Non partecipanti</th> <th> Modifica dati </th></tr>";
		while ($row = mysqli_fetch_array($queryResultCorse)) {
			$idCorsa = $row["idCorsa"];
			$luogo = $row["luogo"];
			$dataEvento =  convertDataIta($row["dataEvento"]);
			$ora = cutSeconds($row["ora"]);
			$posizione = $row["posizione"];
			$linkMaps = $row["linkMaps"];

			if ($linkMaps) $stringToPrintLink = "<a href=$linkMaps> $posizione </a>";
			else $stringToPrintLink = $posizione;

			echo "<tr> <td>$luogo</td> <td>$dataEvento</td> <td>$ora</td> <td>$stringToPrintLink </td>"; 

			/*
			printa numero partecipanti e n non partecipanti (tieni conto dichi non ha effettuato la scelta)
			*/
			$nPartecipanti = mysqli_num_rows(mysqli_query($con, "SELECT * FROM partecipa WHERE idCorsaFK = $idCorsa and iscritto=true and escluso=false"));
			$indecisi = mysqli_num_rows(mysqli_query($con, "SELECT * FROM bimbi b WHERE NOT EXISTS (SELECT 1 FROM partecipa bc WHERE bc.IdBimboFK = b.IdBimbo AND bc.idCorsaFK = $idCorsa)"));
			$nNonPartecipanti = $indecisi + mysqli_num_rows(mysqli_query($con, "SELECT *  FROM partecipa WHERE idCorsaFK = $idCorsa and (iscritto=false or escluso=true)"));
			
			echo "<td> $nPartecipanti </td> <td> $nNonPartecipanti </td>";
			echo "<td> <form action='../vistaCorse.php' method=POST class=nullSpace> <input type=hidden name=idCorsa value=$idCorsa> <input type=submit name=subMod value='modifica'> </form> </td>";

			echo "</tr> \n";
		}
		echo "</table>";
	} else {
		echo "<h2 class=titoloH> Nessuna corsa trovata per l'anno $anno </h2>";
	}

}