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
		<img class=logo id=logo src='$path/img/logoNoSfondo.png' width=120 height=120 align=right>\n";

	if (isset($_SESSION["isLogged"]) and $_SESSION["isLogged"]) {
		echo "<div class='toolbar' id='toolbar'>\n";
		$classObject = "class=object";
		if ($_SESSION["isTrainer"] or $_SESSION["isAdmin"]) {
			echo "<div $classObject id=gestioneAnangrafiche onclick=\"clickAnagraficheFunction()\"> Gestione anagrafiche </div>\n";
			echo "<div $classObject onclick=\"window.location='$path/statistiche'\"> Statistiche </div> <div $classObject onclick=\"window.location='$path/archivioCorse'\"> Archivio corse </div>";
		}
		echo "<div $classObject onclick=\"window.location='$path/updatepsw'\"> Cambia password </div> <div $classObject id='objectLogout' onclick=\"window.location='$path/logout'\"> Logout </div>";
		echo "</div>";
		if ($_SESSION["isTrainer"] or $_SESSION["isAdmin"]) {
			echo "<div class=menuAnagrafiche id=menuAnagrafiche> <div class=objectAnagrafiche onclick=\"window.location='$path/gestioneAnagrafiche/atleti.php'\"> Gestione atleti </div>\n";
			if ($_SESSION["isAdmin"]) {
				echo "<div class=objectAnagrafiche onclick=\"window.location='$path/gestioneAnagrafiche/utenti.php'\"> Gestione utenti </div>\n";
			}
			echo "<div class=objectAnagrafiche onclick=\"window.location='$path/inserimentoCorse'\"> Nuova corsa </div>\n";
			
			echo "</div>\n";
		}
	}
}

function printFooter() {
	global $path;
	echo "<footer> <div class=footerCredits> <div>Prodotto svilippato da Luca Meneghetti </div> <div> <a href=https://github.com/lucamenee target='_blank'><img src='$path/img/github.png' class=githubImg>Profilo Github </a> </div></div> <footer>\n";
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