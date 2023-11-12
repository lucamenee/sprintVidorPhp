<title> Inserimento </title>
<?php
require_once('../functions/general.php');
session_start();
printHead();

if (!isLogged() or (!$_SESSION["isAdmin"] and !$_SESSION["isTrainer"]) or !isset($_POST["ins"])) {
	echo "redirectoring to login";
	header('Location: ../login');
} else {

	echo "<form action=atleti.php> <input type=submit value='← indietro'> </form>";
	$con = connection();
	$modifica = ($_POST["ins"] == "Applica");
	$nome = $_POST["nome"];
	$cognome = $_POST["cognome"];
	$dataNascita = $_POST["dataNascita"];
	$idCatFK = $_POST["IdCat"];

	$presente = mysqli_num_rows(mysqli_query($con, "SELECT * FROM bimbi WHERE nome='$nome' AND cognome='$cognome' AND dataNascita='$dataNascita' AND idCatFK=$idCatFK"));

	if (!$presente) {
		if ($modifica) {
			$IdBimbo = $_POST["IdBimbo"];
			$query = "UPDATE bimbi SET nome='$nome', cognome='$cognome', dataNascita='$dataNascita', idCatFK=$idCatFK  WHERE IdBimbo=$IdBimbo";
		} else {
			$query = "INSERT INTO bimbi (nome, cognome, dataNascita, idCatFK) VALUES ('$nome', '$cognome', '$dataNascita', $idCatFK)";
		}

		if (mysqli_query($con, $query)) {
			echo "<h1> Inserimento avvenuto con successo </h1>";
			header("Refresh:1.5; URL= atleti.php");	
		} else {
			echo "<h1> Errore nell'inserimento </h1>";
			header("Refresh:1.5; URL= atleti.php");	
		}
	} else {
		echo "<h1> Atleta già presente </h1>";
		header("Refresh:1.5; URL= atleti.php");	
	}


}
?>