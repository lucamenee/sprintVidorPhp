<title> Inserimento </title>
<?php
require_once('../functions/general.php');
session_start();
printHead();

if (!isLogged() or !$_SESSION["isAdmin"] or !isset($_POST["ins"])) {
	echo "redirectoring to login";
	header('Location: ../login');
} else {

	echo "<form action=utenti.php> <input type=submit value='← indietro'> </form>\n";
	$con = connection();
	$modifica = ($_POST["ins"] == "Applica");
	$nome = $_POST["nome"];
	$cognome = $_POST["cognome"];
	$username = $_POST["username"];
	$gen = isset($_POST["gen"]);
	$all = isset($_POST["all"]);
	$adm = isset($_POST["adm"]);


	


	//$presente = mysqli_num_rows(mysqli_query($con, "SELECT * FROM utenti WHERE nome='$nome' AND cognome='$cognome' AND username='$username'"));
	//$presente = isset($_POST["IdUser"]);
	$IdUser = 0;

	if ($modifica) {
		$IdUser = $_POST["IdUtente"];
		$query = "UPDATE utenti SET nome='$nome', cognome='$cognome', username='$username' WHERE IdUser=$IdUser";
		$stringToInsertConferma = "Update";
	} else {
		$query = "INSERT INTO utenti (nome, cognome, username, password) VALUES ('$nome', '$cognome', '$username', '')";
		
		$stringToInsertConferma = "Inserimento";
	}

	if (mysqli_query($con, $query)) {
		$riga = mysqli_fetch_array(mysqli_query($con, "SELECT IdUser FROM utenti WHERE Nome='$nome' AND Cognome='$cognome' AND Username='$username'"));
		$IdUser = $riga["IdUser"];
		echo "<h1> $stringToInsertConferma avvenuto con successo </h1>\n";
	} else {
		echo "<h1> Errore nel $stringToInsertConferma </h1>\n";
	}

	//admin
	if (!(isset($_POST["IdUtente"]) and $_POST["IdUtente"]==$_SESSION["idUser"])) {	
		if ($adm) {
			mysqli_query($con, "INSERT INTO rigaRuoli (IdUserFK, IdRuoloFK) VALUES ($IdUser, 0)");
		} else {
			mysqli_query($con, "DELETE FROM rigaRuoli WHERE IdUserFK=$IdUser AND IdRuoloFK=0");
		}
		$stringToPrintEnd = "";
	} else {
		$stringToPrintEnd = "<br> <i> Ricordati che non puoi toglierti i privilegi di admin </i>";
	}

	//allenatore
	if ($all) {
		mysqli_query($con, "INSERT INTO rigaRuoli (IdUserFK, IdRuoloFK) VALUES ($IdUser, 1)");
	} else {
		mysqli_query($con, "DELETE FROM rigaRuoli WHERE IdUserFK=$IdUser AND IdRuoloFK=1");
	}

	echo "<h1> Ruoli aggiornati </h1> <br>\n";
	//genitore
	if ($gen) {
		mysqli_query($con, "INSERT INTO genitori (IdUserFK) VALUES ($IdUser)");
		mysqli_query($con, "INSERT INTO rigaRuoli (IdUserFK, IdRuoloFK) VALUES ($IdUser, 2)");

		//showing his childs and possibility to add other childs
		$resultSearchFigli = mysqli_query($con, "SELECT * FROM genitore_di JOIN bimbi ON (idBimboFk = IdBimbo) JOIN categorie ON (idCatFk = idCat) WHERE IdUserFK=$IdUser");
		if (mysqli_num_rows($resultSearchFigli)) {
			echo "<h1> Figli </h1>\n";
			echo "<table border=1>\n";
			echo "<tr> <th> Nome </th> <th> Cognome </th> <th> Data di nascita </th> <th> Categoria </th> <th> </th> </tr>\n";
			while ($rowSearchFigli = mysqli_fetch_array($resultSearchFigli)) {
				$IdBimbo = $rowSearchFigli["IdBimbo"];
				$nome = $rowSearchFigli["nome"];
				$cognome = $rowSearchFigli["cognome"];
				$dataNascita = convertDataIta($rowSearchFigli["dataNascita"]);
				$Descrizione = $rowSearchFigli["Descrizione"];

				echo "<tr> <td> $nome </td> <td> $cognome </td> <td> $dataNascita </td> <td> $Descrizione </td> ";
				echo "<td> <form action=legami.php method=POST> <input type=hidden name=idBimboFK value=$IdBimbo> <input type=hidden name=idUserFK value=$IdUser><input type=submit name=go value=-> </form> </td><tr>\n";
			}
			echo "</table>\n";

		} else {
			echo "<br> <h3> Nessun figlio inserito per questo genitore </h3> <br> \n";
		}

		echo "<h1> Aggiugni figli </h1>\n";	
		$querySearchNonFigli = "SELECT * FROM genitore_di JOIN bimbi ON (idBimboFk = IdBimbo) JOIN categorie ON (idCatFk = idCat) WHERE idBimboFK NOT IN (SELECT idBimboFK FROM genitore_di WHERE IdUserFK=$IdUser)";
		$resultSearchNonFigli = mysqli_query($con, $querySearchNonFigli);
		echo "<table border=1>\n";
		echo "<tr> <th> Nome </th> <th> Cognome </th> <th> Data di nascita </th> <th> Categoria </th> <th> </th> </tr>\n";
		while ($rowSearchNonFigli = mysqli_fetch_array($resultSearchNonFigli)) {
			$IdBimbo = $rowSearchNonFigli["IdBimbo"];
			$nome = $rowSearchNonFigli["nome"];
			$cognome = $rowSearchNonFigli["cognome"];
			$dataNascita = convertDataIta($rowSearchNonFigli["dataNascita"]);
			$Descrizione = $rowSearchNonFigli["Descrizione"];

			echo "<tr> <td> $nome </td> <td> $cognome </td> <td> $dataNascita </td> <td> $Descrizione </td> ";
			echo "<td> <form action=legami.php method=POST> <input type=hidden name=idBimboFK value=$IdBimbo> <input type=hidden name=idUserFK value=$IdUser><input type=submit name=go value=+> </form> </td><tr>\n";
		}
		echo "</table>\n";



	} else {
		mysqli_query($con, "DELETE FROM rigaRuoli WHERE IdUserFK=$IdUser AND IdRuoloFK=2");
		mysqli_query($con, "DELETE FROM genitore_di WHERE IdUserFK=$IdUser");
		mysqli_query($con, "DELETE FROM genitori WHERE IdUserFK=$IdUser");

		header("Refresh:1.5; URL= utenti.php");	
	}
	

	echo $stringToPrintEnd;
	

}
?>