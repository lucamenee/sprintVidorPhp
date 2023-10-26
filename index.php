<?php
require_once('functions/general.php');
session_start();

if (!isLogged()) {
	echo "redirectoring to login";
	header('Location: ./login');
} else {
	echo "<h1>Sprint Vidor</h1>";
	if ($_SESSION["isParent"] and (!$_SESSION["isTrainer"] or !$_SESSION["isAdmin"])) {
		echo "solo GENITORE";
		//redirect to parent stuff (loading child participation)
	}
	else {
		echo "NON solo GENITORE";
		//printing links to what they are able to do
	}
	
	
	printLogout(); //da mettere a fine pagina o comunque impaginato bene
}

?>