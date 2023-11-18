<title> Gestione atleti </title>
<?php
require_once('../functions/general.php');
session_start();
printHead();

if (!isLogged() or (!$_SESSION["isAdmin"] and !$_SESSION["isTrainer"])) {
	echo "redirectoring to login";
	header('Location: ../login');
} else {
	echo "<form action=../> <input type=submit value='← indietro'> </form>";
	$con = connection();

	//creazione form inserimento/modifica
	$queryResultCategorie = mysqli_query($con, "SELECT * FROM categorie");
	if (isset($_POST["postBack"])) {
		$nomePost = $_POST["nome"];
		$cognomePost = $_POST["cognome"];
		$dataNascitaPost = $_POST["dataNascita"];
		$idCatPost = $_POST["idCat"];
		$stringToInsertSub = "Applica";
		$IdBimboPost = $_POST["IdBimbo"];
	} else {
		$nomePost = "''";
		$cognomePost = "''";
		$dataNascitaPost = null;
		$idCatPost = 1;
		$stringToInsertSub = "Inserisci";
		$IdBimboPost=null;
	}

	if (isset($_POST["postBackDel"]) and $_POST["postBackDel"] == "Elimina atleti") $elimina = true;
	else $elimina = false;

	if ($elimina) $stringToInsertDel = "'Annulla'";
	else $stringToInsertDel = "'Elimina atleti'";
	/*
	posiziona questi due form nella stessa linea, una a dx, uno a sx
	*/
	echo "<form action=# method=POST> <input type=submit value=clear> </form>";
	echo "<form action=# method=POST> <input type=submit name=postBackDel value=$stringToInsertDel class=elimina> </form>";
	
	echo "<table border=1 class='atleti'> \n <tr>";
	if ($elimina)
		echo "<th> </th>";
	echo "<th> Nome </th> <th> Cognome </th> <th> Data di nascita </th> <th> Categoria </th> <th> </th> </tr> \n";
	echo "<form action=insertAtleta.php method=POST> \n <tr>";
	if ($elimina)
		echo "<td> </td>";
	echo "<td> <input type=text name=nome value='$nomePost' required> </td> <td> <input type=text name=cognome value='$cognomePost' required> </td> <td> <input type=date name=dataNascita value='$dataNascitaPost' required> </td> \n"; 
		//combobox categorie
	echo "<td> <select name=IdCat>\n";
	while ($rowC = mysqli_fetch_array($queryResultCategorie)) {
		$idCatC = $rowC["idCat"];
		$DescrizioneC = $rowC["Descrizione"];
		$selected = "";
		if ($idCatC == $idCatPost) $selected = "selected";
		echo "<option value=$idCatC $selected> $DescrizioneC </option>\n";
	}
	echo "</select> </td>\n";

	echo "<td> <input type=hidden name=IdBimbo value=$IdBimboPost> <input type=submit name=ins value='$stringToInsertSub'> </td> </tr> </form>\n";



	//tabella atleti
	$queryResultAtleti = mysqli_query($con, "SELECT * FROM bimbi JOIN categorie ON (bimbi.idCatFK = categorie.idCat)");
	while ($row = mysqli_fetch_array($queryResultAtleti)) {
		$IdBimbo = $row["IdBimbo"];
		$nome = $row["nome"];
		$cognome = $row["cognome"];
		$dataNascita = $row["dataNascita"];
		$idCat = $row["idCat"];
		$Descrizione = $row["Descrizione"];
		
		echo "<tr class=rowAtleti>";
		if ($elimina)
			echo "<td> <form action=formEliminaAtleta.php method=POST class=nullSpace> <input type=hidden name=IdBimbo value=$IdBimbo> <input type=submit name=sub value=elimina class=elimina> </form></td>";
		echo "<form action=# method=POST> <td> <input type=text name=nome value=$nome readonly class='postBackUtenti'> </td> <td> <input type=text name=cognome value=$cognome readonly class='postBackUtenti'> </td> <td> <input type=date name=dataNascita value=$dataNascita readonly class='postBackUtenti'> </td> <td> <input type=text name=Descrizione value=$Descrizione disable class='postBackUtenti'> </td> <td> <input type=hidden name=idCat value=$idCat> <input type=hidden name=IdBimbo value=$IdBimbo> <input type=submit name=postBack value=modifica> </td>";
		echo "</form> </tr>";
	}

	echo "</table>";
}
?>