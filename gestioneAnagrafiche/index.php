<title> Gestione anagrafiche </title>
<?php
require_once('../functions/general.php');
session_start();
printHead();

if (!isLogged() or (!$_SESSION["isAdmin"] and !$_SESSION["isTrainer"])) {
	echo "redirectoring to login";
	header('Location: ./login');
} else {
	echo "<form action=../> <input type=submit value='← indietro'> </form>";

	/*
	allenatori:
		inserimento bambini, genitori, legami di parentela
	admin:
		+gestione dei ruoli, inserimento admin e allenatori, eliminazione
	*/
	echo "<a href=./inserimentoBambini.php> Inserimento bambini </a> <br>\n";
	echo "<a href=./inserimentoGenitori.php> Inserimento genitori </a> <br>\n";
	echo "<a href=./inserimentoLegamiParentela.php> Inserimento legami di parentela </a> <br> <br>\n";

	if ($_SESSION["isAdmin"]) {
		echo "<a href=./gestioneRuoli.php> Gestione ruoli </a> <br>\n";
		echo "<a href=./inserimentoAdvanced.php> Inserimento allenatori/admin </a> <br>\n";
		echo "<a href=./eliminaBambini.php> Elimina bambini </a> <br>\n";	
	}




}

?>