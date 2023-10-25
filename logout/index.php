<?php
session_start();
$_SESSION["idUser"] = -1;
$_SESSION["isLogged"] = false;
header("Location: ../index.php");
?>