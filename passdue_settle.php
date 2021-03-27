<?php
include 'include/dbcon.php';
include 'session.php';
/*view admin userID*/
$ID=0;
if(isset($_GET['ID'])){
 $ID = $_GET['ID'];
}
$accno=0;
if(isset($_GET['accno'])){
 $accno = $_GET['accno'];
}

  $sqlQ="SELECT * FROM members WHERE accno='".$accno."'";
  $queryQ=mysql_query($sqlQ);
  $recordsetQ=mysql_fetch_array($queryQ);

if(isset($_POST['save'])){
$update_date = $_POST['update_date'];
$extrapay = $_POST['extrapay'];
$payment = $_POST['payment'];
$method = $_POST['method'];
$ref = $_POST['ref'];
$operator= $_POST['operator'];
$comment= $_POST['comment'];
$remarks= $_POST['remarks'];

$sql="UPDATE ledger SET update_date ='".$update_date."', extrapay ='".$extrapay."', payment ='".$payment."', method ='".$method."', ref ='".$ref."', operator ='".$operator."', comment ='".$comment."', remarks ='".$remarks."' WHERE ID='".$ID."'";
$update_payment = mysql_query($sql) or die(mysql_error());


$balance = $_POST['balance'];
$sql="UPDATE members SET balance='".$balance."' WHERE accno='".$recordsetQ['accno']."'";
$update_balance = mysql_query($sql) or die(mysql_error());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Passdue Settlement</title>
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
	/*autocomplete field open_balance script*/
$(document).ready(function (){
$('#actual').change(function (){
		var actual = ($(this).val());
		var bal = $('#bal').val(); 
		var sub2 = parseFloat(bal) - parseFloat(actual);
		$('#bal').val(sub2);
		
	});		
});
</script>
<script type="text/javascript">
	/*autocomplete field open_balance script*/
$(document).ready(function (){
$('#extra').change(function (){
		var extra = ($(this).val());
		var bal = $('#bal').val(); 
		var sub2 = parseFloat(bal) - parseFloat(extra);
		$('#bal').val(sub2);
		
	});		
});
</script>
<body>
	<div class="header">
		<p class="logo"><strong>|LADZ</strong>BILL</p>
			<p class="id">
				<p class="time"><?php date_default_timezone_set("ASIA/MANILA"); echo "". date('m-d-Y');?> | <p id="clock"></p></p> 
				<p class="name">|Lord:</p> 
				<input type="text" name="uid" class="acc" value="<?php echo "" .$_SESSION['uid']; ?>" size="14px;" readonly >
			</p>
		<button><a href="logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></button>
	</div>
		<label>
			<i class="fa fa-bars" id="btn"></i>
		</label>
	<nav>
		<header></header>
		<ul>
			<li><a href="" class="<?php echo (!isset($_GET['page'])) ? "active" : ""; ?>"><i class="fa fa-money"></i> Pay Settlement</a></li>
			<div id="cancel"><</div>
		</ul>
	</nav>

<div id="frame">
	<p class="dash">Create Payment</p>
	<p class="direction">Loan Management System > Passdue Settlement > Create Payment </p>
	<p class="line"></p>
	<form method="POST" onsubmit="return confirm('Are you sure you want to save this entire data?')">
		<label>Account Number : </label>
			<input type="text" name="accno" class="view_input" value="<?php echo $recordsetQ['accno']; ?>" readonly required><br>
		<label>Name : </label>
			<input type="text" name="name" class="view_input" value="<?php echo $recordsetQ['fullname']; ?>" readonly required><br>
		<label>Current Balance (autocomplete) : </label><br>
			<input type="text" style="font-size: 28px;" id="bal" name="balance" class="view_input" value="<?php echo $recordsetQ['balance']; ?>" readonly required><br>
		<div style="float: left; width: 14%;">
				<label>Actual Payment *</label><br>
				<input type="text" id="actual" name="payment" class="input">
		</div>
		<div style="float: left; width: 20%; margin-left: 20px;">
			<label>Reference OR# : </label><br>
			<input type="text" name="ref" id="" class="input" value="" required>
			</div>
		<div style="width: 14%;">
			<label>Extra Payment : </label><br>
			<input type="text" name="extrapay" id="extra" class="input" value="0" required>
		</div>
		<div style="width: 14%;">	
				<label>Payment Method : </label><br>
				<select type="text" name="method" class="input" required>
					<option selected></option>
					<option>Cash</option>
					<option>GCash</option>
				</select>
		</div>
		<div style="width: 80%;">
			<label>Remarks *</label><br>
				<textarea name="comment" style="width: 80%;" class="input" cols="50" rows="4" readonly required>Settlement</textarea><br>
		</div>
		<input type="hidden" name="remarks" value="Settlement">
		<input type="hidden" name="operator" value="<?php echo "" .$_SESSION['uid']; ?>">
		<input type="hidden" name="update_date" value="<?php date_default_timezone_set("ASIA/MANILA"); echo "". date('m-d-Y');?>">

			<p class="line"></p>
			<button name="save" class="button" style="width: 8%; float: left;"><i class="fa fa-save"></i> Confirm</button>
	</form>
</div>

<div class="footer">
		<p>- LADZBILL | Version 1.0.0.1 @ 2021</p>
</div>

</body>
</html>