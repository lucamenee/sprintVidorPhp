<title> Inserimento corsa </title>
<?php
require_once('../functions/general.php');
session_start();
printHead();

if (!isLogged() or (!$_SESSION["isAdmin"] and !$_SESSION["isTrainer"])) {
	echo "redirectoring to login";
	header('Location: ../login');
} else {
	echo "<form action=../> <input type=submit value='← indietro'> </form>";
?>

<form action=insert.php method=POST>
	Luogo: <input type=text name=luogo required> <br>
	Data: <input type=date name=dataEvento required> <br>
	Chiusura iscrizioni: <input type=date name=dataChiusuraIscrizioni required> <br>
	Ora: <input type=time name=ora required> <br>
	Via: <input type=text name=via required> <br>
	Civico: <input type=number name=civico> <br>
	Provincia: <input type=text name=provincia> <br>
	Link maps: <input type=text name=linkMaps> <br>
	Note sulla posizione: <input type=text name=notePosizione> <br>
	Note sulla gara: <input type=text name=noteGara> <br>
	<input type=submit name=sub value=inserisci>
</form>

<?php
}
?>