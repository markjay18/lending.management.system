<?php 
include 'include/dbcon.php';
include 'session.php';
/*view admin userID*/
$ID=0;
if(isset($_GET['ID'])){
 $ID = $_GET['ID'];
}
 $sql="SELECT * FROM access WHERE ID='".$ID."'";
 $query=mysql_query($sql);
 $recordset=mysql_fetch_array($query);

 $sqlQ="SELECT * FROM ledger WHERE ID='".$ID."'";
 $queryQ=mysql_query($sqlQ);
 $recordsetQ=mysql_fetch_array($queryQ);

/*Get members account number*/
$accno=0;
if(isset($_GET['accno'])){
 $accno = $_GET['accno'];
}
$sqll="SELECT * FROM members WHERE accno='".$accno."'";
  $queryl=mysql_query($sqll);
  $recordsetl=mysql_fetch_array($queryl);


  	if(isset($_POST['save'])){

		$balance = $_POST['balance'];
		$sql="UPDATE members SET balance='".$balance."' WHERE accno='".$recordsetQ['accno']."'";
		$update = mysql_query($sql) or die(mysql_error());

		$update_date = $_POST['update_date'];
		$payment = $_POST['payment'];
		$extrapay = $_POST['extrapay'];
		$method = $_POST['method'];
		$ref = $_POST['ref'];
		$operator = $_POST['operator'];
		$comment = $_POST['comment'];
		$remarks = $_POST['remarks'];

		$sql="UPDATE ledger SET update_date='".$update_date."', payment='".$payment."', extrapay='".$extrapay."', method='".$method."', ref='".$ref."', operator='".$operator."', comment='".$comment."', remarks='".$remarks."' WHERE ID='".$ID."'";
		$updatel = mysql_query($sql) or die(mysql_error());
	}

	if(isset($_POST['pass'])){
		$update_date = $_POST['update_date'];
		$remarks = $_POST['remarks'];
		$operator = $_POST['operator'];
		$sql="UPDATE ledger SET update_date='".$update_date."', remarks='".$remarks."', operator='".$operator."' WHERE ID='".$ID."'";
		$updateQ = mysql_query($sql) or die(mysql_error());
	}
	if($update && $updatel){
		header('Location: dashboard.php');
	}
	if($updateQ){
		header('Location: dashboard.php');
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Loan Payment</title>
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
			<li><a href="" class="<?php echo (!isset($_GET['page'])) ? "active" : ""; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="membership.php"><i class="fa fa-user-plus"></i> Association</a></li>
			<li><a href="disbursement.php"><i class="fa fa-user"></i>  Personal Loan</a></li>
			<li><a href="marketing.php"><i class="fa fa-calendar-check-o"></i> Marketing</a></li>
			<li><a href="collection.php"><i class="fa fa-money"></i> Collections</a></li>
			<div id="cancel"><</div>
		</ul>
	</nav>

	<div id="frame">
			<p class="dash">Payment Info.</p>
			<p class="direction">Loan Management System > Panel > Payment Info</p>
			<p class="line"></p>
			<label>Account Number : </label>
			<input type="text" name="accno" class="view_input" value="<?php echo $recordsetQ['accno']; ?>" readonly required>

			<label>Date : </label>
			<input type="text" name="dater" class="view_input" value="<?php echo $recordsetQ['duedate']; ?>" readonly required><br>

			<label>Name : </label>
			<input type="text" name="fullname" class="view_input" value="<?php echo $recordsetQ['name']; ?>" readonly required><br>

		<form method="POST" onsubmit="return confirm('Confirm.')">

			<label>Current Balance (autocomplete) : </label><br>
			<input type="text" style="font-size: 28px;" name="balance" id="bal" class="view_input" value="<?php echo $recordsetl['balance']; ?>" readonly required><br>

			<div style="float: left; width: 20%;">
			<label>Actual Payment : </label><br>
			<input type="text" name="payment" id="actual" class="input" value="0" required>
			</div>

			<div style="float: left; width: 20%; margin-left: 20px;">
			<label>Reference OR# : </label><br>
			<input type="text" name="ref" id="" class="input" value="" required>
			</div>

			<div style="width: 20%;">
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
				<textarea name="comment" style="width: 80%;" class="input" cols="50" rows="4" required></textarea><br>
			</div>

			<input type="hidden" name="operator" value="<?php echo "" .$_SESSION['uid']; ?>">
			<input type="hidden" name="update_date" value="<?php date_default_timezone_set("ASIA/MANILA"); echo "". date('m-d-Y');?>">
			<input type="hidden" name="remarks" value="Paid">

			<p class="line"></p>
			<button name="save" class="button" style="width: 8%; float: left;"><i class="fa fa-save"></i> Confirm</button>
		</form>

		<form method="POST" onsubmit="return confirm('Confirm.')">
			<input type="hidden" name="remarks" value="Passdue">
			<input type="hidden" name="operator" value="<?php echo "" .$_SESSION['uid']; ?>">
			<input type="hidden" name="update_date" value="<?php date_default_timezone_set("ASIA/MANILA"); echo "". date('m-d-Y');?>">
			<a href="print_ledger.php?accno=<?php echo $recordsetQ['accno'];?>" target="_blank"><button name="pass" class="button" style="width: 8%; background: #f44336; float: left; margin-left: 5px;"><i class="fa fa-calendar"></i> Passdue</button></a>
		</form>

	</div>

	<div class="footer">
		<p>- LADZBILL | Version 1.0.0.1 @ 2021</p>
	</div>
</body>
</html>
</html>