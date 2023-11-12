<title> Inserimento </title>
<?php
require_once('../functions/general.php');
session_start();
printHead();

if (!isLogged() or !$_SESSION["isAdmin"] or !isset($_POST["ins"])) {
	echo "redirectoring to login";
	header('Location: ../login');
} else {

	echo "<form action=utenti.php> <input type=submit value='← indietro'> </form>";
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
	} else {
		$query = "INSERT INTO bimbi (nome, cognome, username, password) VALUES ('$nome', '$cognome', '$username', '')";
		$IdUser = (mysqli_fetch_array(mysqli_query($con, "SELECT IdUser FROM utenti WHERE nome='$nome', cognome='$cognome', username='$username'")))["IdUser"];
	}

	if (mysqli_query($con, $query)) {
		echo "<h1> Inserimento avvenuto con successo </h1>";
	} else {
		echo "<h1> Errore nell'inserimento </h1>";
	}

	if (!(isset($_POST["IdUtente"]) and $_POST["IdUtente"]==$_SESSION["idUser"])) {
		if ($gen) {
			mysqli_query($con, "INSERT INTO genitori (IdUserFK) VALUES ($IdUser)");
			mysqli_query($con, "INSERT INTO rigaRuoli (IdUserFK, IdRuoloFK) VALUES ($IdUser, 2)");
		} else {
			mysqli_query($con, "DELETE FROM rigaRuoli WHERE IdUserFK=$IdUser AND IdRuoloFK=2");
			mysqli_query($con, "DELETE FROM genitore_di WHERE IdUserFK=$IdUser");
			mysqli_query($con, "DELETE FROM genitori WHERE IdUserFK=$IdUser");
		}

		if ($all) {
			mysqli_query($con, "INSERT INTO rigaRuoli (IdUserFK, IdRuoloFK) VALUES ($IdUser, 1)");
		} else {
			mysqli_query($con, "DELETE FROM rigaRuoli WHERE IdUserFK=$IdUser AND IdRuoloFK=1");
		}

		if ($adm) {
			mysqli_query($con, "INSERT INTO rigaRuoli (IdUserFK, IdRuoloFK) VALUES ($IdUser, 0)");
		} else {
			mysqli_query($con, "DELETE FROM rigaRuoli WHERE IdUserFK=$IdUser AND IdRuoloFK=0");
		}

		echo "<h1> Ruoli aggiornati </h1>";
	}
	
	header("Refresh:1.5; URL= utenti.php");	

}
?>