<?php 
include 'include/dbcon.php';
include 'session.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Area Collections</title>
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
		<button><a href="logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></button>
	</div>	
		<label>
			<i class="fa fa-bars" id="btn"></i>
		</label>
	<nav>
		<header></header>
		<ul>
			<li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="membership.php"><i class="fa fa-user-plus"></i> Association</a></li>
			<li><a href="disbursement.php"><i class="fa fa-user"></i> Personal Loan</a></li>
			<li><a href="marketing.php"><i class="fa fa-calendar-check-o"></i> Marketing</a></li>
			<li><a href="" class="<?php echo (!isset($_GET['page'])) ? "active" : ""; ?>"><i class="fa fa-money"></i> Collections</a></li>
			<div id="cancel"><</div>
		</ul>

	</nav>

	<div id="frame">
		<p class="dash">Branches</p>
		<p class="direction">Loan Management System > Collections > Area</p> 
		<p style="margin-top: 20px;"><a href="">Add Branch</a></p>
		<table id="customers" style="width: 96%;">
			<tr>
				<th>ID#</th>
				<th>Town</th>
				<th>Main Office</th>
				<th>Area Manager</th>
				<th>Action</th>
			</tr>
			<?php  
			$sql="SELECT * FROM branch";
	 		$query=mysql_query($sql);
	 		while($recordset=mysql_fetch_array($query)){
			?>
			<tr>
				<td style="color: grey; border-right: 2px solid rgb(245 245 245); width: 10px; text-align: center;"><?php echo $recordset['ID']; ?></td>
				<td style="color: #009879;"><?php echo $recordset['area']; ?></td>
				<td><?php echo $recordset['main']; ?></td>
				<td style="color: #009879;"><?php echo $recordset['manager']; ?></td>
				<td style="border-left: 2px solid rgb(245 245 245);"><a href="loan_payment.php?ID=<?php echo $recordset['ID'];?>&&accno=<?php echo $recordset['accno']; ?>"><button id="info" style="background: #16b330; width: 30px;"><i class="fa fa-eye"></i></button></a><a href="loan_payment.php?ID=<?php echo $recordset['ID'];?>&&accno=<?php echo $recordset['accno']; ?>"><button id="info" style="background: #009879; width: 30px; margin-left: 5px;"><i class="fa fa-pencil"></i></button></a><a href="#tbl_data" onclick="popDelete('delete_user.php?ID=<?php echo $recordset['ID'];?>')" ><button id="info" style="background: #ef3b3b; width: 30px; margin-left: 5px;"><i class="fa fa-trash"></i></button></a></td>				
			</tr>
			<?php
			}
	  		?>
		</table>

		<?php
		$sql="SELECT * FROM branch";
		$query=mysql_query($sql);
		$recordset=mysql_fetch_array($query);
		$row = mysql_num_rows($query);
		if($row == 0){
			echo '<p style="width: 95.7%; text-align:center; color:#e56b62;">No record found.</p>';
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

