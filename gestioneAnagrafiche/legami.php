<title> Legami </title>
<?php
require_once('../functions/general.php');
session_start();
printHead();

if (!isLogged() or !$_SESSION["isAdmin"] or !isset($_POST["go"])) {
	echo "redirectoring to login";
	header('Location: ../login');
} else {
	$con = connection();
	$insert = ($_POST["go"] == '+');
	$idUserFK = $_POST["idUserFK"];
	$idBimboFK = $_POST["idBimboFK"];

	if ($insert) {
		$query = "INSERT INTO genitore_di (IdUserFK, idBimboFK) VALUES ($idUserFK, $idBimboFK)";
	} else {
		$query = "DELETE FROM genitore_di WHERE IdUserFK=$idUserFK AND idBimboFK=$idBimboFK";
	}

	if (mysqli_query($con, $query)) {
		echo "<h1> Operazione eseguita con successo </h1>";
	} else {
		echo "<h1> Errore nell'esecuzione, operazione non eseguita </h1>";
	}

	header("Refresh:1.5; URL= utenti.php");

}
?>
