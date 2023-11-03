<title> Login </title>
<?php
require_once('../functions/login.php');
session_start();

if (isset($_SESSION["isLogged"]) and $_SESSION["isLogged"] == true)
	header('Location: ../index.php');

?>

	<form action=# method=POST>
		username <input type=text name=username> <br>
		password <input type=password name=password> <br>
		<input type=submit name=go value=login>
	</form>

<?php
if (isset($_POST["go"])) {
	if (isInLogin()) {
		
		$id = foundIdUser();
		$_SESSION["idUser"] = $id;
		$_SESSION["isLogged"] = true;
		
		$conn = connection();
		$queryResultParent = mysqli_query($conn, "SELECT * FROM rigaruoli WHERE idUserFK = $id AND idRuoloFK = 2");		
		$_SESSION["isParent"] = (mysqli_num_rows($queryResultParent) == 1);
		
		$queryResultTrainer = mysqli_query($conn, "SELECT * FROM rigaruoli WHERE idUserFK = $id AND idRuoloFK = 1");		
		$_SESSION["isTrainer"] = (mysqli_num_rows($queryResultTrainer) == 1);
		
		$queryResultAdmin = mysqli_query($conn, "SELECT * FROM rigaruoli WHERE idUserFK = $id AND idRuoloFK = 0");		
		$_SESSION["isAdmin"] = (mysqli_num_rows($queryResultAdmin) == 1);
		
		header('Location: ../index.php');
	} else {
		echo "<br>username o password errati";
	}
	
}


?>