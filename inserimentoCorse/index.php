<title> Inserimento corsa </title>
<?php
require_once('../functions/general.php');
session_start();
printHead();

if (!isLogged() or !$_SESSION["isAdmin"]) {
	echo "redirectoring to login";
	header('Location: ../login');
} else {
	if (isset($_GET["subMod"])) {
		$pagPrec = "vistaCorse";
		$idCorsa = $_GET["idCorsa"];
		$con = connection();
		$result = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM corse WHERE idCorsa=$idCorsa"));
		$luogo = $result["luogo"];
		$ora = $result["ora"];
		$dataEvento = $result["dataEvento"];
		$dataChiusuraIscrizioni = $result["dataChiusuraIscrizioni"];
		$via = $result["via"];
		/*metti else e stroz se non sono definiti*/
		$civico = $result["civico"];
		$provincia = $result["provincia"];
		$linkMaps = $result["linkMaps"];
		$notePosizione = $result["notePosizione"];
		$noteGara = $result["noteGara"];

		$go = "modifica";
	} else {
		$pagPrec = "index";
		$luogo = $ora = $dataEvento = $dataChiusuraIscrizioni = $via = $civico = $provincia = $linkMaps = $notePosizione = $noteGara = "''";

		$go = "inserisci";
		$idCorsa=0;

	}
	echo "\n<form action=../$pagPrec.php> <input type=submit value='← indietro'> <input type=hidden name=idCorsa value=$idCorsa> </form>\n";

	echo "<form action=insert.php method=POST>
		Luogo: <input type=text name=luogo  value=$luogo required> <br>
		Data: <input type=date name=dataEvento  value=$dataEvento required> <br>
		Chiusura iscrizioni: <input type=date name=dataChiusuraIscrizioni  value=$dataChiusuraIscrizioni required> <br>
		Ora: <input type=time name=ora  value=$ora required> <br>
		Via: <input type=text name=via  value=$via required> <br>
		Civico: <input type=number name=civico value=$civico > <br>
		Provincia: <input type=text name=provincia value=$provincia > <br>
		Link maps: <input type=text name=linkMaps value=$linkMaps > <br>
		Note sulla posizione: <input type=text name=notePosizione value=$notePosizione > <br>
		Note sulla gara: <input type=text name=noteGara value=$noteGara > <br>
		<input type=hidden name=idCorsa value=$idCorsa>
		<input type=submit name=sub value=$go>
	</form> \n";

}
?>