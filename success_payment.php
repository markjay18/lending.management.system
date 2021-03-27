<?php 
include 'include/dbcon.php';
include 'session.php';
$record_per_page = 10;
$ID=0;
if(isset($_GET['ID'])){
 $ID = $_GET['ID'];
}else{
	$ID=1;
}
/*Retrieving data from.*/
$sql="SELECT * FROM access WHERE ID='".$ID."'";
$query=mysql_query($sql);
$recordset=mysql_fetch_array($query);

$sql="SELECT * FROM ledger WHERE duedate = date_format(CURDATE(), '%m-%d-%Y') AND operator =''";
$query=mysql_query($sql);
$recordset=mysql_fetch_array($query);
$row = mysql_num_rows($query);

$sql="SELECT * FROM ledger WHERE payment != ''";
$query=mysql_query($sql);
$recordset=mysql_fetch_array($query);
$row_suc = mysql_num_rows($query);

$sql="SELECT * FROM members WHERE status = 'overdue'";
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

    <script src="source/jquery.fancybox.js"></script>
	<link rel="stylesheet" type="text/css" href="source/jquery.fancybox.css" media="screen">

<link href="css/dashboard.css" rel="stylesheet">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
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
	function page(){
		var td = getElementById('td').value;
		localStorage.setItem(td);
	}
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
			<li><a href="" class="<?php echo (!isset($_GET['page'])) ? "active" : ""; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="membership.php"><i class="fa fa-user-plus"></i> Association</a></li>
			<li><a href="disbursement.php"><i class="fa fa-user"></i> Personal Loan</a></li>
			<li><a href="marketing.php"><i class="fa fa-calendar-check-o"></i> Marketing</a></li>
			<li><a href="collection.php"><i class="fa fa-money"></i> Collections</a></li>
			<div id="cancel"><</div>
		</ul>
	</nav>

	<div id="frame">
		<p class="dash">Dashboard</p>
		<p class="direction">Loan Management System > Panel > Successful Payments</p>
		<a href="dashboard.php"><div class="payment">
			<p>Payment Today :</p>
			<input type="text" style="cursor: pointer;" name="" class="count" value="<?php echo $row;?>" readonly>
		</div></a>
		<a href="success_payment.php"><div class="payment" style="box-shadow: none; background: #faf7f7;">
			<p>Successful Payments :</p>
			<input type="text" style="cursor: pointer; background: #faf7f7;" name="" class="count" value="<?php
			echo $row_suc;?>" readonly>
		</div></a>
		<a href="overdue_payment.php"><div class="payment">
			<p>Over Due (Lapse) :</p>
			<input type="text" style="cursor: pointer;" name="" class="count" value="<?php echo $row_stat;?>" readonly>
		</div></a>
		<div class="payment" style="cursor: none;">
			<p>Total Members w/ Loan :</p>
			<input type="text" name="" class="count" value="<?php echo $row_bal;?>" readonly>
		</div>
		<p class="top">Successfull Payment Processed List / Search by date</p>


		<div style="width: 96%; display: inline-flex;"><label style="margin-left: 10px;" >
		<form method="POST" style="float: left;">
			Start Date : </label><input type="date" style="font-size: 16px; color: #81386e; padding: 3px;" id="date" name="from" autocomplete="off" value="" required>
			<label style="margin-top: 4px; margin-left: 10px; ">End Date : </label><input type="date" style="font-size: 16px; color: #81386e; padding: 3px;" id="dater" name="to" autocomplete="off" value="" required>
			<label style="margin-top: 4px; margin-left: 10px; ">Remarks : </label>
			<select type="text" name="remarks" class="" style="font-size: 16px; color: #81386e; padding: 3px; width: 180px; height: 32.5px;" required>
					<option selected></option>
					<option>Paid</option>
					<option>Settlement</option>
					<option>Passdue</option>
			</select>
			<button id="info" name="submit" style="width: 80px; height: 35px; margin-left: 10px; background: #009879;"><i class="fa fa-search"></i> Filter</button>
		</form>
		
		</div>


	<div class="scroll">
		<table id="customers" style="margin-top: 10px;">
			<tr>
				<th>Create Date</th>
				<th>Name</th>
				<th>Amount</th>
				<th>Extra</th>
				<th>Method</th>
				<th>Actual Payment</th>
				<th>Last Update</th>
				<th>Operator</th>
				<th>Remarks</th>
			</tr>
			<?php
				
				if(isset($_POST['submit'])){
				$from=date('m-d-Y', strtotime($_POST['from']));
				$to=date('m-d-Y', strtotime($_POST['to']));
				$remarks=$_POST['remarks'];

				if($from > $to){
					echo '<p class="err" style="margin-top: 13px;">Start date must be less than end date.</p>';
				}
		
				$sql="SELECT * FROM ledger WHERE update_date BETWEEN '$from' AND '$to' AND remarks LIKE '%$remarks%'";
	 			$query=mysql_query($sql);
	 			if (mysql_num_rows($query) > 0) {
	 					echo '';
	 				}else{
	 					echo '<p class="err" style="margin-top: 13px;">No record found.</p>';
	 				}
	 			 $rows=0;
	 			while($recordset=mysql_fetch_array($query)){
	 				$rows++;
	 				$total_target+=$recordset['payamount'];
	 				$total_extra+=$recordset['extrapay'];
	 				$total_payment+=$recordset['payment'];
	 				$sub_total=$total_target+$total_extra-$total_payment;
	 				if($recordset['payment']!=''){
	 					$total_profit+=$recordset['profit'];
	 				}
			?>
			
			<tr>
				<td id="td"><?php echo $recordset['duedate']; ?></td>
				<td><?php echo $recordset['name']; ?></td>
				<td><?php echo $recordset['payamount']; ?></td>
				<td><?php echo $recordset['extrapay']; ?></td>
				<td><?php 
				if($recordset['method']=='Cash'){
					echo '<span style="color: white; background: #ffc107; border-radius: 4px;">'; 
					echo  $recordset['method'];
					echo '</span>';
					}
					if($recordset['method']=='GCash'){
					echo '<span style="color: white; background: blue; border-radius: 4px;">'; 
					echo  $recordset['method'];
					echo '</span>';
					} 

				?></td>
				<td><?php echo $recordset['payment']; ?></td>
				<td><?php echo $recordset['update_date']; ?></td>
				<td><?php echo $recordset['operator']; ?></td>
				<td><?php echo $recordset['remarks']; ?></td>
				
			</tr>

			<?php
			}
			}else{
				/*Default pagination.*/
				$start_from = ($ID-1) * $record_per_page;
				$sql="SELECT * FROM ledger WHERE payment != '' ORDER BY ID ASC LIMIT $start_from, $record_per_page";
				$query=mysql_query($sql);
				
				$rows_update=0;
				while($recordset=mysql_fetch_array($query)){
					$rows_update++;
					$rows_total=$rows_update-$row_suc;
					$total_target+=$recordset['payamount'];
	 				$total_extra+=$recordset['extrapay'];
	 				$total_payment+=$recordset['payment'];
	 				$sub_total=$total_target+$total_extra-$total_payment;
	  		?>
	  		<tr>
	  			<td><?php echo $recordset['duedate']; ?></td>
				<td><?php echo $recordset['name']; ?></td>
				<td><?php echo $recordset['payamount']; ?></td>
				<td><?php echo $recordset['extrapay']; ?></td>
				<td><?php 
				if($recordset['method']=='Cash'){
					echo '<span style="color: white; background: #ffc107; border-radius: 4px;">'; 
					echo  $recordset['method'];
					echo '</span>';
					}
					if($recordset['method']=='GCash'){
					echo '<span style="color: white; background: blue; border-radius: 4px;">'; 
					echo  $recordset['method'];
					echo '</span>';
					} 

				?></td>
				<td><?php echo $recordset['payment']; ?></td>
				<td><?php echo $recordset['update_date']; ?></td>
				<td><?php echo $recordset['operator']; ?></td>
				<td><?php echo $recordset['comment']; ?></td>
	  		</tr>
	  		<?php	
			}

			}
	  		?>
	  		<tr>
	  			<td colspan="2" style="text-align: center; color: #009879;">Total</td>
	  			<td style="color: #009879;"><?php echo number_format($total_target); ?></td>
	  			<td style="color: #009879;"><?php echo number_format($total_extra, 2); ?></td>
	  			<td></td>
	  			<td style="color: #009879;"><?php echo number_format($total_payment, 2); ?></td>
	  			<td></td>
	  			<td></td>
	  			<td></td>
	  		</tr>
		</table>

		<?php
		if(isset($_POST['submit'])){
			//Do nothing.
		}else{
		$total_records = mysql_num_rows($query);
		$total_pages = ceil($total_records/$record_per_page);
		$start_loop = $ID;
		$difference = $total_pages - $ID;
		if($difference <= 10){
			$start_loop - 10;
		}
		$end_loop = $start_loop + 3;
		if($ID > 1){
			echo "<a href='success_payment.php?ID=1'><button style='border: 1px solid grey; border-radius: 2px; width: 40px; height: 30px; font-size: 16px; cursor: pointer; line-height: 15px; background: rgb(245 245 245); color: #009879;'>first</button></a>";
			echo "<a href='success_payment.php?ID=".($ID - 1)."'><button style='border: 1px solid grey; width: 30px; height: 30px; font-size: 16px; cursor: pointer; line-height: 15px; background: rgb(245 245 245); color: #009879;'><<</button></a>";
		}
		for($i=$start_loop; $i<=$end_loop; $i++)
		{
			echo "<a href='success_payment.php?ID=".$i."'><button style='border: 1px solid grey; width: 30px; height: 30px; font-size: 16px; cursor: pointer; line-height: 15px; background: rgb(245 245 245); color: #009879;'>".$i."</button></a>";
		}
		if($ID <= $end_loop){
			echo "<a href='success_payment.php?ID=".($ID + 1)."'><button style='border: 1px solid grey; width: 30px; height: 30px; font-size: 16px; cursor: pointer; line-height: 15px; background: rgb(245 245 245); color: #009879;'>>></button></a>";
			echo "<a href='success_payment.php?ID=".$total_pages."'><button style='border: 1px solid grey; border-radius: 2px; width: 40px; height: 30px; font-size: 16px; cursor: pointer; line-height: 15px; background: rgb(245 245 245); color: #009879;'>last</button></a>";
		}
		}
		
		?>

	</div>
	<div class="summary">
	<?php
		if($rows!=0){

			echo '<p style="color: #009879; margin-left: 10px;">Total filtered row: ' .$rows. '</p>';
			echo '<p style="color: #e56b62; margin-left: 10px;">Total Passdue Unsettled Payments / Recievable: <span>&#8369;</span> ' .$sub_total. '</p>';
			echo '<p style="color: #009879; margin-left: 10px;">Total Income: <span>&#8369;</span> ' .$total_profit. '</p>';

		}else{

			echo '<p style="color: #009879; margin-left: 10px;">Total filtered row: ' .$rows_update. '</p>';
	

		}

		?>
	</div>
	</div>

	<div class="footer">
		<p>- LADZBILL | Version 1.0.0.1 @ 2021</p>
	</div>
</body>
</html>

