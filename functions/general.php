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
	  <link href='/sprintVidor/style.css' rel='stylesheet'>
	</head>";
	
	echo "<div class='divHead'> <h1 class=titoloDivHead> SPRINT VIDOR </h1><h2 class=titoloDivHead> LA VALLATA A.S.D. </h2> </div> <img class=logo src='/sprintVidor/img/logo.png' width=120 height=120 align=right>";
}

?>