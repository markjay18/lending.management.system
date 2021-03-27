<?php
include 'include/dbcon.php';
session_start();

// to prevent mysql injection.
$username=stripslashes($username);
$password=stripslashes($password);	 
$username=mysql_real_escape_string($username);
$password=mysql_real_escape_string($password);

if(isset($_POST['submit'])) {
$uid = $_POST['uid'];
$rpassword = $_POST['rpassword'];

// query database for login.
$sql="SELECT * FROM access WHERE uid='".$uid."' AND rpassword='".$rpassword."'";
 $query=mysql_query($sql);
 $recordset=mysql_fetch_array($query);
 $row=mysql_num_rows($query);

 if ($recordset['uid']!=""){
 	$_SESSION['ID'] = $recordset['ID'];
	$_SESSION['uid'] = $recordset['uid'];
	$_SESSION['rpassword'] = $recordset['rpassword'];
 	header("Location: dashboard.php");
 }else if ($recordset['uid']==""){
 	$_SESSION['ID'] = $recordset['ID'];
	$_SESSION['uid'] = $recordset['uid'];
	$_SESSION['rpassword'] = $recordset['rpassword'];
 	header("Location: login.php?attempt=login_failed");
 }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>LadzBill</title>
</head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="css/login.css" rel="stylesheet">

<body>
<div class="login-page">
	<div class="form">
	<h3>Login</h3>
	<?php
	// Display error message using PHP url.
	$allurl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
	if (strpos($allurl, "attempt=login_failed") == true) {
		echo '<p class="err">Incorrect UserID or Password.</p>';
	}
	 ?>
	<form method="POST">
		<input type="text" name="uid" id="uid" autocomplete="off" placeholder="UserID" title="uid" required autofocus />
		<input type="password" name="rpassword" id="rpassword" autocomplete="off" placeholder="Password" title="rpassword" required />
		<button name="submit" id="submit" type="submit" >login</button>
			<p class="message">
				<a href="./">Home</a> | 
				<a href="#">Forgot Password</a>
			</p>
			<p class="message">- LADZBILL</p>
	</form>
	</div>
</div>
</body>
</html>