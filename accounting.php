<?php
include 'include/dbcon.php';
include 'session.php';
/*Retrieving data from tables.*/
$sql="SELECT * FROM ledger WHERE payment != ''";
$query=mysql_query($sql);
while($recordset=mysql_fetch_array($query)){
	$total_profit+=$recordset['profit'];
}

$sql="SELECT * FROM members WHERE status = 'Overdue'";
$query=mysql_query($sql);
while($recordset=mysql_fetch_array($query)){
	$total_overdue+=$recordset['balance'];
	$row_overdue++;
}

$sql="SELECT * FROM members WHERE balance != '0'";
$query=mysql_query($sql);
$row_bal = mysql_num_rows($query);
while($recordset=mysql_fetch_array($query)){
	$total_loan+=$recordset['amountloan'];
}

$sql="SELECT * FROM members";
$query=mysql_query($sql);
while($recordset=mysql_fetch_array($query)){
	$row_members++;
	$total_loan_recievable+=$recordset['balance'];
}

$sql="SELECT * FROM loan";
$query=mysql_query($sql);
while($recordset=mysql_fetch_array($query)){
	$total_principal+=$recordset['amountloan'];
	$total_sum+=$recordset['balance'];
	$row_loan++;
}
$sql="SELECT * FROM ledger WHERE payment = '' AND remarks = 'Passdue'";
$query=mysql_query($sql);
while($recordset=mysql_fetch_array($query)){
	$total_due+=$recordset['payamount'];
	$row_num++;
}

$sql="SELECT * FROM ledger WHERE remarks = 'Settlement'";
$query=mysql_query($sql);
while($recordset=mysql_fetch_array($query)){
	$row_settled++;
}

$sql="SELECT * FROM members WHERE status = 'Inactive'";
$query=mysql_query($sql);
while($recordset=mysql_fetch_array($query)){
	$row_inactive++;
}

$sql="SELECT * FROM ledger";
$query=mysql_query($sql);
while($recordset=mysql_fetch_array($query)){
		$rows_update++;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Accounting Book Chart</title>
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
		function popDelete(url){
			if(confirm("Do you really want to delete this data?")){
				window.location.href=url;
			}
			return false;
		}
</script>
<script type="text/javascript">
		function popUpdate_member(url){
			if(confirm("Do you really want to Activate this member?")){
				window.location.href=url;
			}
			return false;
		}
</script>
<script type="text/javascript">
		function popDelete_member(url){
			if(confirm("Do you really want to delete this data?")){
				window.location.href=url;
			}
			return false;
		}
</script>
<script type="text/javascript">
	function views() {
		document.getElementById('loans').style.display = 'block';
		document.getElementById('accounts').style.display = 'none';
		document.getElementById('members').style.display = 'none';
		document.getElementById('summary').style.display = 'none';
		document.getElementById('inactive').style.display = 'none';
	}
</script>
<script type="text/javascript">
	function view_members() {
		document.getElementById('members').style.display = 'block';
		document.getElementById('accounts').style.display = 'none';
		document.getElementById('loans').style.display = 'none';
		document.getElementById('summary').style.display = 'none';
		document.getElementById('inactive').style.display = 'none';
	}
</script>
<script type="text/javascript">
	function view_summary() {
		document.getElementById('summary').style.display = 'block';
		document.getElementById('members').style.display = 'none';
		document.getElementById('accounts').style.display = 'none';
		document.getElementById('loans').style.display = 'none';
		document.getElementById('inactive').style.display = 'none';
	}
</script>
<script type="text/javascript">
	function view_inactive() {
		document.getElementById('inactive').style.display = 'block';
		document.getElementById('summary').style.display = 'none';
		document.getElementById('members').style.display = 'none';
		document.getElementById('accounts').style.display = 'none';
		document.getElementById('loans').style.display = 'none';
	}
	inactive
</script>
<body style="background: white;">
	<div class="header">
		<p class="logo"><strong>|LADZ</strong>BILL</p>
			<p class="id">
				<p class="time"><?php date_default_timezone_set("ASIA/MANILA"); echo "". date('m-d-Y');?> | <p id="clock"></p></p> 
				<p class="name">|Lord:</p> 
				<input type="text" name="uid" class="acc" value="<?php echo "" .$_SESSION['uid']; ?>" size="14px;" readonly >
			</p>
		<button><a href="logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></button>
	</div>	
	<div class="container">
		<p class="dash" style="margin-left: 8px;">Accounting Chart</p>
		<div class="container-tiles">
			<div class="tiles-1">
				<p>TOTAL REVENUE *</p>
				<p style="text-align: center; font-size: 35px; background: rgb(228 130 123); color: white; height: 90px; line-height: 90px; border-radius: 4px; border-left: 20px solid rgb(245 245 245);"><span>&#8369;</span> <?php echo number_format($total_profit, 2); ?></p>
			</div>
			<div class="tiles-2">
				<p>TOTAL OVERDUE *</p>
				<p style="text-align: center; font-size: 35px; background: rgb(123 160 228); color: white; height: 90px; line-height: 90px; border-radius: 4px; border-left: 20px solid rgb(245 245 245);"><span>&#8369;</span> <?php echo number_format($total_overdue, 2);?></p>
			</div>
			<div class="tiles-3">
				<p>TOTAL ACTIVE LOAN RELEASED *</p>
				<p style="text-align: center; font-size: 35px; background: rgb(80 205 124); color: white; height: 90px; line-height: 90px; border-radius: 4px; border-left: 20px solid rgb(245 245 245);"><span>&#8369;</span> <?php echo number_format($total_loan);?></p>
				<p style="text-align: right;"><button class="view" onclick="views()"><i class="fa fa-eye"></i> View Loan Records</button></p>
			</div>
		</div>


		<div class="container-tab">
			<div class="tbl-1">
				<p>TOTAL PASSDUE RECIEVABLE *</p>
				<p style="text-align: center; font-size: 18px; background: #FF5722; color: white; line-height: 20px; border-left: 4px solid rgb(245 245 245);"><span>&#8369;</span> <?php echo number_format($total_due);?></p>
			</div>
			<div class="tbl-2">
				<p>TOTAL NO. OF PASSDUE *</p>
				<p style="text-align: center; font-size: 18px; background: #FF5722; color: white; line-height: 20px; border-left: 4px solid rgb(245 245 245);"><i class="fa fa-user"></i> <?php echo $row_num;?></p>
			</div>
			<div class="tbl-3">
				<p>TOTAL NO. OF OVERDUE *</p>
				<p style="text-align: center; font-size: 18px; background: #FF5722; color: white; line-height: 20px; border-left: 4px solid rgb(245 245 245);"><i class="fa fa-user"></i> <?php echo $row_overdue;?></p>
			</div>
			<div class="tbl-4">
				<p>TOTAL NO. OF MEMBERS *</p>
				<p style="text-align: center; font-size: 18px; background: #FF5722; color: white; line-height: 20px; border-left: 4px solid rgb(245 245 245);"><i class="fa fa-user"></i> <?php echo $row_members;?></p>
				<p style="text-align: right;"><button class="view" onclick="view_members()" style="background: #FF5722;"><i class="fa fa-eye"></i> View Members</button></p>
			</div>
		</div>

		<div class="container-tab-1">
			<div class="tbl-1">
				<p>TOTAL PAYMENT RECIEVABLE *</p>
				<p style="text-align: center; font-size: 18px; background: #FF5722; color: white; line-height: 20px; border-left: 4px solid rgb(245 245 245);"><span>&#8369;</span> <?php echo number_format($total_loan_recievable, 2);?></p>
			</div>
			<div class="tbl-2">
				<p>TOTAL MEMBERS W/ ACTIVE LOAN *</p>
				<p style="text-align: center; font-size: 18px; background: #FF5722; color: white; line-height: 20px; border-left: 4px solid rgb(245 245 245);"><i class="fa fa-user"></i> <?php echo $row_bal;?></p>
			</div>
			<div class="tbl-3">
				<p>TOTAL PASSDUE SETTLED PAYMENTS *</p>
				<p style="text-align: center; font-size: 18px; background: #FF5722; color: white; line-height: 20px; border-left: 4px solid rgb(245 245 245);"><i class="fa fa-user"></i> <?php echo $row_settled;?></p>
			</div>
			<div class="tbl-4">
				<p>TOTAL NO. OF MEMBERS INACTIVE *</p>
				<p style="text-align: center; font-size: 18px; background: #FF5722; color: white; line-height: 20px; border-left: 4px solid rgb(245 245 245);"><i class="fa fa-user"></i> <?php echo $row_inactive;?></p>
				<p style="text-align: right;"><button class="view" onclick="view_inactive()" style="background: #FF5722;"><i class="fa fa-eye"></i> View Inactive Members</button></p>
			</div>
		</div>

		<div class="container-tab-1">
			<div class="tbl-5">
				<p>TOTAL NO. OF LOAN SUMMARY *</p>
				<p style="text-align: center; font-size: 18px; background: #FF5722; color: white; line-height: 20px; border-left: 4px solid rgb(245 245 245);"> <?php echo $row_loan;?></p>
			</div>
			<div class="tbl-6">
				<p>PRINCIPAL *</p>
				<p style="text-align: center; font-size: 18px; background: #FF5722; color: white; line-height: 20px; border-left: 4px solid rgb(245 245 245);"><span>&#8369;</span> <?php echo number_format($total_principal);?></p>
			</div>
			<div class="tbl-7">
				<p>PRINCIPAL W/ INTEREST *</p>
				<p style="text-align: center; font-size: 18px; background: #FF5722; color: white; line-height: 20px; border-left: 4px solid rgb(245 245 245);"><span>&#8369;</span> <?php echo number_format($total_sum);?></p>
			</div>
			<div class="tbl-8">
				<p>ACTION *</p>
				<p style="text-align: right;"><button class="view" onclick="view_summary()" style="background: #FF5722;"><i class="fa fa-eye"></i> View Summary Records</button></p>
			</div>
		</div>
		<p class="dash" style="font-size: 25px; margin-top: 10px;"><a href="income_statement.php?" target="_blank"><button id="info" name="" onclick="page()" style="width: 175px; height: 45px; margin-top: 10px; background: #12a51d;"><i class="fa fa-print"></i> Income Statement</button></a></p>
		<p class="dash" style="font-size: 25px; margin-top: 10px;">Master Records</p>
		<div class="container-acc" id="accounts">
			<table id="customers" id="tbl_data">
			<tr>
				<th>Users Account | Name</th>
				<th>Address</th>
				<th>Contact No.</th>
				<th>Email Address</th>
				<th>UserID</th>
				<th>Action</th>
			</tr>
			<?php  
			$sql="SELECT * FROM access";
	 		$query=mysql_query($sql);
	 		while($recordset=mysql_fetch_array($query)){
	 			$row_users++;
			?>
			<tr>
				<td><?php echo $recordset['fullname']; ?></td>
				<td style="width: 200px;"><?php echo $recordset['address']; ?></td>
				<td><?php echo $recordset['phone']; ?></td>
				<td><?php echo $recordset['email']; ?></td>
				<td><?php echo $recordset['uid']; ?></td>
				<td><a href="#tbl_data" onclick="popDelete('delete_user.php?ID=<?php echo $recordset['ID'];?>')" ><button id="info" style="background: #ef3b3b; width: 30px;"><i class="fa fa-trash"></i></button></a></td>
			</tr>
			<?php
			}
			?>
			</table>
		</div>

		<div class="container-acc" id="loans" style="display: none;">
			<table id="customers" id="tbl_data">
			<tr>
				<th>Account No.</th>
				<th>Name</th>
				<th>Amount Loan</th>
				<th>Balance</th>
				<th>Loan Status</th>
				<th>Add. Interest</th>
				<th>Operator</th>
			</tr>
			<?php  
			$sql="SELECT * FROM members WHERE balance != '0'";
	 		$query=mysql_query($sql);
	 		while($recordset=mysql_fetch_array($query)){
	 			$total_members_loan+=$recordset['amountloan'];
	 			$total_members_bal+=$recordset['balance'];
			?>
			<tr>
				<td><?php echo $recordset['accno']; ?></td>
				<td><?php echo $recordset['fullname']; ?></td>
				<td><?php echo $recordset['amountloan']; ?></td>
				<td><?php echo $recordset['balance']; ?></td>
				<td><?php echo $recordset['status']; ?></td>
				<td><?php echo $recordset['add_interest']; ?></td>
				<td><?php echo $recordset['operator']; ?></td>
			</tr>
			<?php
			}
			?>
			<tr>
				<td colspan="2" style="color: #009879; text-align: center;">Total</td>
				<td style="color: #009879;"><?php echo number_format($total_members_loan); ?></td>
				<td style="color: #009879;"><?php echo number_format($total_members_bal, 2); ?></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>

		<div class="container-acc" id="members" style="display: none;">
			<table id="customers" id="tbl_members">
			<tr>
				<th>Account No.</th>
				<th>Name</th>
				<th>Amount Loan</th>
				<th>Balance</th>
				<th>Loan Status</th>
				<th>Add. Interest</th>
				<th>Action</th>
			</tr>
			<?php  
			$sql="SELECT * FROM members";
	 		$query=mysql_query($sql);
	 		while($recordset=mysql_fetch_array($query)){

			?>
			<tr>
				<td><?php echo $recordset['accno']; ?></td>
				<td><?php echo $recordset['fullname']; ?></td>
				<td><?php echo $recordset['amountloan']; ?></td>
				<td><?php echo $recordset['balance']; ?></td>
				<td><?php echo $recordset['status'];?></td>
				<td><?php echo $recordset['add_interest']; ?></td>
				<td>
				<a href="#tbl_members" onclick="popDelete_members('delete_user.php?ID=<?php echo $recordset['ID'];?>')" ><button id="info" style="background: #16b330; width: 30px;"><i class="fa fa-pencil"></i></button></a>
				<a href="#tbl_members" onclick="popDelete_member('delete_user.php?ID=<?php echo $recordset['ID'];?>')" ><button id="info" style="background: #ef3b3b; width: 30px;"><i class="fa fa-trash"></i></button></td>
			</tr>
			<?php
			}
			?>
			</table>
		</div>

		<div class="container-acc" id="summary" style="display: none;">
			<table id="customers" id="tbl_data">
			<tr>
				<th>Account No.</th>
				<th>Date Release</th>
				<th>Amount Loan</th>
				<th>Interest</th>
				<th>No. of Payment</th>
				<th>Duration</th>
				<th>Fee</th>
				<th>Amount w/ Interest</th>
				<th>Operator</th>
				
			</tr>
			<?php  
			$sql="SELECT * FROM loan";
	 		$query=mysql_query($sql);
	 		while($recordset=mysql_fetch_array($query)){
	 			$total_amount_loan+=$recordset['amountloan'];
	 			$total_amount_fee+=$recordset['service_fee'];
	 			$total_amount_bal+=$recordset['balance'];
			?>
			<tr>
				<td><?php echo $recordset['accnumber']; ?></td>
				<td><?php echo $recordset['date_loan']; ?></td>
				<td><?php echo $recordset['amountloan']; ?></td>
				<td><?php echo $recordset['interest_rate']; ?></td>
				<td><?php echo $recordset['num_pay']; ?></td>
				<td><?php echo $recordset['loan_due']; ?></td>
				<td><?php echo $recordset['service_fee']; ?></td>
				<td><?php echo $recordset['balance']; ?></td>
				<td><?php echo $recordset['processed_by']; ?></td>
			</tr>
			<?php
			}
			?>
			<tr>
				<td colspan="2" style="color: #009879; text-align: center;">Total</td>
				<td style="color: #009879;"><?php echo number_format($total_amount_loan); ?></td>
				<td></td>
				<td></td>
				<td></td>
				<td style="color: #009879;"><?php echo number_format($total_amount_fee, 2); ?></td>
				<td style="color: #009879;"><?php echo number_format($total_amount_bal, 2); ?></td>
			</tr>
			</table>
		</div>

		<div class="container-acc" id="inactive" style="display: none;">
			<table id="customers" id="tbl_activate">
			<tr>
				<th>Account No.</th>
				<th>Name</th>
				<th>Amount Loan</th>
				<th>Balance</th>
				<th>Loan Status</th>
				<th>Add. Interest</th>
				<th>Action</th>
			</tr>
			<?php  
			$sql="SELECT * FROM members WHERE status = 'Inactive'";
	 		$query=mysql_query($sql);
	 		while($recordset=mysql_fetch_array($query)){

			?>
			<tr>
				<td><?php echo $recordset['accno']; ?></td>
				<td><?php echo $recordset['fullname']; ?></td>
				<td><?php echo $recordset['amountloan']; ?></td>
				<td><?php echo $recordset['balance']; ?></td>
				<td><?php echo $recordset['status'];?></td>
				<td><?php echo $recordset['add_interest']; ?></td>
				<td><a href="#tbl_activate" onclick="popUpdate_member('activate_member.php?ID=<?php echo $recordset['ID'];?>')" ><button id="info" style="background: #009879; width: 43px;">ACT</button></a></td>
			</tr>
			<?php
			}
			?>
			</table>
			<?php
			$sql="SELECT * FROM members WHERE status = 'Inactive'";
			$query=mysql_query($sql);
			$recordset=mysql_fetch_array($query);
			$row = mysql_num_rows($query);
				if($row == 0){
					echo '<p style="width: 95.7%; text-align:center; color:#e56b62;">No Inactive record found in the table.</p>';
				}else{
					echo '';
				}
			?>

		</div>

	</div>
</body>
</html>