<?php
require_once('functions/general.php');
session_start();
printHead();

if (!isLogged()) {
	echo "redirectoring to login";
	header('Location: ./login');
} else {
	//echo "<h1>Sprint Vidor</h1>";

	/*
	metti "barra delle funzioni" prima della tabella [solo per allenatori e amministratori]
	(vista archivio vecchie corse, escludi bambini da determinate corse, gestione anagrafica->(inserimento bambini e genitori, gestione relazione bimbi-genitori))
			statistiche bimbi->(elenco bimbi con corse con cui hanno partecipato)
	*/
	printLogout(); /* impagina meglio, metti in barra funzioni per allenatori o in alto a destra per genitori*/

	$idUser = $_SESSION["idUser"];
	//showing upcoming races and:
	// -for parents: clicking a button u can say ur child partcipate or not and show what races your child will partcipate
	// -for trainers: clicking a button u can see what kids will and will not participate 
	$today = today();
	$con = connection();
	$queryResultCorse = mysqli_query($con, "SELECT * FROM corse where dataEvento >= $today ORDER BY dataEvento");
	
	$queryFigli = "SELECT * FROM genitore_di JOIN bimbi on (idBimboFK = idBimbo) WHERE idUserFK = $idUser";
	$queryResultFigliHead = mysqli_query($con, $queryFigli);
	echo "<table name=races border=1> \n";
	echo "<tr> <th>luogo</th> <th>data evento</th> <th>ora</th> <th>indirizzo</th>";
	while ($rowFigliHead = mysqli_fetch_array($queryResultFigliHead)) {
		$nomeFiglioHead = $rowFigliHead["nome"];
		echo "<th> $nomeFiglioHead </th>";
	}
	echo "</tr>";
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
		$queryResultFigli = mysqli_query($con, $queryFigli);
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

			//checking if the kid is allowed to participate to that race
			$queryResultEscluso = mysqli_query($con, "SELECT * FROM partecipa WHERE idCorsaFK = $idCorsa AND idBimboFK = $idFiglio AND escluso = true");
			if (mysqli_num_rows($queryResultEscluso)>0)  $escluso = true;
			else $escluso = false;

			//bottone iscrizione bloccato se iscrizioni per quella corsa sono già terminate e mostra solo una scritta 
			if ($dataChiusuraIscrizioni < today()) { //iscrizioni terminate
				echo "<td> <i>$iscritto</i></td>";
			} else if ($escluso) { //partecipazione non consentita
				echo "<td> <i> Iscrizione non possibile </i> </td>";
			} else { //iscrizioni aperte
				echo "<td> <form action=insertParticipation.php method=POST>
					<input type=hidden name=idBimbo value=$idFiglio>
					<input type=hidden name=idCorsa value=$idCorsa>
					<input type=hidden name=iscritto value=$iscrizione>
					<input type=hidden name=nomeBimbo value=$nomeFiglio>
					<input type=hidden name=dataCorsa value=$dataEvento>
					<input type=hidden name=luogoCorsa value=$luogo>
					<input type=submit name=sub value='$stringToInsert'>
					</form> </td> ";
			}
			
		}

		//showing button for race's info
		if ($_SESSION["isAdmin"] or $_SESSION["isTrainer"])
			echo "<td> <form action=vistaCorse.php method=POST> <input type=hidden name=idCorsa value=$idCorsa> <input type=submit name=sub value=+> </form> </td>";

		echo "</tr> \n";
	}
	echo "</table>";

}

?>