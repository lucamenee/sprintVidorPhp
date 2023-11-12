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

	
	echo "<a href=./atleti.php> Gestione atleti </a> <br> <br>\n";
	

	if ($_SESSION["isAdmin"]) {
		//echo "<a href=./inserimentoLegamiParentela.php> Inserimento legami di parentela </a> <br>\n";
		echo "<a href=./utenti.php> Gestione utenti </a> <br> \n";
		echo "<a href=./eliminaAtleti.php> Elimina atleti </a> <br>\n";	
	}

	/*
	decidi implementazione legami parentala:
	- da pagina a parte;
	- sfrutta pagina utenti / pagina bambini
	*/




}

?>