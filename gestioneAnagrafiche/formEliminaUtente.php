<title> Elimina atleta </title>
<?php
require_once('../functions/general.php');
session_start();
printHead();

if (!isLogged() or !(isset($_POST["sub"]) or isset($_POST["subPost"])) or !$_SESSION["isAdmin"]) {
	echo "redirectoring to login";
	header('Location: ../login');
} else {
	$IdUser = $_POST["IdUser"];
	$con = connection();
	if (isset($_POST["subPost"])) {
		

		if ($_POST["subPost"] == 'annulla') {
			echo "<h2> Eliminazione non confermata </h2>";
			header("Refresh:1.5; URL= ./utenti.php");
		} else if ($_POST["subPost"] == 'conferma') {
			$queryResult = mysqli_query($con, "DELETE FROM utenti WHERE IdUser = $IdUser");
			$queryResult = mysqli_query($con, "DELETE FROM utenti WHERE IdUser = $IdUser");
		
			echo "<h2> Eliminazione confermata </h2>";
		}
		header("Refresh:1.5; URL= ./utenti.php");
	} else {

		$nomeUtente = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM utenti WHERE IdUser=$IdUser"))["Nome"];
		$cognomeUtente = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM utenti WHERE IdUser=$IdUser"))["Cognome"];
			

		//form per conferma iscrizione/cancellazione iscrizione
		echo "<form action=# method=POST class='iscrizione'>\n";
		

		echo "<h2> Conferma elimimazione di $nomeUtente $cognomeUtente dal database <h2> <br>\n";
		echo "<input type=submit name=subPost value=conferma> <input type=submit name=subPost value=annulla>\n";
		echo "<input type=hidden name=IdUser value=$IdUser>\n";
		echo "</form>";
	}
}

?>