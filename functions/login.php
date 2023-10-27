<?php
require_once('general.php');

function isInLogin() {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$db = connection();
	$queryResult = mysqli_query($db, "SELECT * FROM utenti WHERE username = '$username' AND password = '$password'");
	if (mysqli_num_rows($queryResult) == 1) 
		return true;
	return false;
}

function foundIdUser() {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$db = connection();
	$queryResult = mysqli_query($db, "SELECT * FROM utenti WHERE username = '$username' AND password = '$password'");
	$row = mysqli_fetch_array($queryResult);
	return $row["IdUser"];
}

?>