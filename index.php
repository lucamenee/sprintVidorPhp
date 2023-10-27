<?php
require_once('functions/general.php');
session_start();

if (!isLogged()) {
	echo "redirectoring to login";
	header('Location: ./login');
} else {
	echo "<h1>Sprint Vidor</h1>";
	
	/*
	if ($_SESSION["isParent"] and (!$_SESSION["isTrainer"] or !$_SESSION["isAdmin"])) {
		echo "solo GENITORE";
		//redirect to parent stuff (loading child participation)
	}
	else {
		echo "NON solo GENITORE";
		//printing links to what they are able to do
	}
	*/

	$idUser = $_SESSION["idUser"];
	/* showing upcoming races and:
	-for parents: clicking a button u can say ur child partcipate or not and show what races your child willl partcipate
	-for trainers: clicking a button u can see what kids will and will not participate */
	$today = date_create()->format('Y-m-d');
	$con = connection();
	$queryResultCorse = mysqli_query($con, "SELECT * FROM corse where dataEvento >= $today");

	echo "<table name=races border=1> \n";
	echo "<tr> <th>luogo</th> <th>data evento</th> <th>ora</th> <th>indirizzo</th> </tr>";
	while ($row = mysqli_fetch_array($queryResultCorse)) {
		$idCorsa = $row["idCorsa"];
		$luogo = $row["luogo"];
		$dataEvento = $row["dataEvento"];
		$dataChiusuraIscrizioni = $row["dataChiusuraIscrizioni"];
		$ora = cutSeconds($row["ora"]);
		$via = $row["via"];
		$civico = $row["civico"];
		$provincia = $row["provincia"];
		$linkMaps = $row["linkMaps"];
		$notePosizione = $row["notePosizione"];
		$noteGara = $row["noteGara"];

		echo "<tr> <td>$luogo</td> <td>$dataEvento</td> <td>$ora</td> <td>via $via"; 
		if ($civico != NULL) 
			echo ", $civico"; 
		//per ogni bambino di cui è genitore devo fare pulsante per iscrivere figli/o
			//se il bambino è già iscritto non mostro un pulsante per iscriverlo ma per disiscriverlo
		//se non è genitore non devo mostrare quel pulsante ma solo quello per vedere la lista completa degli iscritti
		echo "</td>"; 

		$queryResultFigli = mysqli_query($con, "SELECT * FROM genitore_di JOIN bimbi on (idBimboFK = idBimbo) WHERE idUserFK = $idUser");
		while ($rowFigli = mysqli_fetch_array($queryResultFigli)) {
			$nomeFiglio = $rowFigli["nome"];
			$idFiglio = $rowFigli["IdBimbo"];

			$queryResultParticipation = mysqli_query($con, "SELECT * FROM partecipa WHERE idCorsaFK = $idCorsa AND idBimboFK = $idFiglio");
			if (mysqli_num_rows($queryResultParticipation)>0) 
				$stringToInsert = "disiscrivi";
			else 
				$stringToInsert = "iscrivi";
			echo "<td> <a href=insertParticipation.php?idFiglio=$idFiglio> <button>$stringToInsert $nomeFiglio</button> </a> </td>";
		}

		echo "</tr> \n";
	}
	echo "</table>";


	
	
	printLogout(); //da mettere a fine pagina o comunque impaginato bene
}

?>