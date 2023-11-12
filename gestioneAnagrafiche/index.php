<title> Gestione anagrafiche </title>
<?php
require_once('../functions/general.php');
session_start();
printHead();

if (!isLogged() or (!$_SESSION["isAdmin"] and !$_SESSION["isTrainer"])) {
	echo "redirectoring to login";
	header('Location: ../login');
} else {
	echo "<form action=../> <input type=submit value='← indietro'> </form>";

	/*
	allenatori:
		inserimento bambini, genitori, legami di parentela
	admin:
		+gestione dei ruoli, inserimento admin e allenatori, eliminazione
	*/

	//da queste due pagine si possono creare i legami di parentela
	echo "<a href=./atleti.php> Gestione atleti </a> <br>\n";
	echo "<a href=./utenti.php> Gestione utenti </a> <br> <br> \n"; //se è admin può inserire allenatori e altri admin tramite checkbox
	//echo "<a href=./inserimentoLegamiParentela.php> Inserimento legami di parentela </a> <br> <br>\n";

	if ($_SESSION["isAdmin"]) {
		echo "<a href=./gestioneRuoli.php> Gestione ruoli </a> <br>\n";
		echo "<a href=./eliminaAtleti.php> Elimina atleti </a> <br>\n";	
	}




}

?>