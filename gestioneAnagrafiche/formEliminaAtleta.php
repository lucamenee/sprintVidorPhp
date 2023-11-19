<title> Elimina atleta </title>
<?php
require_once('../functions/general.php');
session_start();
printHead();

if (!isLogged() or !(isset($_POST["sub"]) or isset($_POST["subPost"])) or !($_SESSION["isAdmin"] or $_SESSION["isTrainer"])) {
	echo "redirectoring to login";
	header('Location: ../login');
} else {
	$idBimbo = $_POST["IdBimbo"];
	$con = connection();
	if (isset($_POST["subPost"])) {
		

		if ($_POST["subPost"] == 'annulla') {
			echo "<h2> Eliminazione non confermata </h2>";
			header("Refresh:1.5; URL= ./atleti.php");
		} else if ($_POST["subPost"] == 'conferma') {
			$queryResult = mysqli_query($con, "DELETE FROM bimbi WHERE IdBimbo = $idBimbo");
			echo "<h2> Eliminazione confermata </h2>";
		}			
		
		header("Refresh:1.5; URL= ./atleti.php");
	} else {

		$nomeBimbo = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM bimbi WHERE IdBimbo=$idBimbo"))["nome"];
		$cognomeBimbo = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM bimbi WHERE IdBimbo=$idBimbo"))["cognome"];
			

		//form per conferma iscrizione/cancellazione iscrizione
		echo "<form action=# method=POST class='iscrizione'>\n";
		

		echo "<h2> Conferma elimimazione di $nomeBimbo $cognomeBimbo dal database <h2> <br>\n";
		echo "<input type=submit name=subPost value=conferma> <input type=submit name=subPost value=annulla>\n";
		echo "<input type=hidden name=IdBimbo value=$idBimbo>\n";
		echo "</form>";
	}
}

?>