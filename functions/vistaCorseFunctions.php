<?php
require_once('functions/general.php');



function createTableRaceKids($iscritti, $idCorsa) { 
	//iscritti=1 -> mostra bimbi iscritti
	//iscritti=0 -> mostra bimbi non iscritti (esplicitamente)
	//iscritti=-1 -> mostra bimbi che non hanno deciso
	
	$con=connection();
	$stringToPrintSubModifica = "+";
	$iscritto = false;
	if ($iscritti >= 0) {
		if ($iscritti == 1) {
			$stringToPrintTitle = "Iscritti";
			$stringToPrintTitleAlt = "iscritto";
			$stringToPrintSubModifica = "-";
			$iscritto = true;
		} else if ($iscritti == 0) {
			$stringToPrintTitle = "Non iscritti";
			$stringToPrintTitleAlt = "non iscritto";
		}
		$query = "SELECT * FROM partecipa JOIN bimbi ON (idBimboFK = idBimbo) JOIN categorie ON (idCatFK = idCat) WHERE idCorsaFK=$idCorsa and iscritto=$iscritti";
	} else {
		$stringToPrintTitle = "Scelta non effettuata";	
		$stringToPrintTitleAlt = "con scelta non effettuata";
		$query = "SELECT b.*, c.* FROM bimbi b JOIN categorie c ON (idCatFK = idCat) WHERE NOT EXISTS (SELECT 1 FROM partecipa p WHERE p.idBimboFK = b.idBimbo AND idCorsaFK=$idCorsa)";
	}

	$modifica = (isset($_POST["postBack"]) and $_POST["postBack"] != "fine modifica");
	$queryResultKids = mysqli_query($con, $query);
	if (mysqli_num_rows($queryResultKids)>0) {
		echo "<h2> $stringToPrintTitle </h2>\n";	
		echo "<table border=1>\n";
		echo "<tr>";
		if ($modifica) {
			echo "<th></th>";
		}
		echo "<th>Nome</th> <th>Cognome</th> <th>Data di nascita</th> <th>Categoria</th> </tr>\n";
		while ($row = mysqli_fetch_array($queryResultKids)) {
			$id = $row["IdBimbo"];
			$nome = $row["nome"];
			$cognome = $row["cognome"];
			$dataNascita =  convertDataIta($row["dataNascita"]);
			$categoria = $row["Descrizione"];

			echo "<tr>";
			if ($modifica) {
				echo "<form action=insertParticipation.php method=POST>";
				echo "<td> <input type=submit name=sub value=$stringToPrintSubModifica> <input type=hidden name=idBimbo value=$id> <input type=hidden name=idCorsa value=$idCorsa> <input type=hidden name=iscritto value=$iscritto> <input type=hidden name=pagPrec value='vistaCorse.php?idCorsa=$idCorsa'></td>";
				echo "</form>";
			}
			echo "<td> $nome </td> <td> $cognome </td> <td> $dataNascita </td> <td> $categoria </td> </tr> \n";

		}
		echo "</table> <br> \n";

	} else {
		echo "<h3> Nessun atleta $stringToPrintTitleAlt </h3>\n";
	}

}


?>