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

function today() {
	return date_create()->format('Y-m-d');
}

//mostra date in formato ITA
function convertDataIta($originalDate) {
	return date("d/m/Y", strtotime($originalDate));
}

function printHead() {
	
	echo "<head>
	  <link href='style.css' rel='stylesheet'>
	</head>";
	
	echo "<div class='divHead'> <img src='img/logo.png' width=120 height=120 align=right> <h1 align=center> SPRINT VIDOR </h1><h2 align=center> LA VALLATA A.S.D. </h2> </div>";
}

?>