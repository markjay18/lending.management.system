<?php
include 'include/dbcon.php';
$ID=0;
if(isset($_GET['ID'])){
	$ID = $_GET['ID'];
}
/*Activate accounts.*/
$sql="UPDATE members SET status='Active' WHERE ID='".$ID."' ";
$update = mysql_query($sql) or die(mysql_error());

if($update){
		header('Location: accounting.php');
	}
?>