<?php
include 'include/dbcon.php';
$ID=0;
if(isset($_GET['ID'])){
	$ID = $_GET['ID'];
}
/*Delete accounts from members.*/
$sql="DELETE FROM members WHERE ID='".$ID."' ";
$delete = mysql_query($sql) or die(mysql_error());

if($delete){
		header('Location: accounting.php');
	}
?>