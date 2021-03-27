<?php 
session_start();
	session_destroy();
	unset($_SESSION['ID']);
	header("Location: login.php");
 ?>