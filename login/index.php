<title> Login </title>
<?php
require_once('../functions/login.php');
session_start();

if (isset($_SESSION["isLogged"]) and $_SESSION["isLogged"] == true)
	header('Location: ../index.php');

?>
	<br>
	<div style="float:left;width:200px;text-align:right;">
		Username:<br>
		Password:<br>
	</div>

	<div style="margin-left:215px">
		<form action=# method=POST>
			<input type=text name=username> <br>
			<input type=password name=password> <br> <br>
			<input type=submit name=go value=login>
		</form>
	</div>


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