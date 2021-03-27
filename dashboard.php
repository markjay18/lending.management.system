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
/*Retrieving data from tables.*/
$sql="SELECT * FROM ledger WHERE duedate = date_format(CURDATE(), '%m-%d-%Y') AND operator =''";
$query=mysql_query($sql);
$recordset=mysql_fetch_array($query);
$row = mysql_num_rows($query);

$sql="SELECT * FROM ledger WHERE payment != ''";
$query=mysql_query($sql);
$recordset=mysql_fetch_array($query);
$row_suc = mysql_num_rows($query);

$sql="SELECT * FROM members WHERE status = 'Overdue'";
$query=mysql_query($sql);
$recordset=mysql_fetch_array($query);
$row_stat = mysql_num_rows($query);

$sql="SELECT * FROM members WHERE balance != '0'";
$query=mysql_query($sql);
$recordset=mysql_fetch_array($query);
$row_bal = mysql_num_rows($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>My Dashboard</title>
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
<body>
	<div class="header">
		<p class="logo"><strong>|LADZ</strong>BILL</p>
			<p class="id">
				<p class="time"><?php date_default_timezone_set("ASIA/MANILA"); echo "". date('m-d-Y');?> | <p id="clock"></p></p> 
				<p class="name">|Lord:</p> 
				<input type="text" name="uid" class="acc" value="<?php echo "" .$_SESSION['uid']; ?>" size="14px;" readonly >
			</p>
		<button style="float: left;"><a href="logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></button>
	</div>	
		<label>
			<i class="fa fa-bars" id="btn"></i>
		</label>
	<nav>
		<header></header>
		<ul>
			<li><a href="" class="<?php echo (!isset($_GET['page'])) ? "active" : ""; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="membership.php"><i class="fa fa-user-plus"></i> Association</a></li>
			<li><a href="disbursement.php"><i class="fa fa-user"></i> Personal Loan</a></li>
			<li><a href="marketing.php"><i class="fa fa-calendar-check-o"></i> Marketing</a></li>
			<li><a href="collection.php"><i class="fa fa-money"></i> Collections</a></li>
			<div id="cancel"><</div>
			<li><a href="accounting.php" target="_blank"><i class="fa fa-book"></i> Accounting</a></li>
		</ul>

	</nav>

	<div id="frame">
		<p class="dash">Dashboard</p>
		<p class="direction">Loan Management System > Panel > Payments</p> 
		<a href="dashboard.php"><div class="payment" style="box-shadow: none; background: #faf7f7;">
			<p>Payment Today :</p>
			<input type="text" style="cursor: pointer; background: #faf7f7;" name="" class="count" value="<?php echo $row;?>" readonly>
		</div></a>
		<a href="success_payment.php"><div class="payment">
			<p>Successful Payments :</p>
			<input type="text" style="cursor: pointer;" name="" class="count" value="<?php echo $row_suc;?>" readonly>
		</div></a>
		<a href="overdue_payment.php"><div class="payment">
			<p>Over Due (Lapse) :</p>
			<input type="text" style="cursor: pointer;" name="" class="count" value="<?php echo $row_stat;?>" readonly>
		</div></a>
		<div class="payment" style="cursor: none;">
			<p>Total Members w/ Loan :</p>
			<input type="text" name="" class="count" value="<?php echo $row_bal;?>" readonly>
		</div>
		<p class="top">Payment List</p>
	<div class="scroll">
		<table id="customers">
			<tr>
				<th>Action</th>
				<th>Due Date</th>
				<th>Name</th>
				<th>Amount</th>
				<th>Extra</th>
				<th>Method</th>
				<th>Operator</th>
				<th>Remarks</th>
			</tr>
			<?php  
			$sql="SELECT * FROM ledger WHERE duedate = date_format(CURDATE(), '%m-%d-%Y') AND operator =''";
	 		$query=mysql_query($sql);
	 		while($recordset=mysql_fetch_array($query)){
			?>
			<tr>
				<td><a href="loan_payment.php?ID=<?php echo $recordset['ID'];?>&&accno=<?php echo $recordset['accno']; ?>"><button id="info">Pay</button></a></td>
				<td><?php echo $recordset['duedate']; ?></td>
				<td><?php echo $recordset['name']; ?></td>
				<td><?php echo $recordset['payamount']; ?></td>
				<td><?php echo $recordset['extrapay']; ?></td>
				<td><?php echo $recordset['method']; ?></td>
				<td><?php echo $recordset['operator']; ?></td>
				<td><?php echo $recordset['remarks']; ?></td>
				
			</tr>
			<?php
			}
	  		?>
		</table>

		<?php
		$sql="SELECT * FROM ledger WHERE duedate = date_format(CURDATE(), '%m-%d-%Y') AND operator =''";
		$query=mysql_query($sql);
		$recordset=mysql_fetch_array($query);
		$row = mysql_num_rows($query);
		if($row == 0){
			echo '<p style="width: 95.7%; text-align:center; color:#e56b62;">No payment for today.</p>';
		}else{
			echo '';
		}
		?>
	</div>
	</div>

	<div class="footer">
		<p>- LADZBILL | Version 1.0.0.1 @ 2021</p>
	</div>
</body>
</html>

