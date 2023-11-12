<title> Esecuzione cambio password </title>
<?php
require_once('../functions/general.php');
session_start();
printHead();

if (!isLogged()) {
	echo "redirectoring to login";
	header('Location: ../login');
} else {
	$con = connection();

	$id = $_SESSION["idUser"];
	$username = $_POST["username"];
	$oldPsw = $_POST["oldPsw"];
	$nPsw = $_POST["nPsw"];
	$n2Psw = $_POST["n2Psw"];

	$resultSelect = mysqli_query($con, "SELECT * FROM utenti WHERE Username='$username' AND Password='$oldPsw'");	
	$found = false;
	if (mysqli_num_rows($resultSelect)) {
		$row = mysqli_fetch_array($resultSelect);
		$idFromSelect = $row["IdUser"];
		$found = true;
	}

	if ($found) {
		if ($idFromSelect == $id) {
			if ($nPsw == $n2Psw) {
				if (mysqli_query($con, "UPDATE utenti SET Password='$nPsw' WHERE IdUser=$id")) {
					echo "<h1> Password aggiornata con successo </h1>";
					header("Refresh:1.5; URL= index.php");
				} else {
					echo "<h1> Errore nell'inserimento </h1>";
					header("Refresh:1.5; URL= index.php");
				}
			} else {
				echo "<h1> Password inserite non coincidono </h1>";
				header("Refresh:1.5; URL= index.php");
			}
			
		} else {
			echo "<h1> Utente inserito non coincide con quello loggato </h1>";
			header("Refresh:1.5; URL= index.php");
		}
	} else {
		echo "<h1> Username o password errati </h1>";
		header("Refresh:1.5; URL= index.php");	
	}
}
?>