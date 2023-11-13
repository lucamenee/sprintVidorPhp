<?php
$path = "/sprintVidor";

function connection() {
	return mysqli_connect('localhost', 'root', '', 'sprintVidor');
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
	global $path;
	
	echo "<head>
	  <link href='$path/style.css' rel='stylesheet'>
	  <script src='$path/functions/general.js'></script>
	</head>";
	
	echo "<div style='cursor: pointer;' onclick=\"window.location='$path'\";' class='divHead'> 
			<h1> SPRINT VIDOR </h1>
			<h2> LA VALLATA A.S.D. </h2> 
		</div>\n 
		<img class=logo id=logo src='$path/img/logoAlt.jpg' width=120 height=120 align=right>\n";
	echo "<div class='toolbar' id='toolbar'> <div> TOOLBAR </div> <div> TOOLBAR </div> </div>";
}

function insertAst($input) {
	return "'" . $input . "'";
}

function is_in($ar, $el) {
	foreach ($ar as $v) {
		if ($v == $el)
			return true;
	}

	return false;
}

?>