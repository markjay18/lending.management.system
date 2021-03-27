<?php 
include 'include/dbcon.php';
include 'session.php';

/*get members account number*/
$ID=0;
if(isset($_GET['ID'])){
 $ID = $_GET['ID'];
}

  $sql="SELECT * FROM members WHERE ID='".$ID."'";
  $query=mysql_query($sql);
  $recordsetQ=mysql_fetch_array($query);

  	if(isset($_POST['save'])){
		$status = $_POST['status'];
		$balance = $_POST['balance'];
		$add_interest = $_POST['add_interest'];
		$sqlQ="UPDATE members SET status='".$status."', balance='".$balance."', add_interest='".$add_interest."' WHERE ID='".$ID."'";
		$update = mysql_query($sqlQ) or die(mysql_error());

		header('Location:disbursement_view.php?accno='.$recordsetQ['accno']);
	}

	$sql="SELECT * FROM loan WHERE accnumber='".$recordsetQ['accno']."'";
	$query=mysql_query($sql);
	$recordset=mysql_fetch_array($query);
	$row = mysql_num_rows($query);

	$sql="SELECT * FROM ledger WHERE accno='".$recordsetQ['accno']."' AND remarks='Passdue'";
	$query=mysql_query($sql);
	$recordset=mysql_fetch_array($query);
	$row_passdue = mysql_num_rows($query);

	$sql="SELECT * FROM ledger WHERE accno='".$recordsetQ['accno']."' AND remarks='Settlement'";
	$query=mysql_query($sql);
	$recordset=mysql_fetch_array($query);
	$row_settled = mysql_num_rows($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Loan Disbursement Info</title>
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
<script>
	/*autocomplete field current script*/
$(document).ready(function (){
$('#select').change(function (){
		var add = $('#current').val();
		var cur = $('#additional').val(); 
		var sum = parseFloat(add) * parseFloat(cur);
		var total = sum + parseFloat(add)
		$("#plus").val(sum);
		$("#current").val(total);
		
	});		
});
</script>
<script>
	/*Showing link for passdue payment not equal to 0*/
$(document).ready(function (){
		if($('#passdue').val() > 0){
			$('#link').show();
			$('#passdue').show();
		}else{
			$('#link').hide();
			$('#passdue').show();
		}
		
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
			<li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="membership.php"><i class="fa fa-user-plus"></i> Association</a></li>
			<li><a href="" class="<?php echo (!isset($_GET['page'])) ? "active" : ""; ?>"><i class="fa fa-user"></i>  Personal Loan</a></li>
			<li><a href="marketing.php"><i class="fa fa-calendar-check-o"></i> Marketing</a></li>
			<li><a href="collection.php"><i class="fa fa-money"></i> Collections</a></li>
			<div id="cancel"><</div>
		</ul>
	</nav>

	<div id="frame">
			<p class="dash">Account Info.</p>
			<p class="direction">Loan Management System > Personal Loan > Account Info. > Update</p>
			<p class="line"></p>
			<?php
			$sql="SELECT * FROM ledger WHERE accno='".$recordsetQ['accno']."' ORDER BY ID DESC LIMIT 1";
	 		$query=mysql_query($sql);
	 		$row_fetch=mysql_fetch_row($query);

	 		$sql="SELECT * FROM members WHERE ID='".$ID."'";
  			$query=mysql_query($sql);
 			$recordsetQ=mysql_fetch_array($query);

	 		if($row_fetch[1] < date('m-d-Y') && $recordsetQ['balance']!='0' && $recordsetQ['status']=='Active'){
	 			echo '<p class="err">This member is overdue. Please add interest and update members status.</p>';

	 		}elseif($row_fetch[1] <= date('m-d-Y') && $recordsetQ['balance']=='0' && $recordsetQ['status']=='Active'){
	 			echo '<p class="succ">This member is ready for the next release.</p>';

			}elseif($row_fetch[1] > date('m-d-Y') && $recordsetQ['balance']=='0' && $recordsetQ['status']=='Active'){
				echo '<p class="succ">This member is ready for the next release.</p>';

			}elseif($row_fetch[1] < date('m-d-Y') && $recordsetQ['balance']!='0' && $recordsetQ['status']=='Overdue' && $recordsetQ['add_interest']!=''){
	 			echo '<p class="err" style="background:#898ec8;">This member has already posted additional interest. Please send notice demand letter.</p>';

			}elseif($row_fetch[1] >= date('m-d-Y') && $recordsetQ['balance']!='0' && $recordsetQ['status']=='Active'){
				echo '<p class="succ">This member has existing loan.</p>';

			}else{
	 			echo '<p class="err">There is no loan information found. The member must have an active loan.</p>';
	 		}
			?>
			<label>Account Number : </label>
			<input type="text" name="accno" class="view_input" value="<?php echo $recordsetQ['accno']; ?>" readonly required>

			<label>Date Joined : </label>
			<input type="text" name="dater" class="view_input" value="<?php echo $recordsetQ['dater']; ?>" readonly required><br>

			<label>Name : </label>
			<input type="text" name="fullname" class="view_input" value="<?php echo $recordsetQ['fullname']; ?>" readonly required><br>

			<label>Address : </label>
			<input type="text" style="width: 70%;" name="address" class="view_input" value="<?php echo $recordsetQ['address']; ?>" readonly required><br>

			<label>Contact Number : </label>
			<input type="text" style="width: 40%;" name="contact" class="view_input" value="<?php echo $recordsetQ['contact']; ?>" readonly required><br>

			<label>Email Address : </label>
			<input type="text" name="email" class="view_input" value="<?php echo $recordsetQ['email']; ?>" readonly required><br>

			<label>Current Status : </label>
			<input type="text" name="status" class="view_input" value="<?php echo $recordsetQ['status']; ?>" readonly required><br>

			<label style="color: #16b330;">Loan Cycle : </label>
			<input type="text" name="status" class="view_input" value="<?php echo $row; ?>" readonly required><br>

			<label style="float: left; color: #ef3b3b;">Passdue Payment : </label>
			<input type="text" style="width: 1.3%;" name="" id="passdue" class="view_input" value="<?php echo $row_passdue; ?>" readonly required><br>

			<label style="float: left; color: #009879;">Passdue Settled : </label>
			<input type="text" style="width: 1.3%;" name="" id="passdue" class="view_input" value="<?php echo $row_settled; ?>" readonly required><br>

			<label>Additional Interest : </label>
			<input type="text" name="status" class="view_input" value="<?php echo $recordsetQ['add_interest']; ?>" readonly required><br>

			<label>Current Amount Loan : </label><br>
			<input type="text" style="font-size: 28px;" name="amountloan" class="view_input" value="<?php echo $recordsetQ['amountloan']; ?>" readonly required><br>

		<form method="POST" onsubmit="return confirm('Confirm? Ok/Cancel.')">

			<label>Current Balance (autocomplete) : </label><br>
			<input type="text" style="font-size: 28px;" id="current" name="balance" class="view_input" value="<?php echo $recordsetQ['balance']; ?>" readonly required><br>

			<label>+ (autocomplete) : </label><br>
			<input type="text" style="font-size: 28px;" id="plus" name="balance" class="view_input" readonly required>

			<div style="width: 14%;">
				<label>Additional Interest rate *</label><br>
				<input type="text" id="additional" name="add_interest" class="input">
			</div>
			<div style="width: 14%;">	
				<label>Update Member Status to : </label><br>
				<select type="text" name="status" id="select" class="input" required>
					<option selected></option>
					<option>Inactive</option>
					<option>Overdue</option>
				</select>
			</div>
			<p class="line"></p>
			<button name="save" class="button" style="width: 12%; float: left;"><i class="fa fa-save"></i> Save Change</button>
		</form>

			<p class="top" style="width: 96%;">Member's Loan History</p>
	<div class="scroll">
		<table id="customers">
			<tr>
				<th>Date</th>
				<th>Amount</th>
				<th>Invoice#</th>
				<th>OR#</th>
				<th>Interest</th>
				<th>Number of Payment</th>
				<th>Temure (month)</th>
				<th>Service Fee</th>
				<th>Open Balance</th>
			</tr>
			<?php  
			$sql="SELECT * FROM loan WHERE accnumber='".$recordsetQ['accno']."'";
	 		$query=mysql_query($sql);
	 		while($recordset=mysql_fetch_array($query)){
	 			$total_settled+=$recordset['amountloan'];
	 			$total_settled_open+=$recordset['balance'];
	 			$total_fee+=$recordset['service_fee'];
			?>
			<tr>
				<td><?php echo $recordset['date_loan']; ?></td>
				<td><?php echo $recordset['amountloan']; ?></td>
				<td><?php echo $recordset['invoice']; ?></td>
				<td><?php echo $recordset['ref']; ?></td>
				<td><?php echo $recordset['interest_rate']; ?></td>
				<td><?php echo $recordset['num_pay']; ?></td>
				<td><?php echo $recordset['loan_due']; ?></td>
				<td><?php echo $recordset['service_fee']; ?></td>
				<td><?php echo $recordset['balance']; ?></td>
			</tr>
		<?php
	  		}
	  	?>
	  		<tr>
	  			<td style="text-align: center; color: #009879;">Total</td>
	  			<td style="color: #009879;"><?php echo number_format($total_settled); ?></td>
	  			<td></td>
	  			<td></td>
	  			<td></td>
	  			<td></td>
	  			<td></td>
	  			<td style="color: #009879;"><?php echo number_format($total_fee, 2); ?></td>
	  			<td style="color: #009879;"><?php echo number_format($total_settled_open, 2); ?></td>
	  		</tr>
		</table>

		<?php
		$sql="SELECT * FROM loan WHERE accnumber='".$recordsetQ['accno']."'";
		$query=mysql_query($sql);
		$recordset=mysql_fetch_array($query);
		$row = mysql_num_rows($query);
		if($row == 0){
			echo '<p style="width: 95.7%; text-align:center; color:#e56b62;">No loan history record found in the table.</p>';
		}else{
			echo '';
		}
		?>
	</div>

			<p class="top">Member's Master Ledger</p>
			<div style="width: 96%; display: inline-flex;">
				<label style="margin-top: 6px;" >Select remarks :</label> 
				<form method="POST">
					<select type="text" name="status" style="font-size: 16px; height: 30px; margin-left: 10px; width: 200px;" required>
						<option selected></option>
						<option>Passdue</option>
					</select>
					<button id="info" name="submit" style="width: 80px; height: 30px; margin-left: 10px; background: #009879;"><i class="fa fa-search"></i> Search</button>
				</form>
			</div>
	<div class="scroll">
		<table id="customers">
			<tr>
				<th>Create Date</th>
				<th>Amount</th>
				<th>Payment</th>
				<th>OR#</th>
				<th>Extra</th>
				<th>Method</th>
				<th>Last Update</th>
				<th>Operator</th>
				<th>Remarks</th>
				<th>Action</th>
			</tr>
			<?php 
			if(isset($_POST['submit'])){
			$sql="SELECT * FROM ledger  WHERE accno='".$recordsetQ['accno']."' AND remarks = 'Passdue' AND payment = ''";
	 		$queryl=mysql_query($sql);
	 		while($recordset=mysql_fetch_array($queryl)){
			?>
			<tr>
				<td><?php echo $recordset['duedate']; ?></td>
				<td><?php echo $recordset['payamount']; ?></td>
				<td><?php echo $recordset['payment']; ?></td>
				<td><?php echo $recordset['ref']; ?></td>
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
				<td><?php echo $recordset['update_date']; ?></td>
				<td><?php echo $recordset['operator']; ?></td>
				<td><?php echo $recordset['remarks']; ?></td>
				<td><a href="passdue_settle.php?ID=<?php echo $recordset['ID']; ?>&&accno=<?php echo $recordset['accno']; ?>" id="link" target="_blank"><button id="info" style="width: 40px;">Pay</button></a></td>
			</tr>
		
			<?php
	  		}
	  		}else{
	  			$sql="SELECT * FROM ledger  WHERE accno='".$recordsetQ['accno']."'";
	 			$queryl=mysql_query($sql);
	 			while($recordset=mysql_fetch_array($queryl)){
	 				$total_settled_amount+=$recordset['payamount'];
	 				$total_settled_payments+=$recordset['payment'];
	  		?>
	  		<tr>
				<td><?php echo $recordset['duedate']; ?></td>
				<td><?php echo $recordset['payamount']; ?></td>
				<td><?php echo $recordset['payment']; ?></td>
				<td><?php echo $recordset['ref']; ?></td>
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
				<td><?php echo $recordset['update_date']; ?></td>
				<td><?php echo $recordset['operator']; ?></td>
				<td><?php echo $recordset['remarks']; ?></td>
				<td></td>
			</tr>
	  	<?php
	  	}
		}
	  	?>
	  	<tr>
	  			<td style="text-align: center; color: #009879;">Total</td>
	  			<td style="color: #009879;"><?php echo number_format($total_settled_amount); ?></td>
	  			<td style="color: #009879;"><?php echo number_format($total_settled_payments, 2); ?></td>
	  			<td></td>
	  			<td></td>
	  			<td></td>
	  			<td></td>
	  			<td></td>
	  			<td></td>
	  			<td></td>
	  		</tr>
		</table>

		<?php
		$sql="SELECT * FROM ledger WHERE accno='".$recordsetQ['accno']."'";
		$query=mysql_query($sql);
		$recordset=mysql_fetch_array($query);
		$row = mysql_num_rows($query);
		if($row == 0){
			echo '<p style="width: 95.7%; text-align:center; color:#e56b62;">No ledger record found in the table.</p>';
		}else{
			echo '';
		}
		?>
	</div>
		<p style="color: #009879; margin-left: 10px; border-left: 4px solid #009879; padding-left: 10px;">Over All Total Loan History : <span>&#8369;</span> <?php echo number_format($total_settled); ?></p>
		<p style="color: #009879; margin-left: 10px; border-left: 4px solid #009879; padding-left: 10px;">Over All Total Loan History w/ Interest : <span>&#8369;</span> <?php echo number_format($total_settled_open, 2); ?></p>
		<p style="color: #009879; margin-left: 10px; border-left: 4px solid #009879; padding-left: 10px;">Over All Total Loan Payments Settled: <span>&#8369;</span> <?php echo number_format($total_settled_payments, 2); ?></p>
		<p class="line"></p>
		<a href="print_ledger.php?accno=<?php echo $recordsetQ['accno'];?>" target="_blank"><button name="" visibility="hidden" class="button" style="width: 10%; background: #f44336; float: left; margin-left: 5px;"><i class="fa fa-print"></i> Print Ledger</button></a>
		<a href="print_soa.php?accno=<?php echo $recordsetQ['accno'];?>" target="_blank"><button name="" visibility="hidden" class="button" style="width: 9%; background: #009879; float: left; margin-left: 5px;"> <i class="fa fa-print"></i> Print S.O.A</button></a>
	</div>

	<div class="footer">
		<p>- LADZBILL | Version 1.0.0.1 @ 2021</p>
	</div>
</body>
</html>
</html>