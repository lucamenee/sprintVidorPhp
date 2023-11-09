<title> Statistiche </title>
<?php
require_once('../functions/general.php');
session_start();
printHead();

if (!isLogged() or (!$_SESSION["isAdmin"] and !$_SESSION["isTrainer"])) {
	echo "redirectoring to login";
	header('Location: ../login');
} else {

	if (isset($_POST["anno"])) $anno = $_POST["anno"];
	else $anno = date("Y");
	echo "<form action=../> <input type=submit value='← indietro'> </form> \n";
	echo "<form action=# method=POST> Anno: <input type=number value=$anno name=anno> <input type=submit value=cerca></form> \n";


?>	
<!-- eventuale implemetazione di più statistiche
<form action=# method="POST">
	<select name="stat">
		<option value="v1">v1</option>
		<option value="v2">v2</option>
		<option value="v3">v3</option>
		<option value="v4">v4</option>
	</select>
</form>
-->

<?php
	$con=connection();
	$totCorse = mysqli_num_rows(mysqli_query($con, "SELECT * FROM corse WHERE dataEvento >= '$anno/01/01' AND dataEvento <= '$anno/12/31'"));

	$query = "SELECT bimbi.*, Descrizione, COALESCE(sum(iscritto), 0) as c FROM bimbi LEFT JOIN partecipa ON (idBimbo = IdBimboFK) LEFT JOIN corse ON (IdCorsaFK = IdCorsa) JOIN categorie ON (idCatFK = idCat) WHERE dataEvento IS NULL OR (dataEvento >= '$anno/01/01' AND dataEvento <= '$anno/12/31' ) GROUP BY IdBimbo;";
	//echo $query;
	$queryResultKids = mysqli_query($con, $query);
	if ($totCorse) {
		echo "<h3> Totai corse dell'anno $anno: $totCorse </h3> \n";	
		echo "<table class=isrizioni border=1>\n";
		echo "<tr> <th>Nome</th> <th>Cognome</th> <th>Data di nascita</th> <th>Categoria</th> <th>Partecipazioni</th> <th>%</th> </tr>\n";
		while ($row = mysqli_fetch_array($queryResultKids)) {
			$nome = $row["nome"];
			$cognome = $row["cognome"];
			$dataNascita =  convertDataIta($row["dataNascita"]);
			$categoria = $row["Descrizione"];
			$count = $row["c"];
			$perc = intdiv($count * 100, $totCorse ) . "%";

			echo "<tr> <td> $nome </td> <td> $cognome </td> <td> $dataNascita </td> <td> $categoria </td> <td> $count </td> <td> $perc </td> </tr> \n";

		}
		echo "</table> <br> \n";
	} else {
		echo "<h3> Nessuna corsa registrata nell'anno $anno </h3>";
	}
}
?>