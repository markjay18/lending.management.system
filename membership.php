<?php 
include 'include/dbcon.php';
include 'session.php';

$ID=0;
if(isset($_GET['ID'])){
 $ID = $_GET['ID'];
}
 $sql="SELECT * FROM access WHERE ID='".$ID."'";
 $query=mysql_query($sql);
 $recordset=mysql_fetch_array($query);

if(isset($_POST['submit'])){
$accno = $_POST['accno'];
$fullname = $_POST['fullname'];
$dater = $_POST['dater'];
$gender = $_POST['gender'];
$mstatus = $_POST['mstatus'];
$nationality = $_POST['nationality'];
$address = $_POST['address'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$bankacc = $_POST['bankacc'];
$sponsor = $_POST['sponsor'];
$amountloan = $_POST['amountloan'];
$balance = $_POST['balance'];
$status = $_POST['status'];
$purpose = $_POST['purpose'];
$operator = $_POST['operator'];

/*if account number exist.*/
$check = "SELECT accno FROM members WHERE accno='".$accno."'";
$result = mysql_query($check);
if(mysql_num_rows($result) > 0){
	header("Location: membership.php?err=account_number_exist");
	return false;
}else{

$sql = "INSERT INTO members(accno, fullname, dater, gender, mstatus, nationality, address, contact, email, bankacc, sponsor, amountloan, balance, status, purpose, operator) VALUES ('".$accno."', '".$fullname."', '".$dater."', '".$gender."', '".$mstatus."', '".$nationality."', '".$address."', '".$contact."', '".$email."', '".$bankacc."', '".$sponsor."', '".$amountloan."', '".$balance."', '".$status."', '".$purpose."', '".$operator."')";
	$insert = mysql_query($sql) or die(mysql_error());

	header("Location: membership.php?sql_query=successfully_added");
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Add New Members</title>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
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
	/*Prevent using space while typing.*/
	function nospaces(t){
		if(t.value.match(/\s/g)){
			t.value = t.value.replace(/\s/g, '');
		}
	}

</script>
<body>
	<div class="header">
		<p class="logo"><strong>|LADZ</strong>BILL</p>
			<p class="id">
				<p class="time"><?php date_default_timezone_set("ASIA/MANILA"); echo "". date('m-d-Y');?> | <p id="clock"></p></p> 
				<p class="name">|Lord:</p> 
				<input type="text" name="operator" class="acc" value="<?php echo "" .$_SESSION['uid']; ?>" size="14px;" readonly >
			</p>
		<button><a href="logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></button>
	</div>	
		<label>
			<i class="fa fa-bars" id="btn"></i>
		</label>
	<nav>
		<header></header>
		<ul>
			<li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="" class="<?php echo (!isset($_GET['page'])) ? "active" : ""; ?>"><i class="fa fa-user-plus"></i> Association</a></li>
			<li><a href="disbursement.php"><i class="fa fa-user"></i>  Personal Loan</a></li>
			<li><a href="marketing.php"><i class="fa fa-calendar-check-o"></i> Marketing</a></li>
			<li><a href="collection.php"><i class="fa fa-money"></i> Collections</a></li>
			<div id="cancel"><</div>
		</ul>
	</nav>

	<div id="frame">
		<form method="POST" onsubmit="return confirm('Please review all the details before proceeding.')">
			<p class="dash">Add Member</p>
			<p class="direction">Loan Management System > Association > Create</p>
			<p class="line"></p>
			<?php
			// display success message using PHP with url.
			$allurl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
				if (strpos($allurl, "sql_query=successfully_added") == true) {
					echo '<p class="succ">Data has been Saved!</p>';
				}
				if (strpos($allurl, "err=account_number_exist") == true) {
					echo '<p class="err">Account number exist! Record not save. Try again.</p>';
				}
			?>
			<div style="width: 20%;">
				<label>Account Number *</label><br>
				<input type="text" name="accno" id="read" onkeyup="nospaces(this)" class="input" required autofocus>
			</div>
			<div style="float: left; width: 20%;">
				<label>Full Name *</label><br>			
				<input type="text" name="fullname" id="name" class="input" required>
			</div>
			<div style="float: left; width: 20%; margin-left: 20px;">
				<label>Gender *</label><br>			
				<select type="text" name="gender" class="input" required>
					<option>Male</option>
					<option>Female</option>
				</select>
			</div>
			<div style="float: left; width: 20%; margin-left: 20px;">
				<label>Marital Status *</label><br>			
				<select type="text" name="mstatus" class="input" required>
					<option>Single</option>
					<option>Merried</option>
					<option>Widowed</option>
					<option>Separated</option>
					<option>Devorced</option>
				</select>
			</div>
			<div style="float: left; width: 20%; margin-left: 20px;">
				<label>Nationality *</label><br>			
				<select type="text" name="nationality" class="input" required>
					<option>Afganistani</option>
					<option>American</option>
					<option>Chinese</option>
					<option>Francian</option>
					<option>Indian</option>
					<option selected>Filipino</option>
				</select>
			</div><br>
			<div style="width: 20%;">
				<label>Address *</label><br>
				<textarea name="address" class="input" cols="50" rows="4" placeholder="Enter complete address." required></textarea>
			</div>
			<div style="float: left; width: 20%;">
				<label>Contact Number *</label><br>
				<input type="text" name="contact" class="input" required>
			</div>
			<div style="float: left; width: 20%; margin-left: 20px;">
				<label>Email Address *</label><br>
				<input type="text" name="email" class="input" required><br>
			</div>
			<div style="float: left; width: 20%; margin-left: 20px;">
				<label>Bank Account Number *</label><br>
				<input type="text" name="bankacc" class="input" placeholder="(optional)" required>
			</div>
			<div style="float: left; width: 20%; margin-left: 20px;">
				<label>Sponsor *</label><br>
				<input type="text" name="sponsor" class="input" required>
			</div><br>
			<div style="width: 20%;">
				<label>Purpose of Borrowing *</label><br>
				<textarea name="purpose" class="input" cols="50" rows="4" placeholder="Please state reason here." required></textarea><br>
			</div>
				
				<input type="hidden" name="dater" class="acc" value="<?php date_default_timezone_set("ASIA/MANILA"); echo "". date('m-d-Y');?>" required>
				<input type="hidden" name="amountloan" class="acc" value="-" required>
				<input type="hidden" name="balance" class="acc" value="0" required>
				<input type="hidden" name="status" class="acc" value="first time" required>
				<input type="hidden" name="operator" class="acc" value="<?php echo "" .$_SESSION['uid']; ?>" required>
			
			<p class="line"></p>
			<button class="button" name="submit"><i class="fa fa-save"></i> Submit</button>
		</form>
	</div>

	<div class="footer">
		<p>- LADZBILL | Version 1.0.0.1 @ 2021</p>
	</div>
</body>
</html>
</html>