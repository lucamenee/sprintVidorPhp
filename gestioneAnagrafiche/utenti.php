<title> Gestione utenti </title>
<?php
require_once('../functions/general.php');
session_start();
printHead();

if (!isLogged() or !$_SESSION["isAdmin"]) {
	echo "redirectoring to login";
	header('Location: ../login');
} else {
	echo "<form action=../> <input type=submit value='← indietro'> </form>";
	$con = connection();
	$queryResultRouli = mysqli_query($con, "SELECT * FROM rouli");

	//creazione form inserimento/modifica
	/* cambia campi*/
	
	if (isset($_POST["postBack"])) {
		$nomePost = $_POST["nome"];
		$cognomePost = $_POST["cognome"];
		$usernamePost = $_POST["Username"];
		if(isset($_POST["genPost"])) $isGen = "checked";
		else $isGen = "";
		if(isset($_POST["allPost"])) $isAll = "checked";
		else $isAll = "";
		if(isset($_POST["admPost"])) $isAdm = "checked";
		else $isAdm = "";
		$stringToInsertSub = "Applica";
		$IdUser = $_POST["IdUserPost"];
		$queryResultCategorie = mysqli_query($con, "SELECT * FROM utenti JOIN rigaruoli ON (utenti.IdUser = rigaruoli.IdUserFK) JOIN ruoli ON (rigaruoli.IdRuoloFK = ruoli.IdRuolo) WHERE IdUser=$IdUser");
	} else {
		$nomePost = "''";
		$cognomePost = "''";
		$usernamePost = "''";
		$idCatPost = 1;
		$stringToInsertSub = "Inserisci";
		$IdUserPost = null;
		$queryResultCategorie = null;
		$isGen = "";
		$isAll = "";
		$isAdm = "";
		$IdUser = "";
	}

	echo "<form action=# method=POST> <input type=submit value=clear> </form>";
	echo "<table border=1 class='utenti'> \n <tr> <th> Nome </th> <th> Cognome </th> <th> Username* </th> <th> Genitore </th> <th> Allenatore </th> <th> Admin </th> <th> </th> </tr> \n";
	echo "<form action=insertUtente.php method=POST> \n <tr height=35px> <td> <input type=text name=nome value='$nomePost' required> </td> <td> <input type=text name=cognome value='$cognomePost' required> </td> <td> <input type=text name=username value='$usernamePost' required> </td> \n"; 
	//combobox rouli
	echo "<td> <input type=checkbox name=gen $isGen> </td>";
	echo "<td> <input type=checkbox name=all $isAll> </td>";
	echo "<td> <input type=checkbox name=adm $isAdm> </td>";

	echo "<td> <input type=hidden name=IdUtente value=$IdUser> <input type=submit name=ins value='$stringToInsertSub'> </td> </tr> </form>\n";



	//tabella utenti
	$queryResultUtenti = mysqli_query($con, "SELECT * FROM utenti");
	while ($row = mysqli_fetch_array($queryResultUtenti)) {
		$IdUser = $row["IdUser"];
		$nome = $row["Nome"];
		$cognome = $row["Cognome"];
		$Username = $row["Username"];		
		echo "<tr> <form action=# method=POST> <td> <input type=text name=nome value=$nome readonly class='postBackUtenti'> </td> <td> <input type=text name=cognome value=$cognome readonly class='postBackUtenti'> </td> <td> <input type=text name=Username value=$Username readonly class='postBackUtenti'> </td> ";
		//ruoli
		$resultR = mysqli_query($con, "SELECT * FROM rigaruoli WHERE IdUserFK = $IdUser");
		$genR = $allR = $admR = "";
		while ($rigaR = mysqli_fetch_array($resultR)) {
			if ($rigaR["IdRuoloFK"] == 2) {
				$genR = "checked";
			} else if ($rigaR["IdRuoloFK"] == 1) {
				$allR = "checked";
			} else if ($rigaR["IdRuoloFK"] == 0) {
				$admR = "checked";
			}
		}
		echo "<td> <input type=checkbox name=genPost value=1 $genR onclick='return false;'> </td>";
		echo "<td> <input type=checkbox name=allPost value=1 $allR onclick='return false;'> </td>";
		echo "<td> <input type=checkbox name=admPost value=1 $admR onclick='return false;'> </td>";

		echo "<td> <input type=hidden name=IdUserPost value=$IdUser> <input type=submit name=postBack value=modifica> </td>";
		echo "</form> </tr>\n";
	}

	echo "</table>\n";

	echo "<br><br>*l'username deve essere unico per ogni utente e di una lunghezza massima di 25 caratteri";
	echo "<br>**i nuovi utenti potranno accedere senza password, si consiglia di impostarne una dopo aver eseguito il primo accesso";


}
?>