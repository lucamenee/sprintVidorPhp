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
	$today = today();
	$con = connection();
	$queryResultCorse = mysqli_query($con, "SELECT * FROM corse where dataEvento >= $today");

	echo "<table name=races border=1> \n";
	echo "<tr> <th>luogo</th> <th>data evento</th> <th>ora</th> <th>indirizzo</th> </tr>";
	while ($row = mysqli_fetch_array($queryResultCorse)) {
		$idCorsa = $row["idCorsa"];
		$luogo = $row["luogo"];
		$dataEvento =  convertDataIta($row["dataEvento"]);
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

		//showing childs' subscription buttton
		$queryResultFigli = mysqli_query($con, "SELECT * FROM genitore_di JOIN bimbi on (idBimboFK = idBimbo) WHERE idUserFK = $idUser");
		while ($rowFigli = mysqli_fetch_array($queryResultFigli)) {
			$nomeFiglio = $rowFigli["nome"];
			$idFiglio = $rowFigli["IdBimbo"];

			$queryResultParticipation = mysqli_query($con, "SELECT * FROM partecipa WHERE idCorsaFK = $idCorsa AND idBimboFK = $idFiglio AND iscritto = true");
			if (mysqli_num_rows($queryResultParticipation)>0) {
				$stringToInsert = "disiscrivi";
				$iscrizione = true;
				$iscritto = "iscritto";
			} else {
				$stringToInsert = "iscrivi";
				$iscrizione = false;
				$iscritto = "non iscritto";
			}

			//blocca bottone iscrizione e mostra solo una scritta se iscrizioni per quella corsa sono già terminate
			if ($dataChiusuraIscrizioni < today()) {
				echo "<td>$nomeFiglio $iscritto</td>";
			} else {
				echo "<td> <form action=insertParticipation.php method=POST> 
					<input type=hidden name=idBimbo value=$idFiglio>
					<input type=hidden name=idCorsa value=$idCorsa>
					<input type=hidden name=iscritto value=$iscrizione>
					<input type=submit name=sub value='$stringToInsert $nomeFiglio'>
					</form> </td> ";
			}
			/*
			.inserisci modo per non permettere l'iscrizione al quel determinato bambino a quella gara 
			(non mostrare bottone ma scritta in corsivo tipo: "iscrizione non possibile")
			*/
		}

		//showing button for race's info
		if ($_SESSION["isAdmin"] or $_SESSION["isTrainer"])
			echo "<td> <form action=vistaCorse.php method=POST> <input type=hidden name=idCorsa value=$idCorsa> <input type=submit name=sub value=+> </form> </td>";

		echo "</tr> \n";
	}
	echo "</table>";


	
	
	printLogout(); //da mettere a fine pagina o comunque impaginato bene
}

?>