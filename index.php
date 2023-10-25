<?php
	session_start();
	
	if (!isset($_SESSION["isLogged"]) or $_SESSION["isLogged"] == false) {
		echo "redirectoring to login";
		header('Location: ./login');
	} else {
		echo "<h1>Sprint Vidor</h1>";
		//show spintVidor stuff
	}
	
?>