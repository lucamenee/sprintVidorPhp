<title> Elimina corsa </title>
<?php
require_once('../functions/general.php');
session_start();
printHead();

if (!isLogged() or !(isset($_POST["subEl"]) or isset($_POST["subPost"])) or !$_SESSION["isAdmin"]) {
	echo "redirectoring to login";
	header('Location: ../login');
} else {
	$idCorsa = $_POST["idCorsa"];
	$con = connection();
	if (isset($_POST["subPost"])) {
		

		if ($_POST["subPost"] == 'annulla') {
			echo "<h2> Eliminazione non confermata </h2>";
			header("Refresh:1.5; URL= ../");
		} else if ($_POST["subPost"] == 'conferma') {
			$queryResult = mysqli_query($con, "DELETE FROM corse WHERE idCorsa = $idCorsa");
			$queryResult = mysqli_query($con, "DELETE FROM corse WHERE idCorsa = $idCorsa");
		
			echo "<h2> Eliminazione confermata </h2>";
		}
		header("Refresh:1.5; URL= ../");
	} else {

		$luogo = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM corse WHERE idCorsa=$idCorsa"))["luogo"];
		$data = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM corse WHERE idCorsa=$idCorsa"))["dataEvento"];
		$data = convertDataIta($data);
			

		//form per conferma iscrizione/cancellazione iscrizione
		echo "<form action=# method=POST class='iscrizione'>\n";
		

		echo "<h2> Conferma elimimazione della corsa di $luogo del $data dal database <h2> <br>\n";
		echo "<input type=submit name=subPost value=conferma> <input type=submit name=subPost value=annulla>\n";
		echo "<input type=hidden name=idCorsa value=$idCorsa>\n";
		echo "</form>";
	}
}

?>