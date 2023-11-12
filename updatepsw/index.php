<title> Cambio password </title>
<?php
require_once('../functions/general.php');
session_start();
printHead();

if (!isLogged()) {
	echo "redirectoring to login";
	header('Location: ../login');
} else {
?>
	<form action=../> 
		<input type=submit value='← indietro'> 
	</form>

	<div style="float:left;width:200px;text-align:right;">
		Username: <br>
		Password attuale: <br>
		Nuova password: <br>
		Ripeti nuova password: <br>
	</div>

	<div style="margin-left:215px">
		<form action=update.php method=POST>
			 <input type=text name=username required> <br>
			 <input type=password name=oldPsw> <br>
			 <input type=password name=nPsw required> <br>
			 <input type=password name=n2Psw required> <br> <br>
			 <input type=submit name=go value=cambia>
		</form>
	</div>
<br>
<i> *se questo è il tuo primo cambio password lascia in bianco il campo "Password attuale" <i>
	

<?php
}