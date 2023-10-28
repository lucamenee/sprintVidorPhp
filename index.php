<?php
require_once('functions/general.php');
session_start();

if (!isLogged()) {
	echo "redirectoring to login";
	header('Location: ./login');
} else {
	echo "<h1>Sprint Vidor</h1>";

	$idUser = $_SESSION["idUser"];
	/* showing upcoming races and:
	-for parents: clicking a button u can say ur child partcipate or not and show what races your child will partcipate
	-for trainers: clicking a button u can see what kids will and will not participate */
	$today = today();
	$con = connection();
	$queryResultCorse = mysqli_query($con, "SELECT * FROM corse where dataEvento >= $today ORDER BY dataEvento");

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
					<input type=hidden name=nomeBimbo value=$nomeFiglio>
					<input type=hidden name=dataCorsa value=$dataEvento>
					<input type=hidden name=luogoCorsa value=$luogo>
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


	
	/*
	aggiugni bottone che permetta di escludere bambini in determinate gare
		scegli se farlo:
		 .per ogni gara pulsante a finco che apre pagina per escludere gente
		 .metti link alla fine a pagina che con due combobox selezioni bambino e corsa per cui è escluso
	*/
	
	printLogout(); //da mettere a fine pagina o comunque impaginato bene
}

?>