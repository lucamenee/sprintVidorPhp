<?php
require_once('../functions/login.php');
session_start();

if (!isset($_POST["go"])) {
?>

	<form action=# method=POST>
		username <input type=text name=username> <br>
		password <input type=password name=password> <br>
		<input type=submit name=go value=login>
	</form>

<?php
} else {
	if (isInLogin()) {
		$id = foundIdUser();
		$_SESSION["idUser"] = $id;
		$_SESSION["isLogged"] = true;
		header('Location: ../index.php');
	}
}


?>