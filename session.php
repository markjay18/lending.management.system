<?php
session_start();
if(!empty($_SESSION['ID'])) {
$ID = $_SESSION['ID'];
$uid = $_SESSION['uid'];
$rpassword = $_SESSION['rpassword'];
}else{
		header("Location: login.php");	
}
?>
