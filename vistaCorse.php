<?php
require_once('functions/general.php');
session_start();

if (!isLogged() or !isset($_POST["sub"]) or !$_SESSION["isAdmin"] or !$_SESSION["isTrainer"]) {
	echo "redirectoring to login";
	header('Location: ./login');
} else {
	echo "<h1>Sprint Vidor</h1>";
	echo "<form action=./> <input type=submit value='<-'> </form>";

	//getting data to insert from ./prossimeCorse/index.php and executing the select
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
	
	echo "$luogo via $via, $civico $provincia - $dataEvento, $ora <br> \n iscrizioni ";
	if ($iscrizioniAperte) 
		echo "aperte";
	else 
		echo "chiuse";
	
	//tabella degli iscritti
	$queryResultKids = mysqli_query($con, "SELECT * FROM partecipa JOIN bimbi ON (idBimboFK = idBimbo) JOIN categorie ON (idCatFK = idCat) WHERE idCorsaFK=$idCorsa and iscritto=true");
	echo "<h2> Iscritti </h2>\n";
	echo "<table border=1>\n";
	echo "<tr> <th>Nome</th> <th>Cognome</th> <th>Data di nascita</th> <th>Categoria</th> </tr>\n";
	while ($row = mysqli_fetch_array($queryResultKids)) {
		$nome = $row["nome"];
		$cognome = $row["cognome"];
		$dataNascita =  convertDataIta($row["dataNascita"]);
		$categoria = $row["Descrizione"];

		echo "<tr> <td> $nome </td> <td> $cognome </td> <td> $dataNascita </td> <td> $categoria </td> </tr> \n";

	}
	echo "</table>\n";

	//tabella dei non iscritti (metti possibilità di poter iscrivere gente)


	//tabella di chi non ha deciso [bimbiS non presenti nella tabella "partecipa"] (metti possibilità di poter iscrivere gente)
	
}

?>