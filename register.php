<?php
include 'include/dbcon.php';

if(isset($_POST['submit'])){
$fullname = $_POST['fullname'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$uid = $_POST['uid'];
$rpassword = $_POST['rpassword'];

$sql = "INSERT INTO access(fullname, address, phone, email, uid, rpassword) VALUES ('".$fullname."', '".$address."', '".$phone."', '".$email."', '".$uid."', '".$rpassword."')";
$insert = mysql_query($sql) or die(mysql_error());

header('Location: register.php?succ=account_successfully_added');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>LadzBill</title>
</head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="jquery-ui-1.10.4.customs/themes/base/jquery.ui.all.css">
	<script src="js/jquery-1.10.2.js"></script>
	<script src="jquery-ui-1.10.4.customs/ui/jquery.ui.core.js"></script>
	<script src="jquery-ui-1.10.4.customs/ui/jquery.ui.widget.js"></script>
	<script src="jquery-ui-1.10.4.customs/ui/jquery.ui.tabs.js"></script>
	<script src="jquery-ui-1.10.4.customs/ui/jquery.ui.datepicker.js"></script>
	<script src="jquery-ui-1.10.4.customs/ui/jquery.ui.dialog.js"></script>
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/bootstrap.js"></script>

<link href="css/dashboard.css" rel="stylesheet">
<script type="text/javascript">
	var x = setInterval(mytimer, 1000);

	function mytimer() {
		var d = new Date();
		document.getElementById('clock').innerHTML = d.toLocaleTimeString();
	}
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#btn').hide();
		$('#frame').css({'margin-left':'13%', 'width':'87%'}, "slow");
		$('#btn').click(function(){
			$('nav').show("slow");
			$('#frame').css({'margin-left':'13%', 'width':'87%'}, "slow");
			$('#btn').hide();
		});
		$('#cancel').click(function(){
			$('nav').hide("slow");
			$('#frame').css({'margin-left':'6%', 'width':'94%'}, "slow");
			$('#btn').show();
		});
	});
</script>
<script type="text/javascript">
	function validate(){
		var password = document.getElementById('password').value;
		var rpassword = document.getElementById('rpassword').value;

		if (password != rpassword){
			alert("Password Mismatch. Please try again!");
			document.getElementById('password').style.boxShadow = "0 0 5px #e56b62";
			document.getElementById('rpassword').style.boxShadow = "0 0 5px #e56b62";
			document.getElementById('show').style.display = "block";
			return false
		}
		
	}
</script>
<body>
	<div class="header">
		<p class="logo"><strong>|LADZ</strong>BILL</p>
			<p class="id">
				<p class="time"><?php date_default_timezone_set("ASIA/MANILA"); echo "". date('m-d-Y');?> | <p id="clock"></p></p> 
				<p class="name"></p> 
				<input type="text" name="uid" class="acc" value="<?php echo "" .$_SESSION['uid']; ?>" size="14px;" readonly >
			</p>
	</div>
		<label>
			<i class="fa fa-bars" id="btn"></i>
		</label>
	<nav>
		<header></header>
		<ul>
			<li><a href="" class="<?php echo (!isset($_GET['page'])) ? "active" : ""; ?>"><i class="fa fa-user-plus"></i> Register Account</a></li>
			<div id="cancel"><</div>
		</ul>
	</nav>

<div id="frame">
	<p class="dash">Create</p>
	<p class="direction"> Administrative > Registration >  Create Account</p>
	<p class="line"></p>
	<form method="POST" onsubmit="return validate()">
		<p id="show" class="err" style="display:none;">Password mismatch! Please try again.</p>
		<?php
			// display success message using PHP with url.
			$allurl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
				if (strpos($allurl, "succ=account_successfully_added") == true) {
					echo '<p class="succ">Password match! Account successfully added ready, to use for login portal.</p>';
				}
			?>
		<div style="width: 20%;">
			<label>Full Name *</label><br>	
			<input type="text" name="fullname" class="input" id="fullname" autocomplete="off" required autofocus />
		</div>

		<div style="width: 20%;">
				<label>Address *</label><br>	
		<textarea name="address" class="input" id="address" cols="50" rows="4" placeholder="Enter complete address." required></textarea>
		</div>

		<div style="float: left; width: 20%;">
			<label>Contact No. *</label><br>	
			<input type="text" name="phone" class="input" id="phone" autocomplete="off" required />
		</div>

		<div style="float: left; width: 20%; margin-left: 20px;">
			<label>Email Address *</label><br>	
			<input type="text" name="email" class="input" id="email" autocomplete="off" required />
		</div>

		<div style="float: left; width: 20%; margin-left: 20px;">
			<label>User ID *</label><br>
			<input type="text" name="uid" class="input" id="uid" autocomplete="off" required />
		</div>

		<div style="width: 20%;">
			<label>Password *</label><br>
			<input type="password" name="password" class="input" id="password" autocomplete="off" required />
		</div>

		<div style="width: 20%;">
			<label>Password *</label><br>
		<input type="password" name="rpassword" class="input" id="rpassword" autocomplete="off" required />
		</div>

		<p class="line"></p>
		<button name="submit" class="button" id="submit" type="submit" >Submit</button>
	</form>
</div>

<div class="footer">
		<p>- LADZBILL | Version 1.0.0.1 @ 2021</p>
</div>

</body>
</html>