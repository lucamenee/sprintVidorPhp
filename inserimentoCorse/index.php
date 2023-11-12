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
		$posizione = $result["posizione"];
		/*metti else e stroz se non sono definiti*/
		$linkMaps = $result["linkMaps"];
		$notePosizione = $result["notePosizione"];
		$noteGara = $result["noteGara"];

		$go = "Modifica";
	} else {
		$pagPrec = "index";
		$luogo = $ora = $dataEvento = $dataChiusuraIscrizioni = $posizione = $linkMaps = $notePosizione = $noteGara = "''";

		$go = "Inserisci";
		$idCorsa=0;

	}
	echo "\n<form action=../$pagPrec.php> <input type=submit value='← indietro'> <input type=hidden name=idCorsa value=$idCorsa> </form>\n";

	echo "<div class='formInserimento'>
		<form action=insert.php method=POST>
			<br> Località* <br><input type=text name=luogo  value='$luogo' placeholder=Località required><br>
			<br> <br> Data*<br><input type=date name=dataEvento  value=$dataEvento required> <br>
			<br> <br> <img src=../img/iconsCalendario.png class=iconIns> Chiusura iscrizioni* <br><input type=date name=dataChiusuraIscrizioni  value=$dataChiusuraIscrizioni required> <br>
			<br> <br> Ora* <br><input type=time name=ora  value=$ora required> <br>
			<br> <br> <img src=../img/iconsPosizione.png class=iconIns> Ritrovo gara* <br><input type=text name=posizione  value='$posizione' placeholder='Via, civico provincia' required> <br>
			<br> <br> <img src=../img/iconsLink.png class=iconIns> Link maps <br><input type=text name=linkMaps value='$linkMaps' placeholder='Link maps'> <br>
			<br> <br> Note sulla posizione <br><input type=text name=notePosizione value='$notePosizione' placeholder='Note sulla posizione'> <br>
			<br> <br> <img src=../img/iconsNotes.png class=iconIns> Note sulla gara <br><input type=text name=noteGara value='$noteGara' placeholder='Note sulla gara'> <br>
			<input type=hidden name=idCorsa value=$idCorsa> <br> <br>
			<input type=submit name=sub value=$go>
		</form> 
	</div> \n";

	echo "<i>*Campi obbligatori </i> \n";

}
?>