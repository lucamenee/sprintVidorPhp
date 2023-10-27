<?php

function connection() {
	return mysqli_connect('localhost', 'root', '', 'sprintVidor');
}

function printLogout() {
	echo "<form action='./logout'> \n <input type=submit value=logout> \n </form>";
}

function isLogged() {
	return (isset($_SESSION["isLogged"]) and $_SESSION["isLogged"]);
}

function cutSeconds($input) {
	return substr($input, 0, -3);
}

?>